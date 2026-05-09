<?php

namespace App\Livewire;

use App\Models\DailyWish;
use App\Models\Post;
use App\Models\PracticeProfile;
use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Models\Utility;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.layouts.dashboard')]
class DashboardPage extends Component
{
    use WithFileUploads;

    public string $activeSection = 'tong-quan';
    public bool $showScriptureModal = false;
    public bool $showCategoryModal = false;
    public bool $showPostModal = false;
    public bool $showUtilityModal = false;
    public bool $showDailyWishModal = false;

    public array $scriptureForm = [
        'title' => '',
        'category_id' => '',
        'duration_minutes' => 0,
        'chant_count' => 0,
        'summary' => '',
        'image_url' => '',
        'reader_mode' => 'auto',
    ];

    public array $postForm = [
        'title' => '',
        'excerpt' => '',
        'image_url' => '',
        'published_at' => '',
    ];

    public array $categoryForm = [
        'name' => '',
        'description' => '',
    ];

    public array $utilityForm = [
        'name' => '',
        'icon_url' => '',
        'link_url' => '',
        'sort_order' => 1,
        'is_active' => true,
    ];

    public string $practiceProfileSearch = '';

    public array $dailyWishForm = [
        'text' => '',
        'icon' => 'lotus',
        'sort_order' => 0,
        'is_active' => true,
    ];

    public ?int $editingDailyWishId = null;

    public ?int $editingScriptureId = null;
    public ?int $editingPostId = null;
    public ?int $editingCategoryId = null;
    public ?int $editingUtilityId = null;

    public $scriptureImageFile = null;
    public $scriptureContentFile = null;
    public $postImageFile = null;
    public ?string $scriptureImagePreview = null;
    public ?string $postImagePreview = null;

    public ?string $migrateFlash = null;

    public ?string $migrateFlashType = null;

    public function setSection(string $section): void
    {
        $this->activeSection = $section;
        $this->dispatch('dashboard-section-changed');
    }

    public function runPendingMigrations(): void
    {
        $this->migrateFlash = null;
        $this->migrateFlashType = null;

        $pending = $this->pendingMigrationNames();

        if ($pending === []) {
            $this->migrateFlash = 'Không có migration nào đang chờ chạy.';
            $this->migrateFlashType = 'info';

            return;
        }

        $exitCode = Artisan::call('migrate', ['--force' => true]);
        $output = trim(Artisan::output());

        if ($exitCode !== 0) {
            $this->migrateFlash = $output !== '' ? $output : 'Chạy migrate không thành công.';
            $this->migrateFlashType = 'error';

            return;
        }

        $this->migrateFlash = $output !== '' ? $output : 'Đã chạy migrate thành công.';
        $this->migrateFlashType = 'success';
    }

    /**
     * @return list<string>
     */
    protected function pendingMigrationNames(): array
    {
        try {
            $migrator = app('migrator');

            if (! $migrator->repositoryExists()) {
                return [];
            }

            $files = $migrator->getMigrationFiles([database_path('migrations')]);
            $ran = $migrator->getRepository()->getRan();

            return collect($files)->keys()->diff($ran)->values()->all();
        } catch (\Throwable) {
            return [];
        }
    }

    public function openScriptureModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editScripture($id);
        } else {
            $this->resetScriptureForm();
        }
        $this->showScriptureModal = true;
    }

    public function closeScriptureModal(): void
    {
        $this->showScriptureModal = false;
        $this->resetScriptureForm();
    }

    public function saveScripture(): void
    {
        $existingScripture = $this->editingScriptureId
            ? Scripture::query()->find($this->editingScriptureId)
            : null;

        $validated = $this->validate([
            'scriptureForm.title' => ['required', 'string', 'max:255'],
            'scriptureForm.category_id' => ['nullable', Rule::exists('scripture_categories', 'id')],
            'scriptureForm.duration_minutes' => ['required', 'integer', 'min:1'],
            'scriptureForm.chant_count' => ['required', 'integer', 'min:0'],
            'scriptureForm.summary' => ['nullable', 'string'],
            'scriptureForm.image_url' => ['nullable', 'string', 'max:2048'],
            'scriptureForm.reader_mode' => ['required', Rule::in(['auto', 'pdf', 'content'])],
            'scriptureImageFile' => ['nullable', 'image', 'max:4096'],
            'scriptureContentFile' => ['nullable', 'file', 'max:10240'],
        ]);

        if ($this->scriptureImageFile) {
            $path = $this->scriptureImageFile->store('scriptures', 'public');
            $validated['scriptureForm']['image_url'] = Storage::url($path);
        }

        $validated['scriptureForm']['content_file_path'] = $existingScripture?->content_file_path;
        $validated['scriptureForm']['content_text'] = $existingScripture?->content_text ?? ($validated['scriptureForm']['summary'] ?? '');

        if ($this->scriptureContentFile) {
            $filePath = $this->scriptureContentFile->store('scripture-files', 'public');
            $validated['scriptureForm']['content_file_path'] = $filePath;
            $validated['scriptureForm']['content_text'] = $this->extractTextFromUploadedFile($this->scriptureContentFile);
        }

        Scripture::query()->updateOrCreate(
            ['id' => $this->editingScriptureId],
            $validated['scriptureForm']
        );

        $this->closeScriptureModal();
    }

    private function extractTextFromUploadedFile(UploadedFile $file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $realPath = $file->getRealPath();
        if (!$realPath) {
            return 'Không thể đọc tệp đã tải lên.';
        }

        if (in_array($extension, ['txt', 'md', 'csv', 'log'], true)) {
            return trim((string) file_get_contents($realPath));
        }

        if ($extension === 'docx') {
            try {
                $phpWord = \PhpOffice\PhpWord\IOFactory::load($realPath, 'Word2007');
                $textBlocks = [];

                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text = trim((string) $element->getText());
                            if ($text !== '') {
                                $textBlocks[] = $text;
                            }
                            continue;
                        }

                        if (method_exists($element, 'getElements')) {
                            foreach ($element->getElements() as $child) {
                                if (method_exists($child, 'getText')) {
                                    $text = trim((string) $child->getText());
                                    if ($text !== '') {
                                        $textBlocks[] = $text;
                                    }
                                }
                            }
                        }
                    }
                }

                $docxText = trim(implode("\n\n", $textBlocks));
                if ($docxText !== '') {
                    return $docxText;
                }
            } catch (\Throwable) {
                // fallback message below
            }
        }

        if ($extension === 'pdf') {
            try {
                $parser = new \Smalot\PdfParser\Parser();
                $pdf = $parser->parseFile($realPath);
                $pdfText = trim((string) $pdf->getText());

                if ($pdfText !== '') {
                    return preg_replace("/\r\n|\r/", "\n", $pdfText) ?: $pdfText;
                }
            } catch (\Throwable) {
                // fallback message below
            }
        }

        return 'Không thể trích xuất nội dung tự động từ tệp này. Vui lòng thử tệp TXT, DOCX hoặc PDF có text rõ ràng.';
    }

    public function editScripture(int $id): void
    {
        $scripture = Scripture::query()->findOrFail($id);
        $this->editingScriptureId = $id;
        $this->scriptureForm = [
            'title' => $scripture->title,
            'category_id' => $scripture->category_id,
            'duration_minutes' => $scripture->duration_minutes,
            'chant_count' => $scripture->chant_count,
            'summary' => $scripture->summary ?? '',
            'image_url' => $scripture->image_url ?? '',
            'reader_mode' => $scripture->reader_mode ?? 'auto',
        ];
        $this->scriptureImagePreview = $scripture->image_url ?: null;
    }

    public function deleteScripture(int $id): void
    {
        Scripture::query()->whereKey($id)->delete();
        if ($this->editingScriptureId === $id) {
            $this->resetScriptureForm();
        }
    }

    public function openPostModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editPost($id);
        } else {
            $this->resetPostForm();
        }
        $this->showPostModal = true;
    }

    public function closePostModal(): void
    {
        $this->showPostModal = false;
        $this->resetPostForm();
    }

    public function savePost(): void
    {
        $validated = $this->validate([
            'postForm.title' => ['required', 'string', 'max:255'],
            'postForm.excerpt' => ['nullable', 'string'],
            'postForm.image_url' => ['nullable', 'string', 'max:2048'],
            'postForm.published_at' => ['nullable', 'date'],
            'postImageFile' => ['nullable', 'image', 'max:4096'],
        ]);

        $validated['postForm']['is_featured'] = false;
        $validated['postForm']['published_at'] = filled($validated['postForm']['published_at'] ?? null)
            ? Carbon::parse($validated['postForm']['published_at'])
            : null;

        if ($this->postImageFile) {
            $path = $this->postImageFile->store('posts', 'public');
            $validated['postForm']['image_url'] = Storage::url($path);
        }

        Post::query()->updateOrCreate(
            ['id' => $this->editingPostId],
            $validated['postForm']
        );

        $this->closePostModal();
    }

    public function editPost(int $id): void
    {
        $post = Post::query()->findOrFail($id);
        $this->editingPostId = $id;
        $this->postForm = [
            'title' => $post->title,
            'excerpt' => $post->excerpt ?? '',
            'image_url' => $post->image_url ?? '',
            'published_at' => optional($post->published_at)->format('Y-m-d\TH:i'),
        ];
        $this->postImagePreview = $post->image_url ?: null;
    }

    public function deletePost(int $id): void
    {
        Post::query()->whereKey($id)->delete();
        if ($this->editingPostId === $id) {
            $this->resetPostForm();
        }
    }

    public function openCategoryModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editCategory($id);
        } else {
            $this->resetCategoryForm();
        }
        $this->showCategoryModal = true;
    }

    public function closeCategoryModal(): void
    {
        $this->showCategoryModal = false;
        $this->resetCategoryForm();
    }

    public function saveCategory(): void
    {
        $validated = $this->validate([
            'categoryForm.name' => ['required', 'string', 'max:255'],
            'categoryForm.description' => ['nullable', 'string'],
        ]);

        $validated['categoryForm']['color_class'] = 'text-[#8b5e34]';

        ScriptureCategory::query()->updateOrCreate(
            ['id' => $this->editingCategoryId],
            $validated['categoryForm']
        );

        $this->closeCategoryModal();
    }

    public function editCategory(int $id): void
    {
        $category = ScriptureCategory::query()->findOrFail($id);
        $this->editingCategoryId = $id;
        $this->categoryForm = [
            'name' => $category->name,
            'description' => $category->description ?? '',
        ];
    }

    public function deleteCategory(int $id): void
    {
        ScriptureCategory::query()->whereKey($id)->delete();
        if ($this->editingCategoryId === $id) {
            $this->resetCategoryForm();
        }
    }

    public function openUtilityModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editUtility($id);
        } else {
            $this->resetUtilityForm();
        }
        $this->showUtilityModal = true;
    }

    public function closeUtilityModal(): void
    {
        $this->showUtilityModal = false;
        $this->resetUtilityForm();
    }

    public function saveUtility(): void
    {
        $validated = $this->validate([
            'utilityForm.name' => ['required', 'string', 'max:255'],
            'utilityForm.icon_url' => ['nullable', 'url'],
            'utilityForm.link_url' => ['nullable', 'string', 'max:2048'],
            'utilityForm.sort_order' => ['required', 'integer', 'min:1'],
            'utilityForm.is_active' => ['required', 'boolean'],
        ]);

        Utility::query()->updateOrCreate(
            ['id' => $this->editingUtilityId],
            $validated['utilityForm']
        );

        $this->closeUtilityModal();
    }

    public function editUtility(int $id): void
    {
        $utility = Utility::query()->findOrFail($id);
        $this->editingUtilityId = $id;
        $this->utilityForm = [
            'name' => $utility->name,
            'icon_url' => $utility->icon_url ?? '',
            'link_url' => $utility->link_url ?? '',
            'sort_order' => $utility->sort_order,
            'is_active' => $utility->is_active,
        ];
    }

    public function deleteUtility(int $id): void
    {
        Utility::query()->whereKey($id)->delete();
        if ($this->editingUtilityId === $id) {
            $this->resetUtilityForm();
        }
    }

    public function deletePracticeProfile(int $id): void
    {
        PracticeProfile::query()->whereKey($id)->delete();
    }

    public function toggleUtility(int $id): void
    {
        $utility = Utility::query()->findOrFail($id);
        $utility->update([
            'is_active' => ! $utility->is_active,
        ]);
    }

    public function openDailyWishModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $wish = DailyWish::query()->findOrFail($id);
            $this->editingDailyWishId = $id;
            $this->dailyWishForm = [
                'text' => $wish->text,
                'icon' => $wish->icon,
                'sort_order' => $wish->sort_order,
                'is_active' => $wish->is_active,
            ];
        } else {
            $this->resetDailyWishForm();
        }
        $this->showDailyWishModal = true;
    }

    public function closeDailyWishModal(): void
    {
        $this->showDailyWishModal = false;
        $this->resetDailyWishForm();
    }

    public function saveDailyWish(): void
    {
        $validated = $this->validate([
            'dailyWishForm.text' => ['required', 'string', 'max:5000'],
            'dailyWishForm.icon' => ['required', Rule::in(['lotus', 'light', 'meditation'])],
            'dailyWishForm.sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'dailyWishForm.is_active' => ['required', 'boolean'],
        ]);

        if ($this->editingDailyWishId) {
            DailyWish::query()->whereKey($this->editingDailyWishId)->update($validated['dailyWishForm']);
        } else {
            DailyWish::query()->create($validated['dailyWishForm']);
        }

        $this->closeDailyWishModal();
    }

    public function deleteDailyWish(int $id): void
    {
        DailyWish::query()->whereKey($id)->delete();
        if ($this->editingDailyWishId === $id) {
            $this->resetDailyWishForm();
        }
    }

    public function toggleDailyWish(int $id): void
    {
        $wish = DailyWish::query()->findOrFail($id);
        $wish->update([
            'is_active' => ! $wish->is_active,
        ]);
    }

    public function resetDailyWishForm(): void
    {
        $this->editingDailyWishId = null;
        $this->dailyWishForm = [
            'text' => '',
            'icon' => 'lotus',
            'sort_order' => (int) DailyWish::query()->max('sort_order') + 1,
            'is_active' => true,
        ];
    }

    public function resetScriptureForm(): void
    {
        $this->editingScriptureId = null;
        $this->scriptureImageFile = null;
        $this->scriptureContentFile = null;
        $this->scriptureImagePreview = null;
        $this->scriptureForm = [
            'title' => '',
            'category_id' => '',
            'duration_minutes' => 0,
            'chant_count' => 0,
            'summary' => '',
            'image_url' => '',
            'reader_mode' => 'auto',
        ];
    }

    public function resetPostForm(): void
    {
        $this->editingPostId = null;
        $this->postImageFile = null;
        $this->postImagePreview = null;
        $this->postForm = [
            'title' => '',
            'excerpt' => '',
            'image_url' => '',
            'published_at' => '',
        ];
    }

    public function resetCategoryForm(): void
    {
        $this->editingCategoryId = null;
        $this->categoryForm = [
            'name' => '',
            'description' => '',
        ];
    }

    public function resetUtilityForm(): void
    {
        $this->editingUtilityId = null;
        $this->utilityForm = [
            'name' => '',
            'icon_url' => '',
            'link_url' => '',
            'sort_order' => 1,
            'is_active' => true,
        ];
    }

    public function render()
    {
        $totalScriptures = Scripture::query()->count();
        $totalPosts = Post::query()->count();

        $practiceProfileQuery = PracticeProfile::query()
            ->withCount('activities')
            ->orderByDesc('last_seen_at');

        if (filled($this->practiceProfileSearch)) {
            $term = '%' . addcslashes($this->practiceProfileSearch, '%_\\') . '%';
            $practiceProfileQuery->where('dharma_name', 'like', $term);
        }

        return view('livewire.dashboard-page', [
            'pendingMigrations' => $this->pendingMigrationNames(),
            'stats' => [
                ['label' => 'Tổng Kinh Văn', 'value' => number_format($totalScriptures), 'description' => 'Dữ liệu hiện có'],
                ['label' => 'Bài Viết', 'value' => number_format($totalPosts), 'description' => 'Đã xuất bản'],
                ['label' => 'Loại Kinh', 'value' => number_format(ScriptureCategory::query()->count()), 'description' => 'Danh mục'],
                ['label' => 'Tiện Ích', 'value' => number_format(Utility::query()->count()), 'description' => 'Đang hoạt động'],
            ],
            'scriptures' => Scripture::query()->with('category')->latest()->get(),
            'posts' => Post::query()->latest('published_at')->get(),
            'categories' => ScriptureCategory::query()->withCount('scriptures')->orderBy('name')->get(),
            'utilities' => Utility::query()->orderBy('sort_order')->get(),
            'practiceProfiles' => $practiceProfileQuery->take(500)->get(),
            'practiceProfileCount' => PracticeProfile::query()->count(),
            'dailyWishes' => DailyWish::query()->ordered()->get(),
        ]);
    }
}
