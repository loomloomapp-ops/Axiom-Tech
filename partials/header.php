<?php /** @var array $T */ ?>
<header class="site-header" data-header>
    <div class="header-inner">
        <a href="?lang=<?= htmlspecialchars($T['html_lang']) ?>#top" class="brand" aria-label="Axiom Technology">
            <img src="assets/images/logo/axiom-black.png?v=<?= @filemtime(__DIR__ . '/../assets/images/logo/axiom-black.png') ?>" alt="Axiom Technology" class="brand-logo brand-logo--dark">
            <img src="assets/images/logo/axiom-white.png?v=<?= @filemtime(__DIR__ . '/../assets/images/logo/axiom-white.png') ?>" alt="" class="brand-logo brand-logo--light" aria-hidden="true">
        </a>

        <nav class="nav-main" aria-label="Primary">
            <a href="#products"   class="nav-link"><?= $T['nav']['products']   ?></a>
            <a href="#income"     class="nav-link"><?= $T['nav']['income']     ?></a>
            <a href="#calculator" class="nav-link"><?= $T['nav']['calculator'] ?></a>
            <a href="#advantages" class="nav-link"><?= $T['nav']['advantages'] ?></a>
            <a href="#faq"        class="nav-link"><?= $T['nav']['faq']        ?></a>
        </nav>

        <div class="header-actions">
            <a href="?lang=<?= htmlspecialchars($T['switch_to']) ?>" class="lang-switch" aria-label="Switch language">
                <span><?= htmlspecialchars($T['switch_label']) ?></span>
            </a>
            <a href="tel:<?= preg_replace('/[^+\d]/', '', $T['footer']['phone_v'] ?? '') ?>" class="header-call" aria-label="Call">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h3l1.5 4-2 1a11 11 0 005.5 5.5l1-2 4 1.5v3a2 2 0 01-2 2A14 14 0 013 6a2 2 0 012-2z"/></svg>
            </a>
            <button type="button" class="btn btn--primary btn--compact" data-open-popup>
                <span><?= $T['nav']['cta'] ?></span>
                <span class="btn-arrow" aria-hidden="true">
                    <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
            </button>
            <button type="button" class="nav-toggle" data-nav-toggle aria-expanded="false" aria-label="Меню">
                <span></span><span></span>
            </button>
        </div>
    </div>

    <div class="nav-mobile" data-nav-mobile aria-hidden="true">
        <div class="nav-mobile-inner">
            <a href="#products"   class="nav-mobile-link"><span class="nm-num">01</span><?= $T['nav']['products']   ?></a>
            <a href="#income"     class="nav-mobile-link"><span class="nm-num">02</span><?= $T['nav']['income']     ?></a>
            <a href="#calculator" class="nav-mobile-link"><span class="nm-num">03</span><?= $T['nav']['calculator'] ?></a>
            <a href="#advantages" class="nav-mobile-link"><span class="nm-num">04</span><?= $T['nav']['advantages'] ?></a>
            <a href="#faq"        class="nav-mobile-link"><span class="nm-num">05</span><?= $T['nav']['faq']        ?></a>
            <button type="button" class="btn btn--primary btn--full" data-open-popup>
                <?= $T['nav']['cta'] ?>
            </button>
        </div>
    </div>
</header>
