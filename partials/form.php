<?php /** @var array $T */ ?>
<form class="lead-form" data-lead-form novalidate>
    <div class="form-row">
        <label class="field">
            <span class="field-label"><?= $T['form']['name'] ?></span>
            <input type="text" name="name" required autocomplete="name" class="field-input">
            <span class="field-line" aria-hidden="true"></span>
        </label>
    </div>

    <div class="form-row form-row--split">
        <label class="field">
            <span class="field-label"><?= $T['form']['phone'] ?></span>
            <input type="tel" name="phone" required autocomplete="tel" inputmode="tel" placeholder="+48 ___ ___ ___" class="field-input">
            <span class="field-line" aria-hidden="true"></span>
        </label>

        <label class="field">
            <span class="field-label"><?= $T['form']['messenger'] ?></span>
            <div class="select-wrap">
                <select name="messenger" class="field-input field-select">
                    <?php foreach ($T['form']['m_options'] as $opt): ?>
                        <option value="<?= htmlspecialchars($opt) ?>"><?= htmlspecialchars($opt) ?></option>
                    <?php endforeach; ?>
                </select>
                <svg class="select-caret" viewBox="0 0 12 8" width="12" height="8" aria-hidden="true"><path d="M1 1.5L6 6.5L11 1.5" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
            </div>
            <span class="field-line" aria-hidden="true"></span>
        </label>
    </div>

    <label class="checkbox">
        <input type="checkbox" name="policy" required>
        <span class="checkbox-box" aria-hidden="true">
            <svg viewBox="0 0 12 10" width="12" height="10"><path d="M1 5l3.5 3.5L11 1.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
        <span class="checkbox-label"><?= $T['form']['policy'] ?></span>
    </label>

    <input type="text" name="company_url" tabindex="-1" autocomplete="off" class="hp-field" aria-hidden="true">
    <input type="hidden" name="ts" value="<?= time() ?>">
    <input type="hidden" name="lang" value="<?= htmlspecialchars($T['html_lang']) ?>">

    <button type="submit" class="btn btn--primary btn--full btn--lg form-submit">
        <span class="form-submit-text"><?= $T['form']['submit'] ?></span>
        <span class="btn-arrow" aria-hidden="true">
            <svg viewBox="0 0 16 16" width="14" height="14"><path d="M3 8h10M9 4l4 4-4 4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </span>
    </button>

    <div class="form-success" data-form-success aria-hidden="true">
        <div class="form-success-mark" aria-hidden="true">
            <svg viewBox="0 0 36 36" width="36" height="36">
                <circle cx="18" cy="18" r="16" fill="none" stroke="currentColor" stroke-width="1.4" class="success-ring"/>
                <path d="M11 18.5L16 23.5L25 13" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" class="success-check"/>
            </svg>
        </div>
        <h3 class="form-success-title" data-form-success-title><?= $T['form']['success_t'] ?></h3>
        <p class="form-success-sub" data-form-success-sub><?= $T['form']['success_p'] ?></p>
    </div>

    <p class="form-error" data-form-error hidden><?= $T['form']['error'] ?></p>
</form>
