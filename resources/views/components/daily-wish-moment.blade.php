{{--
  Lời nguyện / quán chiếu — nhúng: <x-daily-wish-moment :wishes="$dailyWishes" />
  Tùy chỉnh: section-title, section-description
--}}
@props([
    'wishes' => null,
    'sectionTitle' => 'Lời nguyện & quán chiếu',
    'sectionDescription' => 'Mỗi lần vào trang hoặc khi bạn bấm nút, một lời khấn nguyện ngắn được chọn ngẫu nhiên — để đọc chậm, thở nhẹ và quán chiếu giữa nhịp sống.',
])

@php
    $wishesData = [];
    if ($wishes !== null && count($wishes) > 0) {
        $wishesData = collect($wishes)
            ->map(fn ($w) => [
                'id' => $w->id,
                'icon' => $w->icon,
                'text' => $w->text,
            ])
            ->values()
            ->all();
    } else {
        $wishesPath = resource_path('data/daily_wishes.json');
        if (is_readable($wishesPath)) {
            $decoded = json_decode((string) file_get_contents($wishesPath), true);
            $wishesData = is_array($decoded) ? $decoded : [];
        }
    }
@endphp

<section id="loi-nguyen" class="khpg-daily-wish" aria-labelledby="khpg-dw-heading">
    <script type="application/json" class="khpg-daily-wish__data">@json($wishesData)</script>
    <div class="khpg-daily-wish__shell">
        <div class="khpg-daily-wish__ambient" aria-hidden="true"></div>
        <div class="khpg-daily-wish__grid">
            <div class="khpg-daily-wish__intro">
                <header class="khpg-daily-wish__section-head">
                    <span class="khpg-daily-wish__accent" aria-hidden="true"></span>
                    <div class="khpg-daily-wish__section-text">
                        <h2 id="khpg-dw-heading" class="khpg-daily-wish__heading">{{ $sectionTitle }}</h2>
                        <p class="khpg-daily-wish__desc">{{ $sectionDescription }}</p>
                    </div>
                </header>

                <div class="khpg-daily-wish__ornament" aria-hidden="true">
                    <span class="khpg-daily-wish__ornament-line"></span>
                    <span class="khpg-daily-wish__ornament-icon">@include('components.partials.icon-lotus')</span>
                    <span class="khpg-daily-wish__ornament-line"></span>
                </div>

                <div class="khpg-daily-wish__features" aria-hidden="true">
                    <div class="khpg-daily-wish__feature" data-icon="lotus">
                        <span class="khpg-daily-wish__feature-ring">
                            @include('components.partials.icon-lotus')
                        </span>
                        <span class="khpg-daily-wish__feature-label">Đọc chậm</span>
                    </div>
                    <div class="khpg-daily-wish__feature" data-icon="light">
                        <span class="khpg-daily-wish__feature-ring">
                            @include('components.partials.icon-light')
                        </span>
                        <span class="khpg-daily-wish__feature-label">Thở nhẹ</span>
                    </div>
                    <div class="khpg-daily-wish__feature" data-icon="meditation">
                        <span class="khpg-daily-wish__feature-ring">
                            @include('components.partials.icon-meditation')
                        </span>
                        <span class="khpg-daily-wish__feature-label">Quán chiếu</span>
                    </div>
                </div>
            </div>

            <div class="khpg-daily-wish__card-wrap">
                <div class="khpg-daily-wish__card">
                    <div class="khpg-daily-wish__emblem" aria-hidden="true">
                        @include('components.partials.icon-lotus')
                    </div>
                    <p class="khpg-daily-wish__kicker">Đọc chậm, thở nhẹ, quán chiếu</p>
                    <blockquote class="khpg-daily-wish__quote-wrap">
                        <p class="khpg-daily-wish__quote js-khpg-dw-quote" lang="vi" aria-live="polite"></p>
                    </blockquote>
                    <div class="khpg-daily-wish__ornament khpg-daily-wish__ornament--card" aria-hidden="true">
                        <span class="khpg-daily-wish__ornament-line"></span>
                        <span class="khpg-daily-wish__ornament-icon">@include('components.partials.icon-lotus')</span>
                        <span class="khpg-daily-wish__ornament-line"></span>
                    </div>
                    <div class="khpg-daily-wish__actions">
                        <button type="button" class="khpg-daily-wish__btn khpg-daily-wish__btn--primary js-khpg-dw-next">
                            <i class="fa-solid fa-wand-magic-sparkles" aria-hidden="true"></i>
                            Lời nguyện khác
                        </button>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@once
        @push('head')
            <style>
                .khpg-daily-wish__data { display: none !important; }

                .khpg-daily-wish {
                    --dw-shell: #1c1816;
                    --dw-shell-edge: #2a2420;
                    --dw-intro-heading: #faf6f0;
                    --dw-intro-desc: rgba(250, 246, 240, 0.78);
                    --dw-gold: #d4a373;
                    --dw-gold-deep: #b07d4f;
                    --dw-card: #faf6f0;
                    --dw-card-text: #2c2118;
                    --dw-card-muted: #5c4d42;
                    --dw-focus: #e8b86a;
                    box-sizing: border-box;
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    padding: 1.25rem 0.75rem 1.5rem;
                    scroll-margin-top: 5.5rem;
                    background: transparent;
                }

                .khpg-daily-wish__shell {
                    position: relative;
                    width: 100%;
                    max-width: 72rem;
                    margin: 0 auto;
                    padding: clamp(1.75rem, 4vw, 2.75rem) clamp(1.25rem, 3vw, 2.5rem);
                    border-radius: 1.75rem;
                    background: linear-gradient(145deg, var(--dw-shell-edge) 0%, var(--dw-shell) 48%, #141110 100%);
                    border: 1px solid rgba(212, 163, 115, 0.14);
                    box-shadow:
                        0 28px 56px rgba(0, 0, 0, 0.22),
                        inset 0 1px 0 rgba(255, 255, 255, 0.04);
                    overflow: hidden;
                }

                .khpg-daily-wish__ambient {
                    pointer-events: none;
                    position: absolute;
                    left: -12%;
                    bottom: -35%;
                    width: 55%;
                    height: 85%;
                    background:
                        radial-gradient(ellipse 70% 60% at 40% 70%, rgba(255, 200, 120, 0.18) 0%, transparent 55%),
                        radial-gradient(ellipse 50% 45% at 55% 65%, rgba(255, 235, 200, 0.12) 0%, transparent 50%);
                    opacity: 0.9;
                }

                .khpg-daily-wish__grid {
                    position: relative;
                    z-index: 1;
                    display: grid;
                    gap: 2rem 2.5rem;
                    align-items: center;
                }

                @media (min-width: 900px) {
                    .khpg-daily-wish__grid {
                        grid-template-columns: minmax(0, 1fr) minmax(0, 26rem);
                        gap: 2.5rem 3rem;
                    }
                }

                .khpg-daily-wish__intro {
                    text-align: left;
                }

                .khpg-daily-wish__section-head {
                    display: flex;
                    align-items: flex-start;
                    gap: 1rem;
                    margin-bottom: 1.25rem;
                }

                .khpg-daily-wish__accent {
                    width: 0.45rem;
                    min-height: 2.75rem;
                    border-radius: 9999px;
                    background: linear-gradient(180deg, #e8b86a 0%, var(--dw-gold-deep) 100%);
                    flex-shrink: 0;
                    margin-top: 0.35rem;
                    box-shadow: 0 2px 14px rgba(212, 163, 115, 0.4);
                }

                .khpg-daily-wish__section-text { flex: 1; min-width: 0; }

                .khpg-daily-wish__heading {
                    font-family: 'Noto Serif Display', Georgia, 'Times New Roman', serif;
                    font-size: clamp(1.45rem, 3.2vw, 2rem);
                    font-weight: 700;
                    color: var(--dw-intro-heading);
                    margin: 0 0 0.65rem;
                    line-height: 1.25;
                    letter-spacing: -0.02em;
                }

                .khpg-daily-wish__desc {
                    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                    font-size: 0.9375rem;
                    line-height: 1.75;
                    color: var(--dw-intro-desc);
                    margin: 0;
                    max-width: 38rem;
                }

                @media (min-width: 640px) {
                    .khpg-daily-wish__desc { font-size: 1rem; }
                }

                .khpg-daily-wish__ornament {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.65rem;
                    margin: 0 0 1.35rem;
                    max-width: 22rem;
                }

                .khpg-daily-wish__ornament-line {
                    flex: 1;
                    height: 1px;
                    background: linear-gradient(90deg, transparent, rgba(212, 163, 115, 0.45), transparent);
                }

                .khpg-daily-wish__ornament-icon {
                    display: flex;
                    color: var(--dw-gold);
                    opacity: 0.85;
                }

                .khpg-daily-wish__ornament-icon svg {
                    width: 1rem;
                    height: 1rem;
                }

                .khpg-daily-wish__features {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 0.75rem 0.5rem;
                    max-width: 21rem;
                    width: 100%;
                }

                .khpg-daily-wish__feature {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 0.5rem;
                    width: auto;
                    min-width: 0;
                    text-align: center;
                }

                .khpg-daily-wish__feature-ring {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 3.25rem;
                    height: 3.25rem;
                    border-radius: 9999px;
                    background: rgba(255, 255, 255, 0.06);
                    border: 1px solid rgba(212, 163, 115, 0.22);
                    color: var(--dw-gold);
                    opacity: 0.5;
                    transition: opacity 0.35s ease, transform 0.35s ease, box-shadow 0.35s ease, background 0.35s ease;
                }

                .khpg-daily-wish__feature-ring svg {
                    width: 1.35rem;
                    height: 1.35rem;
                }

                .khpg-daily-wish__feature.is-active .khpg-daily-wish__feature-ring {
                    opacity: 1;
                    transform: scale(1.06);
                    background: rgba(212, 163, 115, 0.12);
                    box-shadow: 0 0 24px rgba(212, 163, 115, 0.2);
                }

                .khpg-daily-wish__feature-label {
                    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                    font-size: 0.7rem;
                    font-weight: 600;
                    letter-spacing: 0.04em;
                    color: rgba(250, 246, 240, 0.72);
                }

                .khpg-daily-wish__feature.is-active .khpg-daily-wish__feature-label {
                    color: var(--dw-gold);
                }

                .khpg-daily-wish__card-wrap {
                    display: flex;
                    justify-content: center;
                }

                @media (min-width: 900px) {
                    .khpg-daily-wish__card-wrap { justify-content: flex-end; }
                }

                .khpg-daily-wish__card {
                    width: 100%;
                    max-width: 26rem;
                    padding: 1.85rem 1.5rem 1.65rem;
                    border-radius: 1.5rem;
                    background: var(--dw-card);
                    border: 1px solid rgba(44, 33, 24, 0.08);
                    box-shadow:
                        0 20px 48px rgba(0, 0, 0, 0.28),
                        0 0 0 1px rgba(255, 255, 255, 0.5) inset;
                    text-align: center;
                }

                @media (min-width: 640px) {
                    .khpg-daily-wish__card {
                        padding: 2rem 1.85rem 1.75rem;
                        border-radius: 1.75rem;
                    }
                }

                .khpg-daily-wish__emblem {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 3.25rem;
                    height: 3.25rem;
                    margin: 0 auto 1rem;
                    border-radius: 9999px;
                    background: linear-gradient(145deg, #fff9f0 0%, #f0e4d4 100%);
                    border: 2px solid rgba(212, 163, 115, 0.55);
                    color: var(--dw-gold-deep);
                    box-shadow: 0 6px 20px rgba(176, 125, 79, 0.2);
                }

                .khpg-daily-wish__emblem svg {
                    width: 1.45rem;
                    height: 1.45rem;
                }

                .khpg-daily-wish__card .khpg-daily-wish__kicker {
                    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                    font-size: 0.62rem;
                    font-weight: 700;
                    letter-spacing: 0.26em;
                    text-transform: uppercase;
                    color: var(--dw-gold-deep);
                    margin: 0 0 1.1rem;
                    opacity: 0.95;
                }

                .khpg-daily-wish__quote-wrap {
                    margin: 0 0 1.15rem;
                    padding: 0;
                    border: none;
                }

                .khpg-daily-wish__card .khpg-daily-wish__quote {
                    margin: 0;
                    font-family: 'Noto Serif Display', Georgia, serif;
                    font-size: clamp(1.05rem, 2.8vw, 1.22rem);
                    font-weight: 400;
                    line-height: 1.75;
                    color: var(--dw-card-text);
                    white-space: pre-line;
                    min-height: 6.5rem;
                    transition: opacity 0.28s ease;
                }

                .khpg-daily-wish__quote.is-fading { opacity: 0; }

                .khpg-daily-wish__ornament--card {
                    margin: 0 auto 1.35rem;
                    max-width: 14rem;
                }

                .khpg-daily-wish__ornament--card .khpg-daily-wish__ornament-line {
                    background: linear-gradient(90deg, transparent, rgba(176, 125, 79, 0.35), transparent);
                }

                .khpg-daily-wish__ornament--card .khpg-daily-wish__ornament-icon {
                    color: var(--dw-gold-deep);
                }

                .khpg-daily-wish__actions {
                    display: flex;
                    flex-direction: column;
                    gap: 0.65rem;
                    align-items: stretch;
                }

                @media (min-width: 400px) {
                    .khpg-daily-wish__actions {
                        flex-direction: row;
                        justify-content: center;
                        flex-wrap: wrap;
                    }
                }

                .khpg-daily-wish__btn {
                    font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
                    font-size: 0.8125rem;
                    font-weight: 600;
                    padding: 0.72rem 1.2rem;
                    border-radius: 9999px;
                    cursor: pointer;
                    border: 2px solid transparent;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.45rem;
                    transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
                }

                .khpg-daily-wish__btn:focus-visible {
                    outline: 3px solid var(--dw-focus);
                    outline-offset: 3px;
                }

                .khpg-daily-wish__btn:active { transform: scale(0.98); }

                .khpg-daily-wish__btn--primary {
                    background: linear-gradient(165deg, #e0b388 0%, var(--dw-gold) 45%, #c98c54 100%);
                    color: #1a1512;
                    box-shadow: 0 4px 16px rgba(176, 125, 79, 0.35);
                }

                .khpg-daily-wish__btn--primary:hover {
                    box-shadow: 0 6px 22px rgba(176, 125, 79, 0.45);
                    filter: brightness(1.03);
                }

                .khpg-daily-wish__btn--ghost {
                    background: transparent;
                    color: var(--dw-card-muted);
                    border-color: rgba(92, 77, 66, 0.35);
                }

                .khpg-daily-wish__btn--ghost:hover {
                    background: rgba(44, 33, 24, 0.05);
                    border-color: rgba(92, 77, 66, 0.55);
                    color: var(--dw-card-text);
                }

                .khpg-daily-wish *, .khpg-daily-wish *::before, .khpg-daily-wish *::after { box-sizing: border-box; }

                @media (max-width: 899px) {
                    .khpg-daily-wish {
                        padding: 0.75rem 0.5rem 1.25rem;
                    }

                    .khpg-daily-wish__shell {
                        padding: 1.35rem 1rem 1.5rem;
                        border-radius: 1.35rem;
                    }

                    .khpg-daily-wish__grid {
                        gap: 1.35rem;
                    }

                    .khpg-daily-wish__intro {
                        text-align: center;
                    }

                    .khpg-daily-wish__section-head {
                        text-align: left;
                    }

                    .khpg-daily-wish__ornament {
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .khpg-daily-wish__features {
                        margin-left: auto;
                        margin-right: auto;
                    }

                    .khpg-daily-wish__feature-label {
                        font-size: 0.65rem;
                        line-height: 1.25;
                    }

                    .khpg-daily-wish__card {
                        padding: 1.5rem 1.15rem 1.35rem;
                    }

                    .khpg-daily-wish__card .khpg-daily-wish__quote {
                        min-height: 4.75rem;
                        font-size: 1.05rem;
                        line-height: 1.7;
                    }

                    .khpg-daily-wish__actions {
                        flex-direction: column;
                        align-items: stretch;
                    }

                    .khpg-daily-wish__btn {
                        width: 100%;
                    }
                }

                @media (min-width: 900px) {
                    .khpg-daily-wish__features {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 1rem 1.35rem;
                        max-width: 26rem;
                    }

                    .khpg-daily-wish__feature {
                        width: 5.5rem;
                    }
                }

                @media (prefers-reduced-motion: reduce) {
                    .khpg-daily-wish__quote,
                    .khpg-daily-wish__feature-ring {
                        transition: none !important;
                    }
                }
            </style>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    document.querySelectorAll('.khpg-daily-wish').forEach(function (root) {
                        var dataEl = root.querySelector('.khpg-daily-wish__data');
                        var wishes = [];
                        try { wishes = JSON.parse((dataEl && dataEl.textContent) ? dataEl.textContent.trim() : '[]'); } catch (e) { wishes = []; }
                        if (!Array.isArray(wishes) || wishes.length === 0) {
                            wishes = [{ icon: 'lotus', text: 'Nguyện hôm nay tâm con an tịnh,\nđọc chậm và quán chiếu từng hơi thở.' }];
                        }

                        var quoteEl = root.querySelector('.js-khpg-dw-quote');
                        var btnNext = root.querySelector('.js-khpg-dw-next');
                        var featureEls = root.querySelectorAll('.khpg-daily-wish__feature');
                        var lastIdx = -1;

                        if (!quoteEl) return;

                        function pickIndex() {
                            if (wishes.length <= 1) return 0;
                            var i;
                            var guard = 0;
                            do {
                                i = Math.floor(Math.random() * wishes.length);
                                guard++;
                            } while (i === lastIdx && guard < 24);
                            return i;
                        }

                        function setActiveIcon(name) {
                            featureEls.forEach(function (el) {
                                el.classList.toggle('is-active', el.getAttribute('data-icon') === name);
                            });
                        }

                        function render(idx, animate) {
                            var item = wishes[idx] || wishes[0];
                            var text = (item && item.text) ? String(item.text) : '';
                            var icon = (item && item.icon) ? String(item.icon) : 'lotus';
                            if (!['lotus', 'light', 'meditation'].includes(icon)) icon = 'lotus';

                            function apply() {
                                quoteEl.textContent = text;
                                setActiveIcon(icon);
                                lastIdx = idx;
                                quoteEl.classList.remove('is-fading');
                            }

                            var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                            if (animate && !reduceMotion) {
                                quoteEl.classList.add('is-fading');
                                setTimeout(apply, 260);
                            } else {
                                apply();
                            }
                        }

                        render(pickIndex(), false);

                        if (btnNext) btnNext.addEventListener('click', function () {
                            render(pickIndex(), true);
                        });
                    });
                });
            </script>
        @endpush
    @endonce
