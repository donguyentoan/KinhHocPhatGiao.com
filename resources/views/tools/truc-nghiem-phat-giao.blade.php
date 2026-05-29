<x-layouts.tool title="Trắc nghiệm Phật giáo">
    @push('head')
        <style>
            .quiz-option { transition: border-color 0.15s ease, background-color 0.15s ease, box-shadow 0.15s ease; }
            .quiz-option:not(:disabled):hover { border-color: #c9a77c; background-color: #faf6f0; }
            .quiz-option.is-selected { border-color: #8b5e34; background-color: #f7f2eb; box-shadow: 0 0 0 2px rgba(139, 94, 52, 0.15); }
            .quiz-option.is-correct { border-color: #2d6a4f; background-color: #edf7f1; }
            .quiz-option.is-wrong { border-color: #b45309; background-color: #fef3e7; }
            .quiz-option.is-reveal-correct { border-color: #2d6a4f; background-color: #edf7f1; box-shadow: 0 0 0 2px rgba(45, 106, 79, 0.12); }
            .quiz-card { scroll-margin-top: 5rem; }
            @keyframes quiz-fade-in {
                from { opacity: 0; transform: translateY(6px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .quiz-result-show { animation: quiz-fade-in 0.35s ease forwards; }
        </style>
    @endpush

    @php
        $questions = $questions ?? [];
        $totalQuestions = count($questions);
    @endphp

    <div class="max-w-3xl mx-auto space-y-6">
        <div class="rounded-2xl border border-[#e8e0d4] bg-white/90 p-5 sm:p-6 shadow-sm">
            <p class="text-[#6b5346] text-base leading-relaxed">
                Bộ câu hỏi ngắn dành cho người mới học Phật pháp
                @if($totalQuestions > 0)
                    — gồm <strong class="text-[#1a1512]">{{ $totalQuestions }} câu</strong> về Tứ Diệu Đế, Bát Chánh Đạo, nhân quả, luân hồi, ngũ giới, từ bi và chánh niệm.
                    Chọn một đáp án cho mỗi câu, rồi bấm <strong class="text-[#1a1512]">Nộp bài</strong> để xem kết quả và lời giải thích.
                @else
                    hiện chưa có câu hỏi nào. Quản trị viên có thể thêm câu hỏi trong Dashboard → Trắc nghiệm.
                @endif
            </p>
            @if($totalQuestions > 0)
                <div class="mt-4 flex flex-wrap items-center gap-3 text-sm">
                    <span class="inline-flex items-center gap-2 rounded-full bg-[#f7f2eb] border border-[#e8e0d4] px-3 py-1.5 text-[#5c4a3d]">
                        <i class="fa-solid fa-circle-question text-[#8b5e34]" aria-hidden="true"></i>
                        <span id="quiz-progress">0 / {{ $totalQuestions }} đã trả lời</span>
                    </span>
                    <button type="button" id="quiz-reset" class="inline-flex items-center gap-2 rounded-full border border-[#d4c9b8] bg-white px-3 py-1.5 font-semibold text-[#8b5e34] hover:bg-[#faf6f0] transition">
                        <i class="fa-solid fa-rotate-left text-xs" aria-hidden="true"></i>
                        Làm lại
                    </button>
                </div>
            @endif
        </div>

        @if($totalQuestions === 0)
            <div class="rounded-2xl border border-dashed border-[#d4c9b8] bg-[#faf6f0] p-10 text-center">
                <i class="fa-solid fa-book-open text-3xl text-[#c9a77c] mb-4" aria-hidden="true"></i>
                <p class="text-[#6b5346]">Chưa có câu hỏi trắc nghiệm. Vui lòng quay lại sau.</p>
            </div>
        @else
            <form id="quiz-form" class="space-y-5" novalidate>
                @foreach ($questions as $index => $q)
                    <article
                        id="quiz-q-{{ $index + 1 }}"
                        class="quiz-card rounded-2xl border border-[#e8e0d4] bg-white p-5 sm:p-6 shadow-sm"
                        data-question="{{ $index + 1 }}"
                        data-answer="{{ $q['answer'] }}"
                    >
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            <span class="inline-flex h-7 min-w-[1.75rem] items-center justify-center rounded-lg bg-[#8b5e34] px-2 text-xs font-bold text-white">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-xs font-bold uppercase tracking-wider text-[#8a7d72]">{{ $q['topic'] }}</span>
                        </div>

                        <h2 class="font-serif text-lg sm:text-xl font-bold text-[#1a1512] leading-snug mb-4">
                            {{ $q['text'] }}
                        </h2>

                        <fieldset class="space-y-2.5 border-0 p-0 m-0">
                            <legend class="sr-only">Câu {{ $index + 1 }}</legend>
                            @foreach ($q['options'] as $key => $label)
                                <label class="quiz-option flex cursor-pointer items-start gap-3 rounded-xl border border-[#e8e0d4] bg-[#fdfaf5] px-4 py-3">
                                    <input
                                        type="radio"
                                        name="q{{ $index + 1 }}"
                                        value="{{ $key }}"
                                        class="mt-1 h-4 w-4 shrink-0 accent-[#8b5e34]"
                                    >
                                    <span class="text-sm sm:text-base text-sm sm:text-base text-[#4a2c11] leading-relaxed">
                                        <span class="font-bold text-[#8b5e34]">{{ $key }}.</span> {{ $label }}
                                    </span>
                                </label>
                            @endforeach
                        </fieldset>

                        <div class="quiz-explain hidden mt-4 rounded-xl border border-[#d4e8dc] bg-[#f4fbf7] px-4 py-3 text-sm leading-relaxed text-[#2d4a3a]">
                            <p class="font-bold text-[#2d6a4f] mb-1">
                                <i class="fa-solid fa-check mr-1" aria-hidden="true"></i>
                                Đáp án đúng: <span class="quiz-correct-key">{{ $q['answer'] }}</span>
                            </p>
                            <p class="text-[#3d5c4a]">{{ $q['explain'] }}</p>
                        </div>
                    </article>
                @endforeach

                <div class="sticky bottom-4 z-10 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 rounded-2xl border border-[#e8e0d4] bg-[#fdfaf5]/95 backdrop-blur-sm p-4 shadow-lg">
                    <p class="text-sm text-[#6b5346] text-center sm:text-left" id="quiz-hint">Hãy trả lời đủ {{ $totalQuestions }} câu trước khi nộp bài.</p>
                    <button
                        type="submit"
                        id="quiz-submit"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-[#8b5e34] px-8 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#6f4a2b] transition active:scale-[0.98] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#8b5e34]/50"
                    >
                        <i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
                        Nộp bài
                    </button>
                </div>
            </form>

            <section id="quiz-result" class="hidden quiz-result-show rounded-2xl border-2 border-[#8b5e34]/30 bg-white p-6 sm:p-8 shadow-md text-center">
                <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-[#f7f2eb] text-[#8b5e34] text-2xl">
                    <i class="fa-solid fa-lotus" aria-hidden="true"></i>
                </div>
                <h2 class="font-serif text-2xl font-bold text-[#1a1512] mb-2">Kết quả của bạn</h2>
                <p class="text-4xl font-bold text-[#8b5e34] tabular-nums mb-2" id="quiz-score">0/{{ $totalQuestions }}</p>
                <p class="text-[#6b5346] text-base leading-relaxed max-w-md mx-auto" id="quiz-message"></p>
                <p class="mt-4 text-sm text-[#8a7d72]">Cuộn lên từng câu để đọc đáp án đúng và lời giải thích ngắn.</p>
                <p id="quiz-save-status" class="mt-3 text-sm text-[#2d6a4f] hidden" role="status"></p>
                <p class="mt-2 text-sm">
                    <a href="{{ route('account') }}" class="font-semibold text-[#8b5e34] hover:text-[#6f4a2b] underline">Xem lịch sử trong tài khoản tu học</a>
                </p>
            </section>
        @endif
    </div>

    @if($totalQuestions > 0)
        <script>
            (function () {
                const form = document.getElementById('quiz-form');
                const cards = Array.from(document.querySelectorAll('.quiz-card'));
                const total = cards.length;
                const progressEl = document.getElementById('quiz-progress');
                const hintEl = document.getElementById('quiz-hint');
                const resultEl = document.getElementById('quiz-result');
                const scoreEl = document.getElementById('quiz-score');
                const messageEl = document.getElementById('quiz-message');
                const saveStatusEl = document.getElementById('quiz-save-status');
                const resetBtn = document.getElementById('quiz-reset');
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                const completeUrl = @json(route('tools.quiz.complete'));

                function countAnswered() {
                    return cards.filter(function (card) {
                        return card.querySelector('input[type="radio"]:checked');
                    }).length;
                }

                function updateProgress() {
                    const n = countAnswered();
                    progressEl.textContent = n + ' / ' + total + ' đã trả lời';
                    hintEl.textContent = n < total
                        ? 'Còn ' + (total - n) + ' câu chưa trả lời.'
                        : 'Đã trả lời đủ. Bạn có thể nộp bài.';
                }

                async function saveQuizResult(correctCount) {
                    if (!completeUrl) {
                        return;
                    }

                    try {
                        const response = await fetch(completeUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken || '',
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                correct_count: correctCount,
                                total_questions: total,
                            }),
                        });

                        if (!response.ok) {
                            throw new Error('save_failed');
                        }

                        if (saveStatusEl) {
                            saveStatusEl.textContent = 'Đã lưu kết quả vào tài khoản tu học của bạn.';
                            saveStatusEl.classList.remove('hidden');
                        }
                    } catch (error) {
                        if (saveStatusEl) {
                            saveStatusEl.textContent = 'Không lưu được kết quả. Bạn vẫn xem được điểm trên trang này.';
                            saveStatusEl.classList.remove('hidden');
                            saveStatusEl.classList.remove('text-[#2d6a4f]');
                            saveStatusEl.classList.add('text-[#b45309]');
                        }
                    }
                }

                function clearResults() {
                    resultEl.classList.add('hidden');
                    if (saveStatusEl) {
                        saveStatusEl.classList.add('hidden');
                        saveStatusEl.textContent = '';
                        saveStatusEl.classList.add('text-[#2d6a4f]');
                        saveStatusEl.classList.remove('text-[#b45309]');
                    }
                    cards.forEach(function (card) {
                        card.querySelector('.quiz-explain')?.classList.add('hidden');
                        card.querySelectorAll('.quiz-option').forEach(function (label) {
                            label.classList.remove('is-selected', 'is-correct', 'is-wrong', 'is-reveal-correct');
                            label.querySelector('input')?.removeAttribute('disabled');
                        });
                    });
                }

                form.addEventListener('change', function (e) {
                    if (e.target.matches('input[type="radio"]')) {
                        const card = e.target.closest('.quiz-card');
                        card.querySelectorAll('.quiz-option').forEach(function (label) {
                            label.classList.toggle('is-selected', label.contains(e.target) && e.target.checked);
                        });
                        updateProgress();
                    }
                });

                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    if (countAnswered() < total) {
                        hintEl.textContent = 'Vui lòng trả lời đủ ' + total + ' câu trước khi nộp bài.';
                        const firstEmpty = cards.find(function (card) {
                            return !card.querySelector('input[type="radio"]:checked');
                        });
                        firstEmpty?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    }

                    let correct = 0;
                    cards.forEach(function (card) {
                        const answer = card.dataset.answer;
                        const selected = card.querySelector('input[type="radio"]:checked');
                        const chosen = selected ? selected.value : null;
                        const explain = card.querySelector('.quiz-explain');

                        card.querySelectorAll('.quiz-option').forEach(function (label) {
                            const input = label.querySelector('input');
                            const val = input?.value;
                            label.classList.remove('is-selected');
                            input?.setAttribute('disabled', 'disabled');

                            if (val === answer) {
                                label.classList.add('is-reveal-correct');
                            }
                            if (chosen && val === chosen && val !== answer) {
                                label.classList.add('is-wrong');
                            }
                            if (chosen && val === chosen && val === answer) {
                                label.classList.add('is-correct');
                            }
                        });

                        if (chosen === answer) {
                            correct++;
                        }

                        explain?.classList.remove('hidden');
                    });

                    scoreEl.textContent = correct + '/' + total;
                    let msg = '';
                    if (correct === total) {
                        msg = 'Xuất sắc! Bạn đã nắm vững những kiến thức căn bản. Hãy tiếp tục đọc kinh và thực hành thêm.';
                    } else if (correct >= Math.ceil(total * 0.7)) {
                        msg = 'Khá tốt! Bạn đã hiểu phần lớn giáo lý cơ bản. Đọc lại phần giải thích bên dưới để củng cố thêm.';
                    } else if (correct >= Math.ceil(total * 0.4)) {
                        msg = 'Bạn đã có nền tảng ban đầu. Hãy đọc kỹ lời giải thích từng câu và thử lại nhé.';
                    } else {
                        msg = 'Đừng nản lòng — học Phật pháp là hành trình dài. Hãy đọc lại giải thích và làm lại bài trắc nghiệm.';
                    }
                    messageEl.textContent = msg;
                    resultEl.classList.remove('hidden');
                    resultEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    saveQuizResult(correct);
                });

                resetBtn.addEventListener('click', function () {
                    form.reset();
                    clearResults();
                    updateProgress();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });

                updateProgress();
            })();
        </script>
    @endif
</x-layouts.tool>
