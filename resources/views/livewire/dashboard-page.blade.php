<div class="text-[#4a2c11] flex h-full max-h-full overflow-hidden">
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
            <button wire:click="setSection('loi-nguyen')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'loi-nguyen'])><x-icon name="flower-2" class="w-5 h-5" />Lời nguyện</button>
            <button wire:click="setSection('phat-tu')" @class(['sidebar-link w-full flex items-center gap-3 px-4 py-3 rounded-2xl font-bold transition-all text-[#4a2c11]/60', 'active' => $activeSection === 'phat-tu'])><x-icon name="users" class="w-5 h-5" />Phật tử</button>
        </nav>
    </aside>

    <main class="flex-1 overflow-y-auto">
        <header class="p-4 flex flex-wrap justify-between items-center gap-3 sticky top-0 z-20 glass">
            <h1 class="text-2xl font-serif font-bold">
                @php
                    $titles = [
                        'tong-quan' => 'Tổng quan hệ thống',
                        'kinh-phat' => 'Danh sách Kinh Phật',
                        'loai-kinh' => 'Quản lý Loại Kinh',
                        'bai-viet' => 'Danh sách Bài viết',
                        'tien-ich' => 'Trung tâm Tiện ích',
                        'loi-nguyen' => 'Lời nguyện & quán chiếu (trang chủ)',
                        'phat-tu' => 'Phật tử đã lưu tài khoản tu học',
                    ];
                @endphp
                {{ $titles[$activeSection] ?? 'Dashboard' }}
            </h1>
            <div class="flex flex-wrap items-center gap-2">
            <button type="button"
                wire:click="runPendingMigrations"
                wire:confirm="Chạy migrate sẽ thay đổi cơ sở dữ liệu. Tiếp tục?"
                wire:loading.attr="disabled"
                wire:target="runPendingMigrations"
                class="inline-flex items-center gap-2 rounded-full border-2 border-[#8b5e34]/40 bg-white/70 px-4 py-2 text-sm font-bold text-[#4a2c11] shadow-sm transition hover:bg-[#8b5e34]/10 disabled:opacity-60 disabled:cursor-not-allowed">
                <x-icon name="layers" class="w-4 h-4 text-[#8b5e34]" />
                <span wire:loading.remove wire:target="runPendingMigrations">Migrate</span>
                <span wire:loading wire:target="runPendingMigrations" class="inline-flex items-center gap-1.5">
                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/></svg>
                    Đang chạy…
                </span>
                @if(count($pendingMigrations) > 0)
                    <span class="min-w-[1.25rem] rounded-full bg-amber-500 px-1.5 text-center text-[11px] font-extrabold text-white">{{ count($pendingMigrations) }}</span>
                @endif
            </button>
            <div class="flex items-center gap-3 glass p-1.5 pl-2 pr-2 rounded-full shadow-sm">
                <div class="w-10 h-10 rounded-full bg-[#d4a373] flex items-center justify-center text-white">
                    <x-icon name="user" class="w-5 h-5" />
                </div>
                <span class="text-sm font-bold max-w-[8rem] truncate" title="{{ auth()->user()->phone }}">{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="pl-2 border-l border-[#8b5e34]/15">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-[#8b5e34] hover:underline px-2">Đăng xuất</button>
                </form>
            </div>
            </div>
        </header>

        <div class="p-8">
            @if(filled($migrateFlash))
                <div @class([
                    'mb-6 p-5 rounded-[2rem] text-sm font-medium border',
                    'bg-emerald-50 text-emerald-900 border-emerald-200' => $migrateFlashType === 'success',
                    'bg-red-50 text-red-900 border-red-200' => $migrateFlashType === 'error',
                    'bg-amber-50 text-amber-950 border-amber-200' => $migrateFlashType === 'info',
                ])>
                    <pre class="whitespace-pre-wrap font-sans text-[13px] leading-relaxed m-0">{{ $migrateFlash }}</pre>
                </div>
            @endif

            @if($activeSection === 'tong-quan')
                @if(count($pendingMigrations) > 0)
                    <div class="glass p-6 md:p-8 rounded-[2.5rem] shadow-sm border-2 border-amber-300/60 mb-10">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="w-11 h-11 rounded-2xl bg-amber-100 flex items-center justify-center text-amber-800 shrink-0">
                                <x-icon name="layers" class="w-6 h-6" />
                            </div>
                            <div>
                                <h3 class="text-lg font-serif font-bold text-[#4a2c11]">Migration chưa chạy</h3>
                                <p class="text-sm text-[#6b4f2c] mt-1">Có {{ count($pendingMigrations) }} file chưa áp dụng. Bấm nút <strong class="text-[#4a2c11]">Migrate</strong> trên thanh trên để chạy (<code class="text-xs bg-white/60 px-1.5 py-0.5 rounded">php artisan migrate --force</code>).</p>
                            </div>
                        </div>
                        <ul class="space-y-2 text-sm font-mono text-[#4a2c11]/90 bg-white/40 rounded-2xl p-4 max-h-48 overflow-y-auto border border-[#8b5e34]/10">
                            @foreach($pendingMigrations as $name)
                                <li class="truncate" title="{{ $name }}">{{ $name }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <h2 class="text-xl font-serif font-bold text-[#4a2c11]">Tiện ích trang chủ</h2>
                        <button type="button" wire:click="openUtilityModal" class="bg-[#4a2c11] text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-[#8b5e34] transition-all shadow-lg w-fit">Thêm tiện ích</button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                        @foreach($utilities as $utility)
                            <div class="bg-white/40 border border-[#8b5e34]/5 p-6 rounded-[2rem] flex flex-col items-center hover:shadow-xl transition-all">
                                <div class="w-14 h-14 mb-4 bg-orange-50 rounded-2xl flex items-center justify-center">
                                    <img src="{{ $utility->icon_url }}" alt="{{ $utility->name }}" class="w-10 h-10 object-contain">
                                </div>
                                <span class="text-xs font-bold text-center mb-2">{{ $utility->name }}</span>
                                @if(filled($utility->link_url))
                                    <span class="text-[10px] text-[#8b5e34]/70 text-center mb-3 break-all line-clamp-2" title="{{ $utility->link_url }}">{{ $utility->link_url }}</span>
                                @else
                                    <span class="text-[10px] text-gray-400 text-center mb-3">Chưa có liên kết</span>
                                @endif
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

            @if($activeSection === 'loi-nguyen')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                        <div>
                            <h2 class="text-xl font-serif font-bold text-[#4a2c11]">Danh sách lời nguyện</h2>
                            <p class="text-sm text-[#8b5e34]/80 mt-1">Chỉ các mục <strong>bật hiển thị</strong> mới xuất hiện trên trang chủ. Icon: sen / ánh sáng / thiền.</p>
                        </div>
                        <button type="button" wire:click="openDailyWishModal" class="bg-[#4a2c11] text-white px-6 py-3 rounded-full font-bold text-sm hover:bg-[#8b5e34] transition-all shadow-lg w-fit">+ Thêm lời nguyện</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[640px]">
                            <thead>
                                <tr class="text-[#8b5e34]/50 text-xs uppercase tracking-widest border-b border-[#8b5e34]/10">
                                    <th class="pb-4 pr-4">Nội dung</th>
                                    <th class="pb-4 pr-4">Icon</th>
                                    <th class="pb-4 pr-4">Thứ tự</th>
                                    <th class="pb-4 pr-4">Trạng thái</th>
                                    <th class="pb-4 text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($dailyWishes as $wish)
                                    <tr class="border-b border-[#8b5e34]/5 hover:bg-[#8b5e34]/5 transition-all">
                                        <td class="py-4 pr-4 max-w-md">
                                            <p class="text-[#4a2c11] line-clamp-3 whitespace-pre-line">{{ $wish->text }}</p>
                                        </td>
                                        <td class="py-4 pr-4 font-mono text-xs">{{ $wish->icon }}</td>
                                        <td class="py-4 pr-4 tabular-nums">{{ $wish->sort_order }}</td>
                                        <td class="py-4 pr-4">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input wire:change="toggleDailyWish({{ $wish->id }})" type="checkbox" @checked($wish->is_active) class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-[#8b5e34] peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                            </label>
                                        </td>
                                        <td class="py-4 text-right space-x-1">
                                            <button type="button" wire:click="openDailyWishModal({{ $wish->id }})" class="p-2 text-gray-400 hover:text-[#8b5e34]" title="Sửa"><x-icon name="edit-3" class="w-4 h-4" /></button>
                                            <button type="button" wire:click="deleteDailyWish({{ $wish->id }})" wire:confirm="Xóa lời nguyện này?" class="p-2 text-gray-400 hover:text-red-500" title="Xóa"><x-icon name="trash-2" class="w-4 h-4" /></button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-[#8b5e34]/70">
                                            Chưa có dữ liệu. Chạy <code class="text-xs bg-black/5 px-2 py-0.5 rounded">php artisan migrate</code> rồi
                                            <code class="text-xs bg-black/5 px-2 py-0.5 rounded">php artisan db:seed --class=DailyWishSeeder</code> để nhập từ file JSON mẫu.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if($activeSection === 'phat-tu')
                <div class="glass p-8 rounded-[2.5rem] shadow-sm">
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 mb-8">
                        <div>
                            <p class="text-xs font-bold text-[#8b5e34]/70 uppercase tracking-widest mb-2">Tổng: {{ number_format($practiceProfileCount) }} hồ sơ</p>
                            <p class="text-sm text-[#4a2c11]/80 max-w-xl">
                                Danh sách người dùng đã lưu pháp danh trên trang chủ (nhận diện theo thiết bị). Hiển thị tối đa 500 bản ghi mới hoạt động gần đây.
                            </p>
                        </div>
                        <div class="relative w-full lg:w-80">
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="practiceProfileSearch"
                                placeholder="Tìm theo pháp danh..."
                                class="pl-12 pr-6 py-3 glass rounded-full w-full focus:outline-none"
                            >
                            <x-icon name="search" class="absolute left-4 top-3.5 text-[#8b5e34]/40 w-5 h-5" />
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left min-w-[720px]">
                            <thead>
                                <tr class="text-[#8b5e34]/50 text-xs uppercase tracking-widest border-b border-[#8b5e34]/10">
                                    <th class="pb-4 pr-4">Pháp danh</th>
                                    <th class="pb-4 pr-4">Mã thiết bị</th>
                                    <th class="pb-4 pr-4">Giới thiệu</th>
                                    <th class="pb-4 pr-4">Hoạt động</th>
                                    <th class="pb-4 pr-4">Lần cuối</th>
                                    <th class="pb-4 pr-4">Tạo</th>
                                    <th class="pb-4 text-right">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @forelse($practiceProfiles as $practiceProfile)
                                    <tr class="border-b border-[#8b5e34]/5 hover:bg-[#8b5e34]/5 transition-all">
                                        <td class="py-4 font-bold text-[#4a2c11] pr-4">{{ $practiceProfile->dharma_name }}</td>
                                        <td class="py-4 pr-4 font-mono text-xs text-[#8b5e34]/80" title="{{ $practiceProfile->session_key }}">
                                            {{ \Illuminate\Support\Str::limit($practiceProfile->session_key, 14, '…') }}
                                        </td>
                                        <td class="py-4 pr-4">
                                            @if($practiceProfile->intro_completed_at)
                                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-[10px] font-bold uppercase">Đã hoàn tất</span>
                                            @else
                                                <span class="bg-amber-100 text-amber-900 px-2 py-1 rounded-full text-[10px] font-bold uppercase">Chưa xong</span>
                                            @endif
                                        </td>
                                        <td class="py-4 pr-4 tabular-nums">{{ number_format($practiceProfile->activities_count) }}</td>
                                        <td class="py-4 pr-4 text-gray-600 whitespace-nowrap">{{ optional($practiceProfile->last_seen_at)->format('d/m/Y H:i') ?? '—' }}</td>
                                        <td class="py-4 pr-4 text-gray-600 whitespace-nowrap">{{ $practiceProfile->created_at->format('d/m/Y') }}</td>
                                        <td class="py-4 text-right">
                                            <button
                                                type="button"
                                                wire:click="deletePracticeProfile({{ $practiceProfile->id }})"
                                                wire:confirm="Xóa hồ sơ này và toàn bộ nhật ký tu học liên quan?"
                                                class="p-2 text-gray-400 hover:text-red-500"
                                                title="Xóa"
                                            >
                                                <x-icon name="trash-2" class="w-4 h-4" />
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-10 text-center text-[#8b5e34]/70">Chưa có hồ sơ phật tử nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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

    @if($showDailyWishModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
            <div class="glass w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-serif font-bold">{{ $editingDailyWishId ? 'Cập nhật lời nguyện' : 'Lời nguyện mới' }}</h2>
                    <button type="button" wire:click="closeDailyWishModal" class="p-2 hover:bg-[#8b5e34]/10 rounded-full" aria-label="Đóng modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="saveDailyWish" class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Nội dung (xuống dòng được)</label>
                        <textarea wire:model="dailyWishForm.text" rows="8" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none resize-y text-sm" placeholder="Mỗi đoạn có thể xuống dòng..."></textarea>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Icon</label>
                            <select wire:model="dailyWishForm.icon" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 outline-none">
                                <option value="lotus">Hoa sen</option>
                                <option value="light">Ánh sáng</option>
                                <option value="meditation">Thiền</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Thứ tự hiển thị</label>
                            <input wire:model="dailyWishForm.sort_order" type="number" min="0" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 outline-none">
                        </div>
                    </div>
                    <label class="inline-flex items-center gap-3 cursor-pointer">
                        <input wire:model="dailyWishForm.is_active" type="checkbox" class="rounded border-[#8b5e34]/30 text-[#8b5e34] focus:ring-[#8b5e34]">
                        <span class="text-sm font-semibold text-[#4a2c11]">Hiển thị trên trang chủ</span>
                    </label>
                    @error('dailyWishForm.*') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeDailyWishModal" class="flex-1 py-3 rounded-full font-bold border border-[#8b5e34]/20 hover:bg-white transition-all text-sm">Hủy</button>
                        <button type="submit" class="flex-1 py-3 rounded-full font-bold bg-[#4a2c11] text-white hover:bg-[#8b5e34] shadow-lg transition-all text-sm">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if($showUtilityModal)
        <div class="fixed inset-0 z-[100] flex items-center justify-center bg-black/30 backdrop-blur-sm p-4">
            <div class="glass w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-serif font-bold">{{ $editingUtilityId ? 'Cập nhật tiện ích' : 'Tiện ích mới' }}</h2>
                    <button type="button" wire:click="closeUtilityModal" class="p-2 hover:bg-[#8b5e34]/10 rounded-full" aria-label="Đóng modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                        </svg>
                    </button>
                </div>
                <form wire:submit="saveUtility" class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Tên hiển thị</label>
                        <input wire:model="utilityForm.name" type="text" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none" placeholder="VD: Máy niệm phật">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">URL icon (ảnh)</label>
                        <input wire:model="utilityForm.icon_url" type="url" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none" placeholder="https://...">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Liên kết khi click</label>
                        <input wire:model="utilityForm.link_url" type="text" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 focus:ring-2 focus:ring-[#8b5e34]/20 outline-none" placeholder="/tien-ich/may-niem-phat hoặc /#mục-trên-trang-chủ">
                        <p class="text-[10px] text-[#8b5e34]/60 mt-2 px-1">Có thể dùng đường dẫn tương đối: <code class="text-[11px]">/tien-ich/...</code> hoặc neo trang chủ <code class="text-[11px]">/#thu-vien-kinh-dien</code>.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold uppercase tracking-widest text-[#8b5e34] mb-2 px-1">Thứ tự</label>
                            <input wire:model="utilityForm.sort_order" type="number" min="1" class="w-full px-5 py-3 rounded-2xl border border-[#8b5e34]/10 bg-white/50 outline-none">
                        </div>
                        <div class="flex items-end pb-1">
                            <label class="inline-flex items-center gap-3 cursor-pointer">
                                <input wire:model="utilityForm.is_active" type="checkbox" class="rounded border-[#8b5e34]/30 text-[#8b5e34] focus:ring-[#8b5e34]">
                                <span class="text-sm font-semibold text-[#4a2c11]">Hiển thị trên trang chủ</span>
                            </label>
                        </div>
                    </div>
                    @error('utilityForm.*') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeUtilityModal" class="flex-1 py-3 rounded-full font-bold border border-[#8b5e34]/20 hover:bg-white transition-all text-sm">Hủy</button>
                        <button type="submit" class="flex-1 py-3 rounded-full font-bold bg-[#4a2c11] text-white hover:bg-[#8b5e34] shadow-lg transition-all text-sm">Lưu</button>
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
