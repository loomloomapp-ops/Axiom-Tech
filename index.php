<?php
$lang = isset($_GET['lang']) && $_GET['lang'] === 'pl' ? 'pl' : 'uk';
setcookie('lang', $lang, time() + 60 * 60 * 24 * 365, '/');
$T = require __DIR__ . '/lang/' . $lang . '.php';

function asset_v(string $rel): int {
    $path = __DIR__ . '/' . ltrim($rel, '/');
    return @filemtime($path) ?: time();
}
$smartImg = 'assets/images/products/axiom-smart-ai.jpg';
$basicImg = 'assets/images/products/axiom-basic.png';
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($T['html_lang']) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#F7F6F3">
<title><?= htmlspecialchars($T['meta_title']) ?></title>
<meta name="description" content="<?= htmlspecialchars($T['meta_description']) ?>">

<link rel="icon" type="image/png" href="<?= $smartImg /* fallback */ ?>" sizes="any">
<link rel="icon" type="image/png" href="assets/images/logo/axiom-black.png?v=<?= asset_v('assets/images/logo/axiom-black.png') ?>">
<link rel="apple-touch-icon" href="assets/images/logo/axiom-black.png?v=<?= asset_v('assets/images/logo/axiom-black.png') ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?= htmlspecialchars($T['meta_title']) ?>">
<meta property="og:description" content="<?= htmlspecialchars($T['meta_description']) ?>">
<meta property="og:image" content="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>">
<meta property="og:locale" content="<?= htmlspecialchars($T['locale']) ?>">
<meta name="twitter:card" content="summary_large_image">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@300;400;500;600;700&family=Geist+Mono:wght@400;500&family=Fraunces:ital,opsz,wght@1,144,300..500&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/main.css?v=<?= asset_v('assets/css/main.css') ?>">

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Axiom Technology",
  "description": "<?= addslashes($T['meta_description']) ?>",
  "url": "https://axiom-technology.eu/",
  "logo": "https://axiom-technology.eu/assets/images/logo/axiom-black.png",
  "address": {"@type":"PostalAddress","addressCountry":"PL","addressLocality":"Kraków"},
  "sameAs": ["https://instagram.com/axiom.technology"]
}
</script>
</head>

<body class="page" data-lang="<?= htmlspecialchars($T['html_lang']) ?>">

<a href="#main" class="skip-link">Skip to content</a>

<div class="cursor" data-cursor aria-hidden="true">
    <div class="cursor-dot"></div>
    <div class="cursor-ring"></div>
</div>

<div class="page-grain" aria-hidden="true"></div>
<div class="page-glow" aria-hidden="true"></div>

<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main" class="main">

<!-- ========== HERO ========== -->
<section class="hero" id="top">
    <div class="hero-grid">

        <div class="hero-content">
            <span class="eyebrow eyebrow--hero" data-anim="fade-up"><span class="eyebrow-dot"></span><?= $T['hero']['eyebrow'] ?></span>

            <h1 class="hero-title">
                <span class="hero-line" data-split><?= $T['hero']['h1_a'] ?></span>
                <span class="hero-line" data-split><?= $T['hero']['h1_b'] ?></span>
                <span class="hero-line hero-line--em" data-split><em><?= $T['hero']['h1_em'] ?></em><span class="hero-mark" aria-hidden="true"></span></span>
            </h1>

            <p class="hero-sub" data-anim="fade-up"><?= $T['hero']['sub'] ?></p>

            <div class="hero-cta" data-anim="fade-up">
                <button type="button" class="btn btn--primary btn--lg" data-open-popup data-magnet>
                    <span><?= $T['hero']['cta'] ?></span>
                    <span class="btn-arrow" aria-hidden="true">
                        <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                </button>
                <a href="#products" class="btn btn--ghost btn--lg" data-magnet>
                    <span><?= $T['hero']['cta_ghost'] ?></span>
                </a>
            </div>

            <ul class="hero-trust" data-anim="fade-up">
                <?php foreach ($T['hero']['trust'] as $t): ?>
                    <li><span class="trust-dot" aria-hidden="true"></span><?= $t ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="hero-visual" data-anim="hero-visual">
            <div class="hero-glow" aria-hidden="true"></div>
            <div class="hero-grid-lines" aria-hidden="true">
                <span></span><span></span><span></span><span></span>
            </div>

            <figure class="hero-product">
                <div class="hero-product-frame">
                    <img src="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>" alt="Axiom Smart AI" class="hero-product-img" loading="eager" fetchpriority="high">
                </div>
                <figcaption class="sr-only">Axiom Smart AI laser device</figcaption>
            </figure>

            <div class="chip chip--1" data-chip="1" aria-hidden="true">
                <span class="chip-v"><?= $T['hero']['chip_1_v'] ?></span>
                <span class="chip-u"><?= $T['hero']['chip_1_u'] ?></span>
            </div>
            <div class="chip chip--2" data-chip="2" aria-hidden="true">
                <span class="chip-v"><?= $T['hero']['chip_2_v'] ?></span>
                <span class="chip-u"><?= $T['hero']['chip_2_u'] ?></span>
            </div>
            <div class="chip chip--3" data-chip="3" aria-hidden="true">
                <span class="chip-v"><?= $T['hero']['chip_3_v'] ?></span>
                <span class="chip-u"><?= $T['hero']['chip_3_u'] ?></span>
            </div>
        </div>
    </div>

    <div class="hero-marquee" aria-hidden="true">
        <div class="marquee-track" data-marquee>
            <span>755 nm</span><span>·</span><span>808 nm</span><span>·</span><span>940 nm</span><span>·</span><span>1064 nm</span><span>·</span>
            <span>FAC cooling</span><span>·</span><span>AI · 2000 W</span><span>·</span><span>Made for Europe</span><span>·</span>
            <span>755 nm</span><span>·</span><span>808 nm</span><span>·</span><span>940 nm</span><span>·</span><span>1064 nm</span><span>·</span>
            <span>FAC cooling</span><span>·</span><span>AI · 2000 W</span><span>·</span><span>Made for Europe</span><span>·</span>
        </div>
    </div>
</section>


<!-- ========== PRODUCTS ========== -->
<section class="products" id="products">
    <header class="section-head">
        <span class="eyebrow"><?= $T['products']['eyebrow'] ?></span>
        <h2 class="section-title" data-split-lines>
            <?= $T['products']['title_a'] ?> <em><?= $T['products']['title_em'] ?></em>
        </h2>
        <p class="section-sub" data-anim="fade-up"><?= $T['products']['sub'] ?></p>
        <div class="wave-strip" data-anim="fade-up">
            <span class="wave-dot"></span><?= $T['products']['wave'] ?>
        </div>
    </header>

    <div class="products-grid">
        <!-- Smart AI -->
        <article class="product-card product-card--featured" data-product>
            <div class="product-tag"><?= $T['products']['smart']['tag'] ?></div>

            <div class="product-image">
                <div class="product-image-glow" aria-hidden="true"></div>
                <img src="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>" alt="<?= htmlspecialchars($T['products']['smart']['name']) ?>" loading="lazy">
            </div>

            <div class="product-body">
                <h3 class="product-name"><?= $T['products']['smart']['name'] ?></h3>
                <p class="product-desc"><?= $T['products']['smart']['desc'] ?></p>

                <ul class="product-feats">
                    <?php foreach ($T['products']['smart']['feats'] as $f): ?>
                        <li><span class="feat-dot"></span><?= $f ?></li>
                    <?php endforeach; ?>
                </ul>

                <dl class="product-specs">
                    <?php foreach ($T['products']['smart']['specs'] as [$k, $v]): ?>
                        <div class="spec">
                            <dt><?= $k ?></dt>
                            <dd><?= $v ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>

                <button type="button" class="btn btn--primary btn--full" data-open-popup data-magnet>
                    <span><?= $T['products']['smart']['cta'] ?></span>
                    <span class="btn-arrow" aria-hidden="true">
                        <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                </button>
            </div>
        </article>

        <!-- Basic -->
        <article class="product-card" data-product>
            <div class="product-tag product-tag--muted"><?= $T['products']['basic']['tag'] ?></div>

            <div class="product-image">
                <div class="product-image-glow product-image-glow--soft" aria-hidden="true"></div>
                <img src="<?= $basicImg ?>?v=<?= asset_v($basicImg) ?>" alt="<?= htmlspecialchars($T['products']['basic']['name']) ?>" loading="lazy">
            </div>

            <div class="product-body">
                <h3 class="product-name"><?= $T['products']['basic']['name'] ?></h3>
                <p class="product-desc"><?= $T['products']['basic']['desc'] ?></p>

                <ul class="product-feats">
                    <?php foreach ($T['products']['basic']['feats'] as $f): ?>
                        <li><span class="feat-dot"></span><?= $f ?></li>
                    <?php endforeach; ?>
                </ul>

                <dl class="product-specs">
                    <?php foreach ($T['products']['basic']['specs'] as [$k, $v]): ?>
                        <div class="spec">
                            <dt><?= $k ?></dt>
                            <dd><?= $v ?></dd>
                        </div>
                    <?php endforeach; ?>
                </dl>

                <button type="button" class="btn btn--ghost btn--full" data-open-popup data-magnet>
                    <span><?= $T['products']['basic']['cta'] ?></span>
                </button>
            </div>
        </article>
    </div>

    <p class="finance-line" data-anim="fade-up">
        <span class="finance-mark" aria-hidden="true"></span><?= $T['products']['finance'] ?>
    </p>
</section>


<!-- ========== SALONS / INCOME PROOF ========== -->
<section class="salons">
    <header class="section-head">
        <span class="eyebrow"><?= $T['salons']['eyebrow'] ?></span>
        <h2 class="section-title section-title--lg" data-split-lines>
            <?= $T['salons']['title_a'] ?> <em><?= $T['salons']['title_em'] ?></em>
        </h2>
    </header>
    <div class="salons-grid">
        <p class="salons-text" data-anim="fade-up"><?= $T['salons']['p1'] ?></p>
        <p class="salons-text" data-anim="fade-up"><?= $T['salons']['p2'] ?></p>
    </div>
</section>


<!-- ========== INCOME / BIG NUMBER ========== -->
<section class="income" id="income">
    <header class="section-head section-head--centered">
        <span class="eyebrow"><?= $T['income']['eyebrow'] ?></span>
        <h2 class="section-title section-title--lg" data-split-lines>
            <?= $T['income']['title_a'] ?> <em><?= $T['income']['title_em'] ?></em>
        </h2>
        <p class="section-sub" data-anim="fade-up"><?= $T['income']['sub'] ?></p>
    </header>

    <div class="big-number" data-big-number>
        <span class="big-number-pre" data-anim="fade-up"><?= $T['income']['big_pre'] ?></span>
        <span class="big-number-v">
            <span class="bn-mask"><span class="bn-text"><?= $T['income']['big_v'] ?></span></span>
        </span>
        <span class="big-number-u" data-anim="fade-up"><?= $T['income']['big_u'] ?></span>
    </div>

    <ul class="income-rows">
        <?php foreach ($T['income']['rows'] as $i => [$label, $value, $unit]): ?>
            <li class="income-row" data-income-row>
                <span class="income-row-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <span class="income-row-label"><?= $label ?></span>
                <span class="income-row-value"><?= $value ?> <span class="income-row-unit"><?= $unit ?></span></span>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="income-cta" data-anim="fade-up">
        <p class="income-note"><?= $T['income']['note'] ?></p>
        <button type="button" class="btn btn--primary btn--lg" data-open-popup data-magnet>
            <span><?= $T['income']['cta'] ?></span>
            <span class="btn-arrow" aria-hidden="true">
                <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </button>
    </div>
</section>


<!-- ========== CALCULATOR ========== -->
<section class="calculator" id="calculator">
    <header class="section-head">
        <span class="eyebrow"><?= $T['calc']['eyebrow'] ?></span>
        <h2 class="section-title" data-split-lines>
            <?= $T['calc']['title_a'] ?> <em><?= $T['calc']['title_em'] ?></em>
        </h2>
        <p class="section-sub" data-anim="fade-up"><?= $T['calc']['sub'] ?></p>
    </header>

    <div class="calc-card" data-anim="fade-up">
        <div class="calc-grain" aria-hidden="true"></div>

        <div class="calc-controls">
            <div class="calc-field">
                <div class="calc-field-head">
                    <span class="calc-label"><?= $T['calc']['f_proc'] ?></span>
                    <span class="calc-value" data-out="proc">275</span>
                    <span class="calc-unit"><?= $T['calc']['f_proc_unit'] ?></span>
                </div>
                <input type="range" min="50" max="400" step="5" value="275" class="calc-slider" data-input="proc" aria-label="<?= htmlspecialchars($T['calc']['f_proc']) ?>">
                <div class="calc-scale">
                    <span>50</span><span>400</span>
                </div>
            </div>

            <div class="calc-field">
                <div class="calc-field-head">
                    <span class="calc-label"><?= $T['calc']['f_avg'] ?></span>
                    <span class="calc-value" data-out="avg">58</span>
                    <span class="calc-unit"><?= $T['calc']['f_avg_unit'] ?></span>
                </div>
                <input type="range" min="20" max="120" step="1" value="58" class="calc-slider" data-input="avg" aria-label="<?= htmlspecialchars($T['calc']['f_avg']) ?>">
                <div class="calc-scale">
                    <span>20 €</span><span>120 €</span>
                </div>
            </div>

            <div class="calc-field">
                <div class="calc-field-head">
                    <span class="calc-label"><?= $T['calc']['f_lease'] ?></span>
                    <span class="calc-value" data-out="lease">700</span>
                    <span class="calc-unit"><?= $T['calc']['f_lease_unit'] ?></span>
                </div>
                <input type="range" min="0" max="1500" step="50" value="700" class="calc-slider" data-input="lease" aria-label="<?= htmlspecialchars($T['calc']['f_lease']) ?>">
                <div class="calc-scale">
                    <span>0</span><span>1 500 €</span>
                </div>
            </div>
        </div>

        <div class="calc-results">
            <div class="calc-result calc-result--muted">
                <span class="calc-result-label"><?= $T['calc']['r_gross'] ?></span>
                <span class="calc-result-value" data-out="gross">15 950</span>
                <span class="calc-result-unit"><?= $T['calc']['r_unit'] ?></span>
            </div>
            <div class="calc-result calc-result--muted">
                <span class="calc-result-label"><?= $T['calc']['r_lease'] ?></span>
                <span class="calc-result-value" data-out="leaseOut">700</span>
                <span class="calc-result-unit"><?= $T['calc']['r_unit'] ?></span>
            </div>
            <div class="calc-result calc-result--accent">
                <span class="calc-result-label"><?= $T['calc']['r_net'] ?></span>
                <span class="calc-result-value calc-result-value--xl" data-out="net">15 250</span>
                <span class="calc-result-unit"><?= $T['calc']['r_unit'] ?></span>
                <div class="calc-result-glow" aria-hidden="true"></div>
            </div>

            <button type="button" class="btn btn--primary btn--full btn--lg" data-open-popup data-magnet>
                <span><?= $T['calc']['cta'] ?></span>
                <span class="btn-arrow" aria-hidden="true">
                    <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </button>
        </div>
    </div>
</section>


<!-- ========== INLINE CONSULTATION FORM ========== -->
<section class="consult" id="consult">
    <div class="consult-grid">
        <header class="consult-head">
            <span class="eyebrow"><?= $T['form']['eyebrow'] ?></span>
            <h2 class="section-title section-title--lg" data-split-lines>
                <?= $T['form']['title_a'] ?> <em><?= $T['form']['title_em'] ?></em>
            </h2>
            <p class="section-sub" data-anim="fade-up"><?= $T['form']['sub'] ?></p>

            <ul class="consult-bullets" data-anim="fade-up">
                <li><span class="cb-num">01</span><span>Менеджер зв’яжеться впродовж години</span></li>
                <li><span class="cb-num">02</span><span>Підбір моделі під формат бізнесу</span></li>
                <li><span class="cb-num">03</span><span>Прорахунок окупності для вашого випадку</span></li>
            </ul>
        </header>

        <div class="consult-form" data-anim="fade-up">
            <?php include __DIR__ . '/partials/form.php'; ?>
        </div>
    </div>
</section>


<!-- ========== ADVANTAGES ========== -->
<section class="advantages" id="advantages">
    <header class="section-head">
        <span class="eyebrow"><?= $T['advantages']['eyebrow'] ?></span>
        <h2 class="section-title" data-split-lines>
            <?= $T['advantages']['title_a'] ?> <em><?= $T['advantages']['title_em'] ?></em> <?= $T['advantages']['title_b'] ?>
        </h2>
        <p class="section-sub" data-anim="fade-up"><?= $T['advantages']['sub'] ?></p>
    </header>

    <ul class="advantage-grid">
        <?php foreach ($T['advantages']['items'] as $i => [$num, $title, $body]): ?>
            <li class="adv-card" data-adv-card>
                <span class="adv-num"><?= $num ?></span>
                <h3 class="adv-title"><?= $title ?></h3>
                <p class="adv-body"><?= $body ?></p>
                <div class="adv-line" aria-hidden="true"></div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>


<!-- ========== TESTIMONIALS ========== -->
<section class="testimonials">
    <header class="section-head">
        <span class="eyebrow"><?= $T['testimonials']['eyebrow'] ?></span>
        <h2 class="section-title" data-split-lines>
            <?= $T['testimonials']['title_a'] ?> <em><?= $T['testimonials']['title_em'] ?></em>
        </h2>
    </header>

    <div class="testimonial-rail" data-rail>
        <div class="testimonial-track" data-rail-track>
            <?php foreach ($T['testimonials']['list'] as $i => $t): ?>
                <article class="testimonial">
                    <span class="t-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <p class="t-text">“<?= $t['text'] ?>”</p>
                    <footer class="t-meta">
                        <strong class="t-name"><?= $t['name'] ?></strong>
                        <span class="t-role"><?= $t['role'] ?></span>
                        <span class="t-city"><?= $t['city'] ?></span>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="rail-controls">
            <button type="button" class="rail-btn" data-rail-prev aria-label="Previous">
                <svg viewBox="0 0 16 16" width="14" height="14"><path d="M13 8H3M7 4L3 8l4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button type="button" class="rail-btn" data-rail-next aria-label="Next">
                <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>
    </div>
</section>


<!-- ========== FAQ ========== -->
<section class="faq" id="faq">
    <header class="section-head">
        <span class="eyebrow"><?= $T['faq']['eyebrow'] ?></span>
        <h2 class="section-title"><?= $T['faq']['title'] ?></h2>
    </header>

    <ul class="faq-list">
        <?php foreach ($T['faq']['items'] as $i => $item): ?>
            <li class="faq-item" data-faq>
                <button type="button" class="faq-q" data-faq-toggle aria-expanded="false">
                    <span class="faq-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <span class="faq-q-text"><?= $item['q'] ?></span>
                    <span class="faq-icon" aria-hidden="true">
                        <span></span><span></span>
                    </span>
                </button>
                <div class="faq-a" data-faq-body>
                    <div class="faq-a-inner"><?= $item['a'] ?></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</section>


<!-- ========== FINAL CTA ========== -->
<section class="final">
    <div class="final-glow" aria-hidden="true"></div>
    <div class="final-inner">
        <h2 class="final-title" data-split-lines>
            <?= $T['final']['title_a'] ?> <em><?= $T['final']['title_em'] ?></em><?= $T['final']['title_b'] ?>
        </h2>
        <p class="final-sub" data-anim="fade-up"><?= $T['final']['sub'] ?></p>
        <button type="button" class="btn btn--primary btn--xl" data-open-popup data-magnet>
            <span><?= $T['final']['cta'] ?></span>
            <span class="btn-arrow" aria-hidden="true">
                <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        </button>
    </div>
</section>

</main>

<?php include __DIR__ . '/partials/footer.php'; ?>

<!-- Sticky mobile CTA -->
<a href="#" class="sticky-mobile-cta" data-open-popup>
    <span><?= $T['sticky_mobile_cta'] ?></span>
    <span class="smc-arrow" aria-hidden="true">
        <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
    </span>
</a>

<!-- Floating desktop widget -->
<a href="#calculator" class="floating-widget" data-floating>
    <span class="fw-icon" aria-hidden="true">
        <svg viewBox="0 0 20 20" width="14" height="14"><path d="M4 3h12v14H4zM7 7h6M7 11h6M7 15h3" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
    </span>
    <span><?= $T['floating_widget'] ?></span>
</a>

<?php include __DIR__ . '/partials/popup.php'; ?>

<!-- GSAP from CDN -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="assets/js/main.js?v=<?= asset_v('assets/js/main.js') ?>" defer></script>

</body>
</html>
