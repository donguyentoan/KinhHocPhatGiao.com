<div class="text-[#4a2c11] flex h-screen overflow-hidden">
    <aside class="w-72 border-r border-[#8b5e34]/10 flex flex-col p-6 glass">
        <div class="flex items-center gap-3 mb-12 px-2">
            <div class="w-10 h-10 shadow-2xl rounded-2xl flex items-center justify-center text-white bg-[#8b5e34]">
                <x-icon name="flower-2" class="w-6 h-6" />
            </div>
            <span class="font-serif text-2xl font-bold">An Nhiên</span>
        </div>
        <nav class="space-y-2 flex-1">
            <button wire:click="setSection('tong-quan')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'tong-quan'])><x-icon name="layout-dashboard" class="w-5 h-5" />Tổng quan</button>
            <button wire:click="setSection('kinh-phat')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'kinh-phat'])><x-icon name="scroll" class="w-5 h-5" />Kinh Phật</button>
            <button wire:click="setSection('loai-kinh')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'loai-kinh'])><x-icon name="layers" class="w-5 h-5" />Loại Kinh</button>
            <button wire:click="setSection('bai-viet')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'bai-viet'])><x-icon name="pen-tool" class="w-5 h-5" />Bài viết</button>
            <button wire:click="setSection('tien-ich')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'tien-ich'])><x-icon name="component" class="w-5 h-5" />Tiện ích</button>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="p-4 flex justify-between items-center sticky top-0 z-20 glass">
            <h1 class="text-2xl font-serif font-bold">
                @php
                    $titles = [
                        'tong-quan' => 'Tổng quan hệ thống',
                        'kinh-phat' => 'Danh sách Kinh Phật',
                        'loai-kinh' => 'Quản lý Loại Kinh',
                        'bai-viet' => 'Danh sách Bài viết',
                        'tien-ich' => 'Trung tâm Tiện ích',
                    ];
                @endphp
                {{ $titles[$activeSection] ?? 'Dashboard' }}
            </h1>
            <div class="flex items-center gap-3 glass p-1.5 pr-5 rounded-full shadow-sm">
                <div class="w-10 h-10 rounded-full bg-[#d4a373] flex items-center justify-center text-white">
                    <x-icon name="user" class="w-5 h-5" />
                </div>
                <span class="text-sm font-bold">Admin Zen</span>
            </div>
        </header>

        <div class="p-8">
            @if($activeSection === 'tong-quan')
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                    @foreach($stats as $index => $stat)
                        <div class="glass p-6 rounded-[2.5rem] shadow-sm border-none relative overflow-hidden group">
                            <div class="relative z-10">
                                <p class="text-[10px] font-bold text-[#8b5e34]/60 uppercase tracking-[0.2em]">{{ $stat['label'] }}</p>
                                <h2 class="text-3xl font-serif font-bold mt-2">{{ $stat['value'] }}</h2>
                                <div class="flex items-center gap-2 mt-4 {{ $index < 2 ? 'text-green-600' : ($index === 3 ? 'text-amber-600' : 'text-[#8b5e34]') }} text-xs font-bold">
                                    <x-icon :name="['trending-up','trending-up','users','clock'][$index] ?? 'activity'" class="w-4 h-4" />
                                    <span>{{ $stat['description'] }}</span>
                                </div>
                            </div>
                            <x-icon :name="['scroll','pen-tool','eye','hourglass'][$index] ?? 'sparkles'" class="absolute -right-2 -bottom-2 w-24 h-24 text-[#8b5e34]/5 -rotate-12 group-hover:rotate-0 transition-transform duration-500" />
                        </div>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 glass p-8 rounded-[3rem] shadow-sm">
                        <div class="flex justify-between items-center mb-8">
                            <h3 class="text-lg font-serif font-bold">Tăng trưởng lượt đọc</h3>
                            <select class="bg-white/50 border-none rounded-full px-4 py-1.5 text-xs font-bold cursor-pointer outline-none">
                                <option>Tuần này</option>
                                <option>Tháng này</option>
                            </select>
                        </div>
                        <div class="h-[300px] w-full"><canvas id="lineChart"></canvas></div>
                    </div>
                    <div class="glass p-8 rounded-[3rem] shadow-sm">
                        <h3 class="text-lg font-serif font-bold mb-8">Phân bổ Kinh Văn</h3>
                        <div class="h-[250px]"><canvas id="doughnutChart"></canvas></div>
                    </div>
                </div>
            @endif

            @if($activeSection === 'kinh-phat')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-8">
                        <div class="relative">
                            <input type="text" placeholder="Tìm kiếm kinh văn..." class="pl-12 pr-6 py-3 glass rounded-full w-full md:w-80 focus:outline-none">
                            <x-icon name="search" class="absolute left-4 top-3.5 text-[#8b5e34]/40 w-5 h-5" />
                        </div>
                        <button wire:click="openScriptureModal" class="bg-[#4a2c11] text-white px-6 py-3 rounded-full font-bold flex items-center gap-2 hover:bg-[#8b5e34] transition-all">
                            <x-icon name="plus" class="w-5 h-5" /> Thêm Kinh Phật
                        </button>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[#8b5e34]/50 text-xs uppercase tracking-widest border-b border-[#8b5e34]/10">
                                <th class="pb-4">Tên Bài Kinh</th>
                                <th class="pb-4">Phân Loại</th>
                                <th class="pb-4">Ngày Thêm</th>
                                <th class="pb-4 text-right">Hành Động</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($scriptures as $scripture)
                                <tr class="border-b border-[#8b5e34]/5 hover:bg-[#8b5e34]/5 transition-all">
                                    <td class="py-4 font-bold text-[#4a2c11]">{{ $scripture->title }}</td>
                                    <td class="py-4">{{ optional($scripture->category)->name }}</td>
                                    <td class="py-4">{{ $scripture->created_at->format('d/m/Y') }}</td>
                                    <td class="py-4 text-right space-x-2">
                                        <button wire:click="openScriptureModal({{ $scripture->id }})" class="p-2 text-gray-400 hover:text-[#8b5e34]"><x-icon name="edit-3" class="w-4 h-4" /></button>
                                        <button wire:click="deleteScripture({{ $scripture->id }})" wire:confirm="Bạn chắc chắn muốn xóa?" class="p-2 text-gray-400 hover:text-red-500"><x-icon name="trash-2" class="w-4 h-4" /></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($activeSection === 'loai-kinh')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="flex justify-between items-center mb-8">
                        <h3 class="text-xl font-serif font-bold">Phân Loại Kinh</h3>
                        <button wire:click="openCategoryModal" class="text-sm px-6 py-2.5 bg-[#8b5e34] text-white rounded-full font-bold hover:shadow-lg transition-all">+ Thêm Loại Mới</button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($categories as $category)
                            <div class="p-5 bg-white/40 rounded-2xl border border-[#8b5e34]/10 flex justify-between items-center">
                                <div>
                                    <p class="font-bold">{{ $category->name }}</p>
                                    <p class="text-xs text-[#8b5e34]/60">{{ $category->scriptures_count }} bài kinh</p>
                                </div>
                                <div class="flex gap-1">
                                    <button wire:click="openCategoryModal({{ $category->id }})" class="p-2 text-gray-400 hover:text-[#8b5e34]"><x-icon name="edit-2" class="w-4 h-4" /></button>
                                    <button wire:click="deleteCategory({{ $category->id }})" wire:confirm="Bạn chắc chắn muốn xóa?" class="p-2 text-gray-400 hover:text-red-400"><x-icon name="trash-2" class="w-4 h-4" /></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($activeSection === 'bai-viet')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="flex flex-col md:flex-row justify-between gap-4 mb-8">
                        <div class="relative">
                            <input type="text" placeholder="Tìm tiêu đề bài viết..." class="pl-12 pr-6 py-3 glass rounded-full w-full md:w-80 focus:outline-none">
                            <x-icon name="search" class="absolute left-4 top-3.5 text-[#8b5e34]/40 w-5 h-5" />
                        </div>
                        <button wire:click="openPostModal" class="bg-[#4a2c11] text-white px-6 py-3 rounded-full font-bold flex items-center gap-2 hover:bg-[#8b5e34] transition-all shadow-lg">
                            <x-icon name="pen-tool" class="w-5 h-5" /> Viết Bài Mới
                        </button>
                    </div>
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-[#8b5e34]/50 text-xs uppercase tracking-widest border-b border-[#8b5e34]/10">
                                <th class="pb-4">Tiêu Đề Bài Viết</th>
                                <th class="pb-4">Trạng Thái</th>
                                <th class="pb-4">Ngày Đăng</th>
                                <th class="pb-4 text-right">Thao Tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach($posts as $post)
                                <tr class="border-b border-[#8b5e34]/5 hover:bg-[#8b5e34]/5 transition-all">
                                    <td class="py-5 font-bold text-[#4a2c11]">{{ $post->title }}</td>
                                    <td class="py-5"><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-bold uppercase">Công khai</span></td>
                                    <td class="py-5 text-gray-500">{{ optional($post->published_at)->format('d/m/Y') }}</td>
                                    <td class="py-4 text-right space-x-2">
                                        <button wire:click="openPostModal({{ $post->id }})" class="p-2 text-gray-300 hover:text-[#8b5e34]"><x-icon name="edit-3" class="w-4 h-4" /></button>
                                        <button wire:click="deletePost({{ $post->id }})" wire:confirm="Bạn chắc chắn muốn xóa?" class="p-2 text-gray-300 hover:text-red-500"><x-icon name="trash-2" class="w-4 h-4" /></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            @if($activeSection === 'tien-ich')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach($utilities as $utility)
                            <div class="bg-white/40 border border-[#8b5e34]/5 p-6 rounded-[2rem] flex flex-col items-center hover:shadow-xl transition-all">
                                <div class="w-14 h-14 mb-4 bg-orange-50 rounded-2xl flex items-center justify-center">
                                    <img src="{{ $utility->icon_url }}" alt="{{ $utility->name }}" class="w-10 h-10 object-contain">
                                </div>
                                <span class="text-xs font-bold text-center mb-5">{{ $utility->name }}</span>
                                <label class="relative inline-flex items-center cursor-pointer mb-3">
                                    <input wire:change="toggleUtility({{ $utility->id }})" type="checkbox" @checked($utility->is_active) class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-[#8b5e34] peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                </label>
                                <div class="flex gap-1">
                                    <button wire:click="openUtilityModal({{ $utility->id }})" class="p-2 text-gray-400 hover:text-[#8b5e34]"><x-icon name="edit-3" class="w-4 h-4" /></button>
                                    <button wire:click="deleteUtility({{ $utility->id }})" wire:confirm="Bạn chắc chắn muốn xóa?" class="p-2 text-gray-400 hover:text-red-400"><x-icon name="trash-2" class="w-4 h-4" /></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    @if($showScriptureModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
            <div class="glass w-full max-w-2xl rounded-[2.5rem] p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-serif font-bold">{{ $editingScriptureId ? 'Cập nhật Kinh Văn' : 'Thêm Kinh Văn Mới' }}</h2>
                        <p class="text-[10px] text-[#8b5e34]/60 font-bold uppercase tracking-wider">Nhập liệu thủ công hoặc tải lên tệp tin</p>
                    </div>
                    <button wire:click="closeScriptureModal" class="p-2 hover:bg-[#8b5e34]/10 rounded-full transition-all" aria-label="Đóng modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="saveScripture" class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Tên bài kinh</label>
                            <input wire:model="scriptureForm.title" type="text" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none" placeholder="Nhập tên kinh...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Loại kinh</label>
                            <select wire:model="scriptureForm.category_id" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none appearance-none">
                                <option value="">Chọn loại kinh</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Thời lượng (phút)</label>
                            <input wire:model="scriptureForm.duration_minutes" type="number" min="1" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Lượt tụng</label>
                            <input wire:model="scriptureForm.chant_count" type="number" min="0" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none">
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] px-1">Tải lên tệp nội dung (Tùy chọn)</label>
                        <label class="relative group border-2 border-dashed border-[#8b5e34]/20 rounded-3xl p-6 transition-all hover:border-[#8b5e34]/40 hover:bg-[#8b5e34]/5 flex flex-col items-center justify-center cursor-pointer">
                            <input wire:model.defer="scriptureContentFile" type="file" accept=".txt,.doc,.docx,.pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="flex flex-col items-center text-center space-y-2">
                                <div class="w-12 h-12 rounded-2xl bg-[#8b5e34]/10 flex items-center justify-center text-[#8b5e34] group-hover:scale-110 transition-transform">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 16V4m0 0l-4 4m4-4l4 4"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2"/>
                                    </svg>
                                </div>
                                <p class="text-xs font-bold text-[#4a2c11]/70">Kéo thả tệp hoặc click để chọn</p>
                                <p class="text-[10px] text-[#8b5e34]/50">Hỗ trợ PDF, DOCX, TXT (Tối đa 10MB)</p>
                            </div>
                        </label>
                        @if($scriptureContentFile)
                            <p class="text-xs text-green-700">Đã chọn tệp: {{ $scriptureContentFile->getClientOriginalName() }}</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Chế độ đọc</label>
                        <select wire:model="scriptureForm.reader_mode" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none">
                            <option value="auto">Tự động (nếu có PDF thì ưu tiên PDF)</option>
                            <option value="pdf">Luôn dùng PDF</option>
                            <option value="content">Luôn dùng nội dung (content)</option>
                        </select>
                        <p class="text-[10px] text-[#8b5e34]/60 mt-2 px-1">Bạn có thể bật/tắt render PDF cho từng bài Kinh.</p>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Ảnh bìa</label>
                        <label class="w-full border-2 border-dashed border-[#8b5e34]/20 rounded-2xl px-5 py-6 bg-white/50 hover:bg-white/70 transition-all flex flex-col items-center justify-center text-center cursor-pointer overflow-hidden">
                            <input wire:model.defer="scriptureImageFile" type="file" accept="image/*" class="hidden" onchange="previewLocalImage(event, 'scripture-image-preview', 'scripture-image-placeholder', 'scriptureImagePreview')">
                            <img id="scripture-image-preview"
                                 src="{{ $scriptureImagePreview ?: (!empty($scriptureForm['image_url']) ? $scriptureForm['image_url'] : '') }}"
                                 alt="Preview ảnh bìa"
                                 class="w-full h-48 object-cover rounded-xl {{ ($scriptureImagePreview || !empty($scriptureForm['image_url'])) ? '' : 'hidden' }}">
                            <div id="scripture-image-placeholder" class="{{ ($scriptureImagePreview || !empty($scriptureForm['image_url'])) ? 'hidden' : '' }} flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="text-[#8b5e34]/30 w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <path d="M21 15l-5-5L5 21"></path>
                                    <path d="M12 7v4"></path>
                                    <path d="M10 9h4"></path>
                                </svg>
                                <span class="text-xs font-bold text-[#4a2c11]/70">Click để tải ảnh lên</span>
                                <span class="text-[10px] text-[#8b5e34]/50 mt-1">PNG, JPG, WEBP tối đa 4MB</span>
                            </div>
                        </label>
                        @if($scriptureImageFile)
                            <p class="text-xs text-green-700 mt-2">Đã chọn: {{ $scriptureImageFile->getClientOriginalName() }}</p>
                        @elseif(!empty($scriptureForm['image_url']))
                            <p class="text-xs text-[#8b5e34]/70 mt-2">Ảnh hiện tại đã có sẵn.</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Nội dung kinh văn</label>
                        <textarea wire:model="scriptureForm.summary" rows="6" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none resize-none" placeholder="Nhập nội dung bài kinh hoặc nội dung sẽ tự động trích xuất từ file..."></textarea>
                    </div>
                    @error('scriptureForm.*') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    @error('scriptureImageFile') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    @error('scriptureContentFile') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeScriptureModal" class="flex-1 py-3 rounded-full font-bold border border-[#8b5e34]/20 hover:bg-white transition-all text-sm">Hủy bỏ</button>
                        <button type="submit" class="flex-1 py-3 rounded-full font-bold bg-[#4a2c11] text-white hover:bg-[#8b5e34] shadow-lg transition-all text-sm">Lưu Kinh Văn</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($showCategoryModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
            <div class="glass w-full max-w-md rounded-[2.5rem] p-8 shadow-2xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-serif font-bold">{{ $editingCategoryId ? 'Cập nhật loại kinh' : 'Danh mục mới' }}</h2>
                    <button wire:click="closeCategoryModal" class="p-2 hover:bg-[#8b5e34]/10 rounded-full" aria-label="Đóng modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="saveCategory" class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Tên danh mục</label>
                        <input wire:model="categoryForm.name" type="text" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none" placeholder="VD: Kinh A Hàm...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Mô tả</label>
                        <textarea wire:model="categoryForm.description" rows="3" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none resize-none" placeholder="Mô tả ngắn về loại kinh này..."></textarea>
                    </div>
                    @error('categoryForm.*') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    <button type="submit" class="w-full py-3 mt-4 rounded-full font-bold bg-[#4a2c11] text-white hover:bg-[#8b5e34] shadow-lg transition-all">Tạo danh mục</button>
                </form>
            </div>
        </div>
    @endif

    @if($showPostModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
            <div class="glass w-full max-w-4xl rounded-[2.5rem] p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-serif font-bold">{{ $editingPostId ? 'Cập nhật bài viết' : 'Viết Bài Chia Sẻ' }}</h2>
                    <button wire:click="closePostModal" class="p-2 hover:bg-[#8b5e34]/10 rounded-full" aria-label="Đóng modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="savePost" class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-2 space-y-5">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Tiêu đề bài viết</label>
                            <input wire:model="postForm.title" type="text" class="w-full px-5 py-4 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none font-bold text-lg" placeholder="Nhập tiêu đề...">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Nội dung chi tiết</label>
                            <textarea wire:model="postForm.excerpt" rows="12" class="w-full px-5 py-4 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none resize-none" placeholder="Bắt đầu câu chuyện của bạn..."></textarea>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div class="p-6 bg-[#8b5e34]/5 rounded-[2rem] border border-[#8b5e34]/10">
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-4">Ảnh bìa</label>
                            <label class="w-full h-40 border-2 border-dashed border-[#8b5e34]/20 rounded-2xl flex flex-col items-center justify-center gap-3 hover:bg-white/50 cursor-pointer transition-all overflow-hidden">
                                <input wire:model.defer="postImageFile" type="file" accept="image/*" class="hidden" onchange="previewLocalImage(event, 'post-image-preview', 'post-image-placeholder', 'postImagePreview')">
                                <img id="post-image-preview"
                                     src="{{ $postImagePreview ?: (!empty($postForm['image_url']) ? $postForm['image_url'] : '') }}"
                                     alt="Preview ảnh bài viết"
                                     class="w-full h-full object-cover {{ ($postImagePreview || !empty($postForm['image_url'])) ? '' : 'hidden' }}">
                                <div id="post-image-placeholder" class="{{ ($postImagePreview || !empty($postForm['image_url'])) ? 'hidden' : '' }} flex flex-col items-center gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="text-[#8b5e34]/30 w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <path d="M21 15l-5-5L5 21"></path>
                                        <path d="M12 7v4"></path>
                                        <path d="M10 9h4"></path>
                                    </svg>
                                    <span class="text-[10px] font-bold opacity-50">Upload Image</span>
                                    <span class="text-[10px] text-[#8b5e34]/50">PNG, JPG, WEBP tối đa 4MB</span>
                                </div>
                            </label>
                            @if($postImageFile)
                                <p class="text-xs text-green-700 mt-2">Đã chọn: {{ $postImageFile->getClientOriginalName() }}</p>
                            @elseif(!empty($postForm['image_url']))
                                <p class="text-xs text-[#8b5e34]/70 mt-2">Ảnh hiện tại đã có sẵn.</p>
                            @endif
                            <input wire:model="postForm.image_url" type="url" class="w-full mt-4 px-4 py-2 rounded-xl border border-[#8b5e34]/10 bg-white/80" placeholder="Hoặc nhập URL ảnh">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Ngày đăng</label>
                            <input wire:model="postForm.published_at" type="datetime-local" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Chế độ hiển thị</label>
                            <select class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 outline-none">
                                <option>Công khai ngay</option>
                            </select>
                        </div>
                        @error('postForm.*') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        @error('postImageFile') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                        <button type="submit" class="w-full py-4 rounded-full font-bold bg-[#4a2c11] text-white hover:bg-[#8b5e34] shadow-xl shadow-[#4a2c11]/20 transition-all">Xuất bản bài viết</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        let dashboardLineChart = null;
        let dashboardDoughnutChart = null;

        function renderDashboardCharts() {
            if (typeof Chart === 'undefined') return;

            const lineCanvas = document.getElementById('lineChart');
            if (lineCanvas) {
                if (dashboardLineChart) {
                    dashboardLineChart.destroy();
                }
                dashboardLineChart = new Chart(lineCanvas.getContext('2d'), {
                    type: 'line',
                    data: {
                        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
                        datasets: [{
                            data: [1200, 1900, 1500, 2500, 2200, 3000, 3500],
                            borderColor: '#8b5e34',
                            backgroundColor: 'rgba(139, 94, 52, 0.1)',
                            fill: true,
                            tension: 0.4,
                            borderWidth: 3,
                            pointRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: { y: { display: false }, x: { grid: { display: false } } }
                    }
                });
            }

            const doughnutCanvas = document.getElementById('doughnutChart');
            if (doughnutCanvas) {
                if (dashboardDoughnutChart) {
                    dashboardDoughnutChart.destroy();
                }
                dashboardDoughnutChart = new Chart(doughnutCanvas.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Kinh Bộ', 'Kinh Chú', 'Khác'],
                        datasets: [{
                            data: [45, 30, 25],
                            backgroundColor: ['#8b5e34', '#4a2c11', '#d4a373'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '80%',
                        plugins: { legend: { position: 'bottom' } }
                    }
                });
            }
        }

        function refreshDashboardUi() {
            renderDashboardCharts();
        }

        function previewLocalImage(event, imgId, placeholderId, stateProp) {
            const file = event.target.files && event.target.files[0];
            if (!file) return;

            const img = document.getElementById(imgId);
            const placeholder = document.getElementById(placeholderId);
            if (!img) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                if (placeholder) placeholder.classList.add('hidden');

                const componentRoot = event.target.closest('[wire\\:id]');
                if (componentRoot && stateProp && window.Livewire) {
                    const component = window.Livewire.find(componentRoot.getAttribute('wire:id'));
                    if (component) {
                        component.set(stateProp, e.target.result);
                    }
                }
            };
            reader.readAsDataURL(file);
        }

        document.addEventListener('livewire:initialized', () => {
            refreshDashboardUi();
            Livewire.on('dashboard-section-changed', () => {
                requestAnimationFrame(() => {
                    refreshDashboardUi();
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            refreshDashboardUi();
        });
    </script>
</div>
