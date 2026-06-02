<?php
$lang = isset($_GET['lang']) && $_GET['lang'] === 'pl' ? 'pl' : 'uk';
setcookie('lang', $lang, time() + 60 * 60 * 24 * 365, '/');
$T = require __DIR__ . '/lang/' . $lang . '.php';
require_once __DIR__ . '/partials/icons.php';

function asset_v(string $rel): int {
    $path = __DIR__ . '/' . ltrim($rel, '/');
    return @filemtime($path) ?: time();
}
$smartImg = 'assets/images/products/axiom-smart-ai.png';
$basicImg = 'assets/images/products/axiom-basic.png';

$trustIcons = ['shield', 'cap', 'truck', 'euro', 'spark'];
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($T['html_lang']) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#F7F6F3">
<title><?= htmlspecialchars($T['meta_title']) ?></title>
<meta name="description" content="<?= htmlspecialchars($T['meta_description']) ?>">

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

<link rel="preload" as="image" href="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>" fetchpriority="high">
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

<body class="page is-loading" data-lang="<?= htmlspecialchars($T['html_lang']) ?>">

<a href="#main" class="skip-link">Skip to content</a>

<!-- Preloader -->
<div class="preloader" data-preloader role="status" aria-label="Loading">
    <div class="preloader-grid" aria-hidden="true">
        <span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="preloader-inner">
        <div class="preloader-mark">
            <div class="preloader-glow" aria-hidden="true"></div>
            <img src="assets/images/logo/axiom-black.png?v=<?= asset_v('assets/images/logo/axiom-black.png') ?>" alt="" class="preloader-logo">
        </div>
        <div class="preloader-line" aria-hidden="true">
            <span class="preloader-line-fill"></span>
            <span class="preloader-line-pulse"></span>
        </div>
        <div class="preloader-text" aria-hidden="true">
            <span>A</span><span>X</span><span>I</span><span>O</span><span>M</span>
            <span class="preloader-dot"></span>
            <span>T</span><span>E</span><span>C</span><span>H</span><span>N</span><span>O</span><span>L</span><span>O</span><span>G</span><span>Y</span>
        </div>
    </div>
</div>


<div class="page-grain" aria-hidden="true"></div>

<?php include __DIR__ . '/partials/header.php'; ?>

<main id="main" class="main">

<div class="slides-wrapper" data-slides>

<!-- ============================================================
     PANEL · HERO
     ============================================================ -->
<section class="panel panel--hero" id="top" data-panel>
    <div class="panel-content">

        <div class="hero-grid">

            <div class="hero-content">
                <span class="eyebrow eyebrow--hero" data-anim="fade-up">
                    <span class="eyebrow-dot"></span>
                    <?= $T['hero']['eyebrow'] ?>
                </span>

                <h1 class="hero-title" translate="no">
                    <span class="hero-line" data-split><?= $T['hero']['h1_l1'] ?></span>
                    <span class="hero-line" data-split><?= $T['hero']['h1_l2'] ?></span>
                    <span class="hero-line hero-line--em" data-split>
                        <em><?= $T['hero']['h1_em'] ?></em>
                    </span>
                </h1>

                <p class="hero-sub" data-anim="fade-up"><?= $T['hero']['sub'] ?></p>

                <div class="hero-cta" data-anim="fade-up">
                    <button type="button" class="btn btn--red btn--lg" data-open-popup data-magnet>
                        <span><?= $T['hero']['cta'] ?></span>
                        <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
                    </button>
                    <a href="#products" class="btn btn--ghost btn--lg" data-magnet>
                        <span><?= $T['hero']['cta_ghost'] ?></span>
                    </a>
                </div>

                <ul class="hero-trust" data-anim="fade-up">
                    <?php foreach ($T['hero']['trust'] as $i => $t): ?>
                        <li>
                            <span class="trust-icon"><?= icon($trustIcons[$i] ?? 'check', ['size' => 14, 'stroke' => 1.6]) ?></span>
                            <span><?= $t ?></span>
                        </li>
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
                        <img src="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>" alt="Axiom Smart AI laser device" class="hero-product-img" fetchpriority="high">
                        <div class="hero-product-floor" aria-hidden="true"></div>
                    </div>
                    <figcaption class="sr-only">Axiom Smart AI</figcaption>
                </figure>

                <div class="chip chip--1" data-chip="1" aria-hidden="true">
                    <span class="chip-icon"><?= icon('euro', ['size' => 14, 'stroke' => 1.6]) ?></span>
                    <div class="chip-body">
                        <span class="chip-v"><?= $T['hero']['chip_1_v'] ?></span>
                        <span class="chip-u"><?= $T['hero']['chip_1_u'] ?></span>
                    </div>
                </div>
                <div class="chip chip--2" data-chip="2" aria-hidden="true">
                    <span class="chip-icon"><?= icon('chart', ['size' => 14, 'stroke' => 1.6]) ?></span>
                    <div class="chip-body">
                        <span class="chip-v"><?= $T['hero']['chip_2_v'] ?></span>
                        <span class="chip-u"><?= $T['hero']['chip_2_u'] ?></span>
                    </div>
                </div>
                <div class="chip chip--3" data-chip="3" aria-hidden="true">
                    <span class="chip-icon"><?= icon('brain', ['size' => 14, 'stroke' => 1.6]) ?></span>
                    <div class="chip-body">
                        <span class="chip-v"><?= $T['hero']['chip_3_v'] ?></span>
                        <span class="chip-u"><?= $T['hero']['chip_3_u'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-marquee" aria-hidden="true">
            <div class="marquee-track">
                <?php for ($i = 0; $i < 4; $i++): ?>
                <span>755 nm</span><span class="m-dot"></span><span>808 nm</span><span class="m-dot"></span><span>940 nm</span><span class="m-dot"></span><span>1064 nm</span><span class="m-dot"></span>
                <span>FAC cooling</span><span class="m-dot"></span><span>AI · 2000 W</span><span class="m-dot"></span><span>Made for Europe</span><span class="m-dot"></span>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · INSIDE AXIOM
     5 cinematic frames — pinned scroll-pin scrub, editorial overlays
     ============================================================ -->
<section class="panel panel--inside" id="tech" data-panel-skip>

    <header class="inside-intro">
        <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['inside']['eyebrow'] ?></span>
        <h2 class="section-title section-title--lg" data-split-lines>
            <?= $T['inside']['title_a'] ?> <em><?= $T['inside']['title_em'] ?></em>
        </h2>
        <p class="section-sub" data-anim="fade-up"><?= $T['inside']['sub'] ?></p>
    </header>

    <div class="inside-track" data-inside-track style="--inside-frames: <?= count($T['inside']['frames']) ?>">
        <div class="inside-sticky">
            <div class="inside-pin">
                <div class="inside-stage" data-inside-stage>
                    <?php foreach ($T['inside']['frames'] as $i => $f):
                        $cropPos   = htmlspecialchars($f['crop_pos'] ?? '50% 50%');
                        $cropScale = htmlspecialchars($f['crop_scale'] ?? '1.3');
                        $imgPath   = $f['image'] ?? $smartImg;
                        $imgAlt    = trim(($f['title_a'] ?? '') . ' ' . ($f['title_em'] ?? ''));
                    ?>
                        <article class="inside-frame <?= $i === 0 ? 'is-active' : '' ?>"
                                 data-inside-frame="<?= $i ?>"
                                 style="--crop-pos: <?= $cropPos ?>; --crop-scale: <?= $cropScale ?>">
                            <div class="inside-photo">
                                <img src="<?= htmlspecialchars($imgPath) ?>?v=<?= asset_v($imgPath) ?>"
                                     alt="<?= htmlspecialchars($imgAlt) ?>"
                                     loading="<?= $i === 0 ? 'eager' : 'lazy' ?>"
                                     decoding="async"
                                     width="1400" height="1750">
                                <div class="inside-photo-grade" aria-hidden="true"></div>
                                <div class="inside-photo-glow" aria-hidden="true"></div>
                            </div>

                            <div class="inside-overlay">
                                <span class="inside-tag"><span class="inside-tag-dot"></span><?= htmlspecialchars($f['tag']) ?></span>

                                <div class="inside-stat">
                                    <span class="inside-stat-v"><?= htmlspecialchars($f['stat_v']) ?></span>
                                    <span class="inside-stat-u"><?= htmlspecialchars($f['stat_u']) ?></span>
                                </div>

                                <h3 class="inside-frame-title">
                                    <?= htmlspecialchars($f['title_a']) ?> <em><?= htmlspecialchars($f['title_em']) ?></em>
                                </h3>

                                <p class="inside-body"><?= htmlspecialchars($f['body']) ?></p>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <aside class="inside-rail">
                    <div class="inside-rail-progress" data-inside-progress aria-hidden="true">
                        <span class="inside-rail-progress-fill"></span>
                    </div>
                    <ul class="inside-rail-tabs">
                        <?php foreach ($T['inside']['frames'] as $i => $f): ?>
                            <li>
                                <button type="button" class="inside-rail-tab <?= $i === 0 ? 'is-active' : '' ?>" data-inside-tab="<?= $i ?>" aria-label="<?= htmlspecialchars($f['title_a']) ?>">
                                    <span class="inside-rail-tab-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="inside-rail-cta" data-open-popup>
                        <span><?= $T['inside']['cta'] ?></span>
                        <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 12, 'stroke' => 1.8]) ?></span>
                    </button>
                </aside>
            </div>
        </div>

        <div class="inside-markers" aria-hidden="true">
            <?php foreach ($T['inside']['frames'] as $i => $f): ?>
                <span class="inside-marker" data-inside-marker="<?= $i ?>"></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ============================================================
     LEGACY · TECH SHOWCASE (kept hidden — markup retained)
     ============================================================ -->
<section class="panel panel--tech" data-panel hidden style="display:none">
    <div class="panel-content">
        <div class="panel-bg-glow panel-bg-glow--tl" aria-hidden="true"></div>

        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['tech']['eyebrow'] ?></span>
            <h2 class="section-title" data-split-lines>
                <?= $T['tech']['title_a'] ?> <em><?= $T['tech']['title_em'] ?></em>
            </h2>
            <p class="section-sub" data-anim="fade-up"><?= $T['tech']['sub'] ?></p>
        </header>

        <div class="tech-showcase" data-tech-showcase>
            <ul class="tech-tabs" role="tablist">
                <?php foreach ($T['tech']['items'] as $i => $item): ?>
                    <li class="tech-tab <?= $i === 0 ? 'is-active' : '' ?>" data-tech-tab="<?= $i ?>" role="tab" aria-selected="<?= $i === 0 ? 'true' : 'false' ?>" tabindex="<?= $i === 0 ? '0' : '-1' ?>">
                        <span class="tech-tab-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                        <span class="tech-tab-icon"><?= icon($item['icon'], ['size' => 18, 'stroke' => 1.5]) ?></span>
                        <span class="tech-tab-body">
                            <span class="tech-tab-tag"><?= htmlspecialchars($item['tag']) ?></span>
                            <span class="tech-tab-title"><?= htmlspecialchars($item['title']) ?></span>
                        </span>
                        <span class="tech-tab-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
                        <span class="tech-tab-progress" aria-hidden="true"></span>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="tech-stage">
                <div class="tech-stage-images">
                    <?php
                    // We have 2 real product photos. Map them creatively per tab so each frame feels distinct.
                    $imgMap = [
                        $smartImg, // FAC — Smart AI close-up
                        $smartImg, // Wavelengths — same hero angle
                        $smartImg, // AI — Smart AI screen emphasis
                        $basicImg, // Turnkey — Basic for variety
                    ];
                    $treatments = ['t-clean', 't-warm', 't-spotlight', 't-clean'];
                    foreach ($T['tech']['items'] as $i => $item):
                        $img = $imgMap[$i] ?? $smartImg;
                    ?>
                        <div class="tech-image <?= $i === 0 ? 'is-active' : '' ?> <?= $treatments[$i] ?>" data-tech-image="<?= $i ?>">
                            <div class="tech-image-bg" aria-hidden="true"></div>
                            <div class="tech-image-glow" aria-hidden="true"></div>
                            <img src="<?= $img ?>?v=<?= asset_v($img) ?>" alt="<?= htmlspecialchars($item['title']) ?>" loading="lazy">
                            <div class="tech-image-floor" aria-hidden="true"></div>
                            <div class="tech-image-meta" aria-hidden="true">
                                <span class="tech-image-meta-label"><?= htmlspecialchars($item['tag']) ?></span>
                                <span class="tech-image-meta-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?> / <?= str_pad((string)count($T['tech']['items']), 2, '0', STR_PAD_LEFT) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="tech-stage-cards">
                    <?php foreach ($T['tech']['items'] as $i => $item): ?>
                        <article class="tech-card <?= $i === 0 ? 'is-active' : '' ?>" data-tech-card="<?= $i ?>" role="tabpanel" aria-hidden="<?= $i === 0 ? 'false' : 'true' ?>">
                            <header class="tech-card-head">
                                <span class="tech-card-tag"><?= htmlspecialchars($item['tag']) ?></span>
                                <h3 class="tech-card-title"><?= htmlspecialchars($item['title']) ?></h3>
                                <p class="tech-card-subtitle"><?= htmlspecialchars($item['subtitle']) ?></p>
                            </header>
                            <p class="tech-card-body"><?= htmlspecialchars($item['body']) ?></p>
                            <dl class="tech-card-specs">
                                <?php foreach ($item['specs'] as [$k, $v]): ?>
                                    <div class="tech-spec">
                                        <dt><?= htmlspecialchars($k) ?></dt>
                                        <dd><?= htmlspecialchars($v) ?></dd>
                                    </div>
                                <?php endforeach; ?>
                            </dl>
                            <button type="button" class="tech-card-cta" data-open-popup>
                                <span><?= $T['tech']['cta'] ?></span>
                                <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 13, 'stroke' => 1.6]) ?></span>
                            </button>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · PRODUCTS
     ============================================================ -->
<section class="panel panel--products" id="products" data-panel>
    <div class="panel-content">
        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['products']['eyebrow'] ?></span>
            <h2 class="section-title" data-split-lines>
                <?= $T['products']['title_a'] ?> <em><?= $T['products']['title_em'] ?></em>
            </h2>
            <p class="section-sub" data-anim="fade-up"><?= $T['products']['sub'] ?></p>
            <div class="wave-strip" data-anim="fade-up">
                <?= icon('wave', ['size' => 14, 'stroke' => 1.6]) ?>
                <?= $T['products']['wave'] ?>
            </div>
        </header>

        <div class="products-grid">
            <!-- Smart AI -->
            <article class="product-card product-card--featured" data-product>
                <div class="product-card-glow" aria-hidden="true"></div>
                <div class="product-tag"><span class="product-tag-dot"></span><?= $T['products']['smart']['tag'] ?></div>

                <div class="product-image">
                    <div class="product-image-glow" aria-hidden="true"></div>
                    <div class="product-image-floor" aria-hidden="true"></div>
                    <img src="<?= $smartImg ?>?v=<?= asset_v($smartImg) ?>" alt="<?= htmlspecialchars($T['products']['smart']['name']) ?>" loading="lazy">
                </div>

                <div class="product-body">
                    <div class="product-head">
                        <h3 class="product-name"><?= $T['products']['smart']['name'] ?></h3>
                        <span class="product-price"><?= $T['products']['smart']['price'] ?></span>
                    </div>
                    <p class="product-desc"><?= $T['products']['smart']['desc'] ?></p>

                    <ul class="product-feats">
                        <?php foreach ($T['products']['smart']['feats'] as $f): ?>
                            <li><span class="feat-icon"><?= icon('check', ['size' => 12, 'stroke' => 2]) ?></span><?= $f ?></li>
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
                        <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
                    </button>
                </div>
            </article>

            <!-- Basic -->
            <article class="product-card" data-product>
                <div class="product-tag product-tag--muted"><span class="product-tag-dot"></span><?= $T['products']['basic']['tag'] ?></div>

                <div class="product-image">
                    <div class="product-image-glow product-image-glow--soft" aria-hidden="true"></div>
                    <div class="product-image-floor" aria-hidden="true"></div>
                    <img src="<?= $basicImg ?>?v=<?= asset_v($basicImg) ?>" alt="<?= htmlspecialchars($T['products']['basic']['name']) ?>" loading="lazy">
                </div>

                <div class="product-body">
                    <div class="product-head">
                        <h3 class="product-name"><?= $T['products']['basic']['name'] ?></h3>
                        <span class="product-price"><?= $T['products']['basic']['price'] ?></span>
                    </div>
                    <p class="product-desc"><?= $T['products']['basic']['desc'] ?></p>

                    <ul class="product-feats">
                        <?php foreach ($T['products']['basic']['feats'] as $f): ?>
                            <li><span class="feat-icon"><?= icon('check', ['size' => 12, 'stroke' => 2]) ?></span><?= $f ?></li>
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
            <span class="finance-mark"><?= icon('euro', ['size' => 14, 'stroke' => 1.6]) ?></span>
            <?= $T['products']['finance'] ?>
        </p>
    </div>
</section>


<!-- ============================================================
     PANEL · SALONS
     ============================================================ -->
<section class="panel panel--salons" data-panel>
    <div class="panel-content">
        <div class="panel-bg-glow panel-bg-glow--br" aria-hidden="true"></div>

        <header class="section-head section-head--centered">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['salons']['eyebrow'] ?></span>
            <h2 class="section-title section-title--lg" data-split-lines>
                <?= $T['salons']['title_a'] ?> <em><?= $T['salons']['title_em'] ?></em>
            </h2>
        </header>

        <div class="salons-stage" data-salons>
            <div class="salons-quote" data-salons-words>
                <?php
                $quoteText = $T['salons']['p1'];
                $words = preg_split('/\s+/u', strip_tags($quoteText));
                foreach ($words as $w):
                    if ($w === '') continue;
                ?>
                    <span class="sw-word"><?= htmlspecialchars($w) ?></span>
                <?php endforeach; ?>
            </div>

            <ul class="salons-stats">
                <li data-stat-item><span class="ss-v" data-counter data-from="0" data-to="2" data-suffix="+">0</span><span class="ss-u">років у нашому салоні</span></li>
                <li data-stat-item><span class="ss-v">I–IV</span><span class="ss-u">фототипи шкіри</span></li>
                <li data-stat-item><span class="ss-v"><span data-counter data-from="0" data-to="5">0</span>–<span data-counter data-from="0" data-to="10">0</span></span><span class="ss-u">днів доставки</span></li>
                <li data-stat-item><span class="ss-v">24/7</span><span class="ss-u">лінія підтримки</span></li>
            </ul>

            <p class="salons-tail" data-anim="fade-up"><?= $T['salons']['p2'] ?></p>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · INCOME (BIG NUMBER)
     ============================================================ -->
<section class="panel panel--income" id="income" data-panel>
    <div class="panel-content">
        <div class="income-bg-glow" aria-hidden="true"></div>

        <header class="section-head section-head--centered">
            <span class="eyebrow eyebrow--inverse"><span class="eyebrow-dot"></span><?= $T['income']['eyebrow'] ?></span>
            <h2 class="section-title section-title--lg section-title--inverse" data-split-lines>
                <?= $T['income']['title_a'] ?> <em><?= $T['income']['title_em'] ?></em>
            </h2>
            <p class="section-sub section-sub--inverse" data-anim="fade-up"><?= $T['income']['sub'] ?></p>
        </header>

        <div class="big-number" data-big-number>
            <span class="big-number-pre" data-anim="fade-up"><?= $T['income']['big_pre'] ?></span>
            <span class="big-number-v">
                <span class="bn-mask"><span class="bn-text"><?= $T['income']['big_v'] ?></span></span>
            </span>
            <span class="big-number-u" data-anim="fade-up"><?= $T['income']['big_u'] ?></span>
        </div>

        <ul class="income-rows">
            <?php
            $iconRows = ['gauge', 'euro', 'calendar', 'flame'];
            foreach ($T['income']['rows'] as $i => [$label, $value, $unit]): ?>
                <li class="income-row" data-income-row>
                    <span class="income-row-icon"><?= icon($iconRows[$i] ?? 'check', ['size' => 16, 'stroke' => 1.4]) ?></span>
                    <span class="income-row-label"><?= $label ?></span>
                    <span class="income-row-value"><?= $value ?> <span class="income-row-unit"><?= $unit ?></span></span>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="income-cta" data-anim="fade-up">
            <p class="income-note"><?= icon('check', ['size' => 14, 'stroke' => 2]) ?> <?= $T['income']['note'] ?></p>
            <button type="button" class="btn btn--red btn--lg" data-open-popup data-magnet>
                <span><?= $T['income']['cta'] ?></span>
                <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
            </button>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · CALCULATOR
     ============================================================ -->
<section class="panel panel--calc" id="calculator" data-panel>
    <div class="panel-content">
        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['calc']['eyebrow'] ?></span>
            <h2 class="section-title" data-split-lines>
                <?= $T['calc']['title_a'] ?> <em><?= $T['calc']['title_em'] ?></em>
            </h2>
            <p class="section-sub" data-anim="fade-up"><?= $T['calc']['sub'] ?></p>
        </header>

        <div class="calc-card" data-anim="fade-up">
            <div class="calc-grain" aria-hidden="true"></div>
            <div class="calc-bg-glow" aria-hidden="true"></div>

            <div class="calc-controls">
                <div class="calc-field">
                    <div class="calc-field-head">
                        <span class="calc-label"><?= icon('gauge', ['size' => 14, 'stroke' => 1.5]) ?> <?= $T['calc']['f_proc'] ?></span>
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
                        <span class="calc-label"><?= icon('euro', ['size' => 14, 'stroke' => 1.5]) ?> <?= $T['calc']['f_avg'] ?></span>
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
                        <span class="calc-label"><?= icon('calendar', ['size' => 14, 'stroke' => 1.5]) ?> <?= $T['calc']['f_lease'] ?></span>
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
                    <span class="calc-result-label"><?= icon('flame', ['size' => 13, 'stroke' => 1.6]) ?> <?= $T['calc']['r_net'] ?></span>
                    <span class="calc-result-value calc-result-value--xl" data-out="net">15 250</span>
                    <span class="calc-result-unit"><?= $T['calc']['r_unit'] ?></span>
                    <div class="calc-result-glow" aria-hidden="true"></div>
                </div>

                <button type="button" class="btn btn--primary btn--full btn--lg" data-open-popup data-magnet>
                    <span><?= $T['calc']['cta'] ?></span>
                    <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
                </button>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · CONSULT (FORM)
     ============================================================ -->
<section class="panel panel--consult" id="consult" data-panel>
    <div class="panel-content">
        <div class="consult-grid">
            <header class="consult-head">
                <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['form']['eyebrow'] ?></span>
                <h2 class="section-title section-title--lg" data-split-lines>
                    <?= $T['form']['title_a'] ?> <em><?= $T['form']['title_em'] ?></em>
                </h2>
                <p class="section-sub" data-anim="fade-up"><?= $T['form']['sub'] ?></p>

                <ul class="consult-bullets" data-anim="fade-up">
                    <li><?= icon('phone', ['size' => 16, 'stroke' => 1.4]) ?><span>Менеджер зв’яжеться впродовж години</span></li>
                    <li><?= icon('crosshair', ['size' => 16, 'stroke' => 1.4]) ?><span>Підбір моделі під формат бізнесу</span></li>
                    <li><?= icon('chart', ['size' => 16, 'stroke' => 1.4]) ?><span>Прорахунок окупності для вашого випадку</span></li>
                </ul>
            </header>

            <div class="consult-form" data-anim="fade-up">
                <?php include __DIR__ . '/partials/form.php'; ?>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · ADVANTAGES
     ============================================================ -->
<section class="panel panel--advantages" id="advantages" data-panel>
    <div class="panel-content">
        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['advantages']['eyebrow'] ?></span>
            <h2 class="section-title" data-split-lines>
                <?= $T['advantages']['title_a'] ?> <em><?= $T['advantages']['title_em'] ?></em> <?= $T['advantages']['title_b'] ?>
            </h2>
            <p class="section-sub" data-anim="fade-up"><?= $T['advantages']['sub'] ?></p>
        </header>

        <ul class="advantage-grid">
            <?php foreach ($T['advantages']['items'] as $i => [$ic, $title, $body]): ?>
                <li class="adv-card" data-adv-card>
                    <span class="adv-icon"><?= icon($ic, ['size' => 22, 'stroke' => 1.4]) ?></span>
                    <span class="adv-num"><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                    <h3 class="adv-title"><?= $title ?></h3>
                    <p class="adv-body"><?= $body ?></p>
                    <div class="adv-line" aria-hidden="true"></div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>


<!-- ============================================================
     PANEL · TESTIMONIALS
     ============================================================ -->
<section class="panel panel--testimonials" data-panel>
    <div class="panel-content">
        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['testimonials']['eyebrow'] ?></span>
            <h2 class="section-title" data-split-lines>
                <?= $T['testimonials']['title_a'] ?> <em><?= $T['testimonials']['title_em'] ?></em>
            </h2>
        </header>

        <div class="testimonial-rail" data-rail>
            <div class="testimonial-track" data-rail-track>
                <?php
                $avatarTones = ['rose', 'stone', 'olive', 'taupe'];
                foreach ($T['testimonials']['list'] as $i => $t):
                    $initials = '';
                    foreach (preg_split('/\s+/u', trim($t['name'])) as $part) {
                        if ($part !== '') $initials .= mb_substr($part, 0, 1, 'UTF-8');
                    }
                    $initials = mb_strtoupper(mb_substr($initials, 0, 2, 'UTF-8'), 'UTF-8');
                    $tone = $avatarTones[$i % count($avatarTones)];
                ?>
                    <article class="testimonial">
                        <div class="t-head">
                            <div class="t-avatar t-avatar--<?= $tone ?>" aria-hidden="true"><?= $initials ?></div>
                            <div class="t-meta-top">
                                <strong class="t-name"><?= $t['name'] ?></strong>
                                <span class="t-role"><?= $t['role'] ?></span>
                            </div>
                            <span class="t-stars" aria-label="5 stars">
                                <?= str_repeat(icon('star', ['size' => 13, 'stroke' => 1.2, 'class' => 'star-filled']), 5) ?>
                            </span>
                        </div>
                        <p class="t-text">“<?= $t['text'] ?>”</p>
                        <footer class="t-foot">
                            <?= icon('pin', ['size' => 13, 'stroke' => 1.5]) ?>
                            <span class="t-city"><?= $t['city'] ?></span>
                        </footer>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="rail-controls">
                <button type="button" class="rail-btn" data-rail-prev aria-label="Previous">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                </button>
                <button type="button" class="rail-btn" data-rail-next aria-label="Next">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
                </button>
            </div>
        </div>
    </div>
</section>


<!-- ============================================================
     PANEL · FAQ
     ============================================================ -->
<section class="panel panel--faq" id="faq" data-panel>
    <div class="panel-content">
        <header class="section-head">
            <span class="eyebrow"><span class="eyebrow-dot"></span><?= $T['faq']['eyebrow'] ?></span>
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
    </div>
</section>

</div><!-- /.slides-wrapper -->


<!-- ============================================================
     FINAL CTA — outside pin-stack
     ============================================================ -->
<section class="final" data-final>
    <div class="final-glow" aria-hidden="true"></div>
    <div class="final-glow final-glow--2" aria-hidden="true"></div>

    <div class="final-inner">
        <span class="eyebrow eyebrow--inverse" data-anim="fade-up"><span class="eyebrow-dot"></span>Axiom Technology</span>
        <h2 class="final-title" data-split-lines>
            <?= $T['final']['title_a'] ?> <em><?= $T['final']['title_em'] ?></em><?= $T['final']['title_b'] ?>
        </h2>
        <p class="final-sub" data-anim="fade-up"><?= $T['final']['sub'] ?></p>
        <button type="button" class="btn btn--red btn--xl" data-open-popup data-magnet>
            <span><?= $T['final']['cta'] ?></span>
            <span class="btn-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
        </button>

        <div class="final-trust" data-anim="fade-up">
            <span><?= icon('shield', ['size' => 14, 'stroke' => 1.5]) ?> 2 роки гарантії</span>
            <span class="final-trust-sep"></span>
            <span><?= icon('truck', ['size' => 14, 'stroke' => 1.5]) ?> Доставка по Європі</span>
            <span class="final-trust-sep"></span>
            <span><?= icon('cap', ['size' => 14, 'stroke' => 1.5]) ?> Навчання експерта</span>
        </div>
    </div>
</section>

</main>

<?php include __DIR__ . '/partials/footer.php'; ?>

<!-- Sticky mobile CTA -->
<button type="button" class="sticky-mobile-cta" data-open-popup>
    <span><?= $T['sticky_mobile_cta'] ?></span>
    <span class="smc-arrow" aria-hidden="true"><?= icon('arrowRight', ['size' => 14, 'stroke' => 1.6]) ?></span>
</button>

<!-- Scroll-to-top -->
<button type="button" class="scroll-top" data-scroll-top aria-label="Top">
    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
        <path d="M12 19V5M5 12l7-7 7 7" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</button>

<!-- Floating desktop widget -->
<a href="#calculator" class="floating-widget" data-floating>
    <span class="fw-icon" aria-hidden="true"><?= icon('chart', ['size' => 14, 'stroke' => 1.5]) ?></span>
    <span><?= $T['floating_widget'] ?></span>
</a>

<?php include __DIR__ . '/partials/popup.php'; ?>

<!-- GSAP -->
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
<script src="assets/js/main.js?v=<?= asset_v('assets/js/main.js') ?>" defer></script>

</body>
</html>
