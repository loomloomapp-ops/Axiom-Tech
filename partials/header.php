<?php
/** @var array $T */
$fp        = $T['footer'];
$phoneTel  = preg_replace('/[^+\d]/', '', $fp['phone_v'] ?? '');
$mapsUrl   = 'https://maps.google.com/?q=' . rawurlencode($fp['addr_v'] ?? '');
?>
<header class="site-header" data-header>
    <div class="header-util">
        <div class="header-util-inner">
            <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener noreferrer" class="hu-item hu-addr">
                <span class="hu-ico"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6-5.3-6-10a6 6 0 0112 0c0 4.7-6 10-6 10z"/><circle cx="12" cy="11" r="2.2"/></svg></span>
                <span><?= htmlspecialchars($fp['addr_v']) ?></span>
            </a>
            <div class="hu-group">
                <a href="tel:<?= $phoneTel ?>" class="hu-item">
                    <span class="hu-ico"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h3l1.5 4-2 1a11 11 0 005.5 5.5l1-2 4 1.5v3a2 2 0 01-2 2A14 14 0 013 6a2 2 0 012-2z"/></svg></span>
                    <span><?= htmlspecialchars($fp['phone_v']) ?></span>
                </a>
                <a href="mailto:<?= htmlspecialchars($fp['email_v']) ?>" class="hu-item">
                    <span class="hu-ico"><svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 7l8.5 6 8.5-6"/></svg></span>
                    <span><?= htmlspecialchars($fp['email_v']) ?></span>
                </a>
                <a href="<?= htmlspecialchars($fp['ig_url'] ?? 'https://www.instagram.com/axiom_technology_') ?>" target="_blank" rel="noopener noreferrer" class="hu-item hu-item--ig" aria-label="Instagram">
                    <span class="hu-ico"><svg viewBox="0 0 20 20" width="13" height="13" aria-hidden="true"><rect x="2" y="2" width="16" height="16" rx="4.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="14.5" cy="5.5" r="0.9" fill="currentColor"/></svg></span>
                    <span><?= htmlspecialchars($fp['ig_label'] ?? 'Instagram') ?></span>
                </a>
            </div>
        </div>
    </div>

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

            <div class="nm-contacts">
                <a href="tel:<?= $phoneTel ?>" class="nm-contact">
                    <span class="nm-contact-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 4h3l1.5 4-2 1a11 11 0 005.5 5.5l1-2 4 1.5v3a2 2 0 01-2 2A14 14 0 013 6a2 2 0 012-2z"/></svg></span>
                    <span class="nm-contact-text">
                        <span class="nm-contact-label"><?= htmlspecialchars($fp['phone_l']) ?></span>
                        <span class="nm-contact-value"><?= htmlspecialchars($fp['phone_v']) ?></span>
                    </span>
                </a>
                <a href="mailto:<?= htmlspecialchars($fp['email_v']) ?>" class="nm-contact">
                    <span class="nm-contact-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 7l8.5 6 8.5-6"/></svg></span>
                    <span class="nm-contact-text">
                        <span class="nm-contact-label"><?= htmlspecialchars($fp['email_l']) ?></span>
                        <span class="nm-contact-value"><?= htmlspecialchars($fp['email_v']) ?></span>
                    </span>
                </a>
                <a href="<?= htmlspecialchars($mapsUrl) ?>" target="_blank" rel="noopener noreferrer" class="nm-contact">
                    <span class="nm-contact-ico"><svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s-6-5.3-6-10a6 6 0 0112 0c0 4.7-6 10-6 10z"/><circle cx="12" cy="11" r="2.2"/></svg></span>
                    <span class="nm-contact-text">
                        <span class="nm-contact-label"><?= htmlspecialchars($fp['addr_l']) ?></span>
                        <span class="nm-contact-value"><?= htmlspecialchars($fp['addr_v']) ?></span>
                    </span>
                </a>
                <a href="<?= htmlspecialchars($fp['ig_url'] ?? 'https://www.instagram.com/axiom_technology_') ?>" target="_blank" rel="noopener noreferrer" class="nm-contact">
                    <span class="nm-contact-ico"><svg viewBox="0 0 20 20" width="18" height="18" aria-hidden="true"><rect x="2" y="2" width="16" height="16" rx="4.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="10" cy="10" r="3.5" fill="none" stroke="currentColor" stroke-width="1.4"/><circle cx="14.5" cy="5.5" r="0.9" fill="currentColor"/></svg></span>
                    <span class="nm-contact-text">
                        <span class="nm-contact-label">Instagram</span>
                        <span class="nm-contact-value"><?= htmlspecialchars($fp['ig_label'] ?? 'Instagram') ?></span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</header>
