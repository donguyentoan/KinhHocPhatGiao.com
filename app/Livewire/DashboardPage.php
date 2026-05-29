<?php

namespace App\Livewire;

use App\Models\DailyWish;
use App\Models\Post;
use App\Models\PracticeActivity;
use App\Models\PracticeProfile;
use App\Models\QuizQuestion;
use App\Models\Scripture;
use App\Models\ScriptureCategory;
use App\Models\Utility;
use App\Models\VegetarianRecipe;
use App\Services\SitemapBuilder;
use App\Support\PracticeActivityPresenter;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.layouts.dashboard')]
class DashboardPage extends Component
{
    use WithFileUploads;
    use WithPagination;

    public string $activeSection = 'tong-quan';
    public bool $showScriptureModal = false;
    public bool $showCategoryModal = false;
    public bool $showPostModal = false;
    public bool $showUtilityModal = false;
    public bool $showDailyWishModal = false;
    public bool $showQuizQuestionModal = false;
    public bool $showRecipeModal = false;

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
        'content' => '',
        'image_url' => '',
        'published_at' => '',
    ];

    public array $recipeForm = [
        'title' => '',
        'slug' => '',
        'excerpt' => '',
        'ingredients' => '',
        'content' => '',
        'health_tips' => '',
        'image_url' => '',
        'prep_minutes' => '',
        'servings' => '',
        'difficulty' => 'de',
        'published_at' => '',
        'is_featured' => false,
        'sort_order' => 0,
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

    public ?int $practiceProfileHistoryId = null;

    public string $practiceActivityFilter = 'all';

    public array $dailyWishForm = [
        'text' => '',
        'icon' => 'lotus',
        'sort_order' => 0,
        'is_active' => true,
    ];

    public ?int $editingDailyWishId = null;

    public array $quizQuestionForm = [
        'topic' => '',
        'question' => '',
        'option_a' => '',
        'option_b' => '',
        'option_c' => '',
        'option_d' => '',
        'correct_answer' => 'A',
        'explanation' => '',
        'sort_order' => 1,
        'is_active' => true,
    ];

    public ?int $editingQuizQuestionId = null;

    public ?int $editingScriptureId = null;
    public ?int $editingPostId = null;
    public ?int $editingRecipeId = null;
    public ?int $editingCategoryId = null;
    public ?int $editingUtilityId = null;

    public $scriptureImageFile = null;
    public $scriptureContentFile = null;
    public $postImageFile = null;
    public $recipeImageFile = null;
    public ?string $scriptureImagePreview = null;
    public ?string $postImagePreview = null;
    public ?string $recipeImagePreview = null;

    public ?string $migrateFlash = null;

    public ?string $migrateFlashType = null;

    public ?string $sitemapFlash = null;

    public ?string $sitemapFlashType = null;

    public function setSection(string $section): void
    {
        $this->activeSection = $section;
        $this->dispatch('dashboard-section-changed');
    }

    public function updatedPracticeProfileSearch(): void
    {
        $this->resetPage('practiceProfilesPage');
    }

    public function updatedPracticeActivityFilter(): void
    {
        $this->resetPage('practiceActivitiesPage');
    }

    public function openPracticeProfileHistory(int $id): void
    {
        $this->practiceProfileHistoryId = $id;
        $this->practiceActivityFilter = 'all';
        $this->resetPage('practiceActivitiesPage');
    }

    public function closePracticeProfileHistory(): void
    {
        $this->practiceProfileHistoryId = null;
        $this->practiceActivityFilter = 'all';
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

    public function updateSitemap(): void
    {
        $this->sitemapFlash = null;
        $this->sitemapFlashType = null;

        if (! config('seo.indexing_enabled')) {
            $this->sitemapFlash = 'SEO_INDEXING_ENABLED đang tắt — robots.txt chặn crawl và /sitemap.xml trả 404. Bật trong .env để cho phép index.';
            $this->sitemapFlashType = 'error';

            return;
        }

        SitemapBuilder::forgetAllCaches();

        $exitCode = Artisan::call('sitemap:generate');
        $output = trim(Artisan::output());

        if ($exitCode !== 0) {
            $this->sitemapFlash = $output !== '' ? $output : 'Cập nhật sitemap không thành công.';
            $this->sitemapFlashType = 'error';

            return;
        }

        $builder = app(SitemapBuilder::class);
        $entryCount = count($builder->entries());
        $sectionSummary = collect($builder->activeSections())
            ->map(fn (string $section) => SitemapBuilder::sectionLabel($section).': '.count($builder->sectionEntries($section)).' URL')
            ->implode("\n");

        $message = $output !== '' ? $output : 'Đã cập nhật sitemap index và các file theo loại.';
        $message .= "\n\n{$entryCount} URL tổng · ".route('seo.sitemap');
        $message .= "\n{$sectionSummary}";

        $this->sitemapFlash = $message;
        $this->sitemapFlashType = 'success';
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
            'postForm.excerpt' => ['nullable', 'string', 'max:500'],
            'postForm.content' => ['nullable', 'string'],
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
            'content' => $post->content ?? '',
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

    public function openRecipeModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editRecipe($id);
        } else {
            $this->resetRecipeForm();
        }
        $this->showRecipeModal = true;
    }

    public function closeRecipeModal(): void
    {
        $this->showRecipeModal = false;
        $this->resetRecipeForm();
    }

    public function saveRecipe(): void
    {
        $validated = $this->validate([
            'recipeForm.title' => ['required', 'string', 'max:255'],
            'recipeForm.slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'recipeForm.excerpt' => ['nullable', 'string', 'max:500'],
            'recipeForm.ingredients' => ['nullable', 'string'],
            'recipeForm.content' => ['nullable', 'string'],
            'recipeForm.health_tips' => ['nullable', 'string'],
            'recipeForm.image_url' => ['nullable', 'string', 'max:2048'],
            'recipeForm.prep_minutes' => ['nullable', 'integer', 'min:1', 'max:600'],
            'recipeForm.servings' => ['nullable', 'integer', 'min:1', 'max:50'],
            'recipeForm.difficulty' => ['required', Rule::in([VegetarianRecipe::DIFFICULTY_DE, VegetarianRecipe::DIFFICULTY_TRUNG_BINH])],
            'recipeForm.published_at' => ['nullable', 'date'],
            'recipeForm.is_featured' => ['boolean'],
            'recipeForm.sort_order' => ['nullable', 'integer', 'min:0'],
            'recipeImageFile' => ['nullable', 'image', 'max:4096'],
        ]);

        $data = $validated['recipeForm'];
        $data['slug'] = filled($data['slug'] ?? null)
            ? $data['slug']
            : VegetarianRecipe::slugFromTitle($data['title']);

        if ($this->editingRecipeId) {
            $conflict = VegetarianRecipe::query()
                ->where('slug', $data['slug'])
                ->whereKeyNot($this->editingRecipeId)
                ->exists();
            if ($conflict) {
                $data['slug'] = $data['slug'].'-'.$this->editingRecipeId;
            }
        }

        $data['published_at'] = filled($data['published_at'] ?? null)
            ? Carbon::parse($data['published_at'])
            : null;
        $data['prep_minutes'] = filled($data['prep_minutes'] ?? null) ? (int) $data['prep_minutes'] : null;
        $data['servings'] = filled($data['servings'] ?? null) ? (int) $data['servings'] : null;
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $data['is_featured'] = (bool) ($data['is_featured'] ?? false);

        if ($this->recipeImageFile) {
            $path = $this->recipeImageFile->store('recipes', 'public');
            $data['image_url'] = Storage::url($path);
        }

        VegetarianRecipe::query()->updateOrCreate(
            ['id' => $this->editingRecipeId],
            $data
        );

        $this->closeRecipeModal();
    }

    public function editRecipe(int $id): void
    {
        $recipe = VegetarianRecipe::query()->findOrFail($id);
        $this->editingRecipeId = $id;
        $this->recipeForm = [
            'title' => $recipe->title,
            'slug' => $recipe->slug,
            'excerpt' => $recipe->excerpt ?? '',
            'ingredients' => $recipe->ingredients ?? '',
            'content' => $recipe->content ?? '',
            'health_tips' => $recipe->health_tips ?? '',
            'image_url' => $recipe->image_url ?? '',
            'prep_minutes' => $recipe->prep_minutes !== null ? (string) $recipe->prep_minutes : '',
            'servings' => $recipe->servings !== null ? (string) $recipe->servings : '',
            'difficulty' => $recipe->difficulty,
            'published_at' => optional($recipe->published_at)->format('Y-m-d\TH:i'),
            'is_featured' => $recipe->is_featured,
            'sort_order' => $recipe->sort_order,
        ];
        $this->recipeImagePreview = $recipe->image_url ?: null;
    }

    public function deleteRecipe(int $id): void
    {
        VegetarianRecipe::query()->whereKey($id)->delete();
        if ($this->editingRecipeId === $id) {
            $this->resetRecipeForm();
        }
    }

    public function updatedRecipeFormTitle(string $value): void
    {
        if ($this->editingRecipeId || filled($this->recipeForm['slug'] ?? null)) {
            return;
        }
        $this->recipeForm['slug'] = VegetarianRecipe::slugFromTitle($value);
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
        if ($this->practiceProfileHistoryId === $id) {
            $this->closePracticeProfileHistory();
        }

        PracticeProfile::query()->whereKey($id)->delete();
    }

    /**
     * @return array{profile: \App\Models\PracticeProfile, activities: \Illuminate\Contracts\Pagination\LengthAwarePaginator, scriptureTitles: array<int, string>, postTitles: array<int, string>, recipeTitles: array<int, string>}|null
     */
    private function practiceProfileHistoryPayload(): ?array
    {
        if ($this->practiceProfileHistoryId === null) {
            return null;
        }

        $profile = PracticeProfile::query()->find($this->practiceProfileHistoryId);
        if ($profile === null) {
            $this->closePracticeProfileHistory();

            return null;
        }

        $query = PracticeActivity::query()
            ->where('practice_profile_id', $profile->id)
            ->orderByDesc('created_at');

        if ($this->practiceActivityFilter !== 'all') {
            $query->where('activity_type', $this->practiceActivityFilter);
        }

        $activities = $query->paginate(25, ['*'], 'practiceActivitiesPage');

        $scriptureIds = [];
        $postIds = [];
        $recipeIds = [];

        foreach ($activities as $activity) {
            if ($activity->reference_type === Scripture::class && $activity->reference_id) {
                $scriptureIds[(int) $activity->reference_id] = true;
            }
            if ($activity->reference_type === Post::class && $activity->reference_id) {
                $postIds[(int) $activity->reference_id] = true;
            }
            if ($activity->reference_type === VegetarianRecipe::class && $activity->reference_id) {
                $recipeIds[(int) $activity->reference_id] = true;
            }
        }

        $scriptureTitles = [];
        $scriptureCategories = [];
        if ($scriptureIds !== []) {
            Scripture::query()
                ->with('category')
                ->whereIn('id', array_keys($scriptureIds))
                ->get(['id', 'title', 'category_id'])
                ->each(function (Scripture $scripture) use (&$scriptureTitles, &$scriptureCategories) {
                    $scriptureTitles[$scripture->id] = $scripture->title;
                    $scriptureCategories[$scripture->id] = $scripture->category?->name ?? '';
                });
        }

        return [
            'profile' => $profile,
            'activities' => $activities,
            'scriptureTitles' => $scriptureTitles,
            'scriptureCategories' => $scriptureCategories,
            'postTitles' => $postIds === []
                ? []
                : Post::query()->whereIn('id', array_keys($postIds))->pluck('title', 'id')->all(),
            'recipeTitles' => $recipeIds === []
                ? []
                : VegetarianRecipe::query()->whereIn('id', array_keys($recipeIds))->pluck('title', 'id')->all(),
        ];
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

    public function openQuizQuestionModal(?int $id = null): void
    {
        $this->resetErrorBag();
        if ($id) {
            $this->editQuizQuestion($id);
        } else {
            $this->resetQuizQuestionForm();
        }
        $this->showQuizQuestionModal = true;
    }

    public function closeQuizQuestionModal(): void
    {
        $this->showQuizQuestionModal = false;
        $this->resetQuizQuestionForm();
    }

    public function saveQuizQuestion(): void
    {
        $validated = $this->validate([
            'quizQuestionForm.topic' => ['required', 'string', 'max:120'],
            'quizQuestionForm.question' => ['required', 'string', 'max:5000'],
            'quizQuestionForm.option_a' => ['required', 'string', 'max:500'],
            'quizQuestionForm.option_b' => ['required', 'string', 'max:500'],
            'quizQuestionForm.option_c' => ['required', 'string', 'max:500'],
            'quizQuestionForm.option_d' => ['required', 'string', 'max:500'],
            'quizQuestionForm.correct_answer' => ['required', Rule::in(['A', 'B', 'C', 'D'])],
            'quizQuestionForm.explanation' => ['required', 'string', 'max:5000'],
            'quizQuestionForm.sort_order' => ['required', 'integer', 'min:0', 'max:65535'],
            'quizQuestionForm.is_active' => ['required', 'boolean'],
        ]);

        if ($this->editingQuizQuestionId) {
            QuizQuestion::query()->whereKey($this->editingQuizQuestionId)->update($validated['quizQuestionForm']);
        } else {
            QuizQuestion::query()->create($validated['quizQuestionForm']);
        }

        $this->closeQuizQuestionModal();
    }

    public function editQuizQuestion(int $id): void
    {
        $question = QuizQuestion::query()->findOrFail($id);
        $this->editingQuizQuestionId = $id;
        $this->quizQuestionForm = [
            'topic' => $question->topic,
            'question' => $question->question,
            'option_a' => $question->option_a,
            'option_b' => $question->option_b,
            'option_c' => $question->option_c,
            'option_d' => $question->option_d,
            'correct_answer' => $question->correct_answer,
            'explanation' => $question->explanation,
            'sort_order' => $question->sort_order,
            'is_active' => $question->is_active,
        ];
    }

    public function deleteQuizQuestion(int $id): void
    {
        QuizQuestion::query()->whereKey($id)->delete();
        if ($this->editingQuizQuestionId === $id) {
            $this->resetQuizQuestionForm();
        }
    }

    public function toggleQuizQuestion(int $id): void
    {
        $question = QuizQuestion::query()->findOrFail($id);
        $question->update([
            'is_active' => ! $question->is_active,
        ]);
    }

    public function resetQuizQuestionForm(): void
    {
        $this->editingQuizQuestionId = null;
        $this->quizQuestionForm = [
            'topic' => '',
            'question' => '',
            'option_a' => '',
            'option_b' => '',
            'option_c' => '',
            'option_d' => '',
            'correct_answer' => 'A',
            'explanation' => '',
            'sort_order' => (int) (QuizQuestion::query()->max('sort_order') ?? 0) + 1,
            'is_active' => true,
        ];
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
            'content' => '',
            'image_url' => '',
            'published_at' => '',
        ];
    }

    public function resetRecipeForm(): void
    {
        $this->editingRecipeId = null;
        $this->recipeImageFile = null;
        $this->recipeImagePreview = null;
        $this->recipeForm = [
            'title' => '',
            'slug' => '',
            'excerpt' => '',
            'ingredients' => '',
            'content' => '',
            'health_tips' => '',
            'image_url' => '',
            'prep_minutes' => '',
            'servings' => '',
            'difficulty' => VegetarianRecipe::DIFFICULTY_DE,
            'published_at' => '',
            'is_featured' => false,
            'sort_order' => 0,
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
        $totalRecipes = VegetarianRecipe::query()->count();

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
                ['label' => 'Món Chay', 'value' => number_format($totalRecipes), 'description' => 'Công thức'],
                ['label' => 'Loại Kinh', 'value' => number_format(ScriptureCategory::query()->count()), 'description' => 'Danh mục'],
                ['label' => 'Tiện Ích', 'value' => number_format(Utility::query()->count()), 'description' => 'Đang hoạt động'],
            ],
            'scriptures' => Scripture::query()->with('category')->latest()->paginate(15, ['*'], 'scripturesPage'),
            'posts' => Post::query()->latest('published_at')->paginate(15, ['*'], 'postsPage'),
            'recipes' => VegetarianRecipe::query()->orderBy('sort_order')->latest('published_at')->paginate(15, ['*'], 'recipesPage'),
            'categories' => ScriptureCategory::query()->withCount('scriptures')->orderBy('name')->paginate(12, ['*'], 'categoriesPage'),
            'allCategories' => ScriptureCategory::query()->orderBy('name')->get(),
            'utilities' => Utility::query()->orderBy('sort_order')->paginate(12, ['*'], 'utilitiesPage'),
            'practiceProfiles' => $practiceProfileQuery->paginate(20, ['*'], 'practiceProfilesPage'),
            'practiceProfileCount' => PracticeProfile::query()->count(),
            'practiceProfileHistory' => $this->practiceProfileHistoryPayload(),
            'practiceActivityFilterOptions' => PracticeActivityPresenter::filterOptions(),
            'dailyWishes' => DailyWish::query()->ordered()->paginate(15, ['*'], 'dailyWishesPage'),
            'quizQuestions' => QuizQuestion::query()->ordered()->paginate(15, ['*'], 'quizQuestionsPage'),
            'quizQuestionCount' => QuizQuestion::query()->count(),
            'quizQuestionActiveCount' => QuizQuestion::query()->where('is_active', true)->count(),
        ]);
    }
}
