<?php /** @var array $T */ ?>
<div class="popup" data-popup aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="popup-title">
    <div class="popup-backdrop" data-popup-close></div>

    <div class="popup-card" role="document">
        <button type="button" class="popup-close" data-popup-close aria-label="<?= htmlspecialchars($T['popup']['close']) ?>">
            <svg viewBox="0 0 16 16" width="16" height="16"><path d="M4 4l8 8M12 4l-8 8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
        </button>

        <div class="popup-grain" aria-hidden="true"></div>

        <header class="popup-head">
            <span class="eyebrow">Axiom Technology</span>
            <h2 id="popup-title" class="popup-title">
                <?= $T['popup']['title_a'] ?> <em><?= $T['popup']['title_em'] ?></em>
            </h2>
            <p class="popup-sub"><?= $T['popup']['sub'] ?></p>
        </header>

        <?php include __DIR__ . '/form.php'; ?>
    </div>
</div>
