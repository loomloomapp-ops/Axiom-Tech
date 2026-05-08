<?php
/** @var array $T */
$footerLogoMtime = @filemtime(__DIR__ . '/../assets/images/logo/axiom-white.png');
?>
<footer class="site-footer" id="contacts">
    <div class="footer-grain" aria-hidden="true"></div>

    <div class="footer-marquee" aria-hidden="true">
        <div class="fm-track">
            <?php for ($r = 0; $r < 4; $r++): ?>
                <span class="fm-text">Axiom</span>
                <span class="fm-logo"><img src="assets/images/logo/axiom-white.png?v=<?= $footerLogoMtime ?>" alt=""></span>
                <span class="fm-text fm-text--italic"><em>Technology</em></span>
                <span class="fm-dot" aria-hidden="true"></span>
            <?php endfor; ?>
        </div>
    </div>

    <div class="footer-inner">
        <div class="footer-brand">
            <img src="assets/images/logo/axiom-white.png?v=<?= @filemtime(__DIR__ . '/../assets/images/logo/axiom-white.png') ?>" alt="Axiom Technology" class="footer-logo">
            <p class="footer-about"><?= $T['footer']['about'] ?></p>
        </div>

        <div class="footer-col">
            <span class="footer-title"><?= $T['footer']['nav_t'] ?></span>
            <a href="#products"   class="footer-link"><?= $T['nav']['products']   ?></a>
            <a href="#income"     class="footer-link"><?= $T['nav']['income']     ?></a>
            <a href="#calculator" class="footer-link"><?= $T['nav']['calculator'] ?></a>
            <a href="#advantages" class="footer-link"><?= $T['nav']['advantages'] ?></a>
            <a href="#faq"        class="footer-link"><?= $T['nav']['faq']        ?></a>
        </div>

        <div class="footer-col">
            <span class="footer-title"><?= $T['footer']['cont_t'] ?></span>
            <div class="footer-line">
                <span class="footer-label"><?= $T['footer']['addr_l'] ?></span>
                <span class="footer-value"><?= $T['footer']['addr_v'] ?></span>
            </div>
            <div class="footer-line">
                <span class="footer-label"><?= $T['footer']['phone_l'] ?></span>
                <a href="tel:<?= preg_replace('/[^+\d]/', '', $T['footer']['phone_v']) ?>" class="footer-value footer-value--link"><?= $T['footer']['phone_v'] ?></a>
            </div>
            <div class="footer-line">
                <span class="footer-label"><?= $T['footer']['email_l'] ?></span>
                <a href="mailto:<?= htmlspecialchars($T['footer']['email_v']) ?>" class="footer-value footer-value--link"><?= $T['footer']['email_v'] ?></a>
            </div>
            <a href="<?= htmlspecialchars($T['footer']['ig_url'] ?? 'https://www.instagram.com/axiom_technology_') ?>" target="_blank" rel="noopener noreferrer" class="footer-social">
                <svg viewBox="0 0 20 20" width="16" height="16" aria-hidden="true">
                    <rect x="2" y="2" width="16" height="16" rx="4.5" fill="none" stroke="currentColor" stroke-width="1.4"/>
                    <circle cx="10" cy="10" r="3.5" fill="none" stroke="currentColor" stroke-width="1.4"/>
                    <circle cx="14.5" cy="5.5" r="0.9" fill="currentColor"/>
                </svg>
                <span><?= htmlspecialchars($T['footer']['ig_label'] ?? 'Instagram') ?></span>
            </a>
        </div>

        <div class="footer-col">
            <span class="footer-title"><?= $T['footer']['lang_t'] ?></span>
            <a href="?lang=uk" class="footer-link <?= $T['html_lang'] === 'uk' ? 'is-active' : '' ?>">Українська</a>
            <a href="?lang=pl" class="footer-link <?= $T['html_lang'] === 'pl' ? 'is-active' : '' ?>">Polski</a>
        </div>
    </div>

    <div class="footer-meta">
        <span><?= $T['footer']['rights'] ?></span>
        <a href="#" class="footer-link footer-link--muted"><?= $T['footer']['policy'] ?></a>
    </div>
</footer>
