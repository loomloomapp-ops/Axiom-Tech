# Axiom Technology — Landing

Преміум B2B-лендинг для дистриб'ютора діодних лазерів для епіляції.
Стек: PHP 7.4+ / нативний HTML/CSS/JS, GSAP + ScrollTrigger.
Розгортання: Hostinger (shared) або будь-який LAMP/LEMP.

## Стек

- `index.php` — single-page, мова через `?lang=uk|pl` (cookie запам'ятовує)
- `lang/uk.php`, `lang/pl.php` — переклади (з editorial-italic акцентами через `<em>`)
- `partials/` — header, footer, popup, форма
- `api/lead.php` — POST: валідація → Telegram Bot API + email через `mail()`
- `assets/css/main.css` — рукописний CSS, без фреймворків
- `assets/js/main.js` — GSAP-хореографія, калькулятор, форма, popup
- `.htaccess` — HTTPS, кеш, gzip, заборона прямого доступу до partials/lang/config

Усі шрифти підвантажуються з Google Fonts: **Geist**, **Geist Mono**, **Fraunces**.
GSAP — з jsdelivr CDN.

## Деплой на Hostinger

1. Скопіюйте всі файли проєкту в `public_html/` (або subdomain folder).
   Виключіть з аплоаду: `.git/`, `.claude/`, `assets/Копия Лендинг ...pdf`,
   `assets/logo axiomtech/`, `assets/товари /` (це джерела, не runtime).
2. Створіть `config.php` з `config.example.php` і заповніть:
   - `telegram.token` — токен від @BotFather
   - `telegram.chat_ids` — масив ID чатів
   - `email.to` / `email.from` — адреси (важливо: `from` має бути на вашому домені)
3. Перевірте, що `mod_rewrite`, `mod_headers`, `mod_expires`, `mod_deflate`
   увімкнені (Hostinger робить це за замовчуванням).
4. Створіть піддиректорію `leads/` та зробіть її писемною (`chmod 755`),
   якщо хочете лог-fallback.
5. Перевірте форму: дані мають прийти і в Telegram, і в email.

### Як отримати Telegram chat_id

1. Створіть бота: пишіть `@BotFather` → `/newbot` → отримуєте token
2. Напишіть боту будь-яке повідомлення (з вашого акаунта)
3. Відкрийте `https://api.telegram.org/bot<TOKEN>/getUpdates`
4. Знайдіть `"chat":{"id":...}` — це і є chat_id

## Брендові ресурси

Робочі копії, що використовуються сайтом:

```
assets/images/
├── logo/
│   ├── axiom-black.png      Світлі поверхні (header, favicon)
│   ├── axiom-white.png      Темні (footer)
│   ├── axiom-golden.png     Резерв
│   └── axiom-silver.png     Резерв
└── products/
    ├── axiom-smart-ai.jpg   Hero, products, calculator
    └── axiom-basic.png      Products
```

Імена файлів стабільні. Зміна — заміна файлу зі збереженням імені.
Cache-busting через `?v=<mtime>` додається автоматично.

Оригінали з кирилицею/пробілами в назвах (`assets/Копия Лендинг ...pdf`,
`assets/logo axiomtech/`, `assets/товари /`) — НЕ використовуються в runtime,
це тільки джерела.

## Локальна розробка

Будь-який PHP-сервер:

```bash
php -S 127.0.0.1:8080 -t .
```

Відкрийте http://127.0.0.1:8080/.
Перемикач мови: `?lang=pl` / `?lang=uk`.

## Структура секцій (CRO-логіка)

Кожна секція має чітку роль у воронці:

1. **Hero** — hook (продажі прибутку, не апарата)
2. **Trust strip** — швидке зняття страху (гарантія, доставка, лізинг)
3. **Products** — освіта (Smart AI vs Basic — для кого)
4. **Salons** — соціальний доказ (працює в реальних салонах)
5. **Income proof** — гігантська цифра доходу (емоційний пік)
6. **ROI Calculator** — інтерактивна персоналізація (юзер сам себе переконує)
7. **Consultation form #1** — конверсія №1 (на піку інтересу)
8. **Advantages** — зняття глибоких заперечень
9. **Testimonials** — соціальний доказ преміум-рівня
10. **FAQ** — фінальні заперечення
11. **Final CTA** — конверсія №2

Плюс: sticky header, sticky mobile CTA, floating desktop widget,
popup-форма викликається з 6+ точок на сторінці.

## Анімації (GSAP)

- Hero: char-cascade reveal заголовка (per-character stagger з blur+y+opacity)
- Hero: product-image parallax + radial-glow pulse
- Floating chips: perpetual sin-wave float + magnetic pull до cursor
- Section titles: line-mask wipe (`yPercent: 110 → 0`)
- Big number `9 000–14 000 €`: clip-mask reveal на scroll
- Income rows: stagger fade-up
- Products: clip-path + magnetic image parallax всередині картки
- Advantages: clip-path inset wipe
- Calculator: GSAP tween чисел при кожному `input` (не миттєвий джамп)
- FAQ: GSAP `height: auto` accordion
- Custom cursor: dot + delayed-spring ring (тільки desktop fine pointer)
- Magnetic buttons: `data-magnet` атрибут на CTA
- Header: glass blur + shrink на scroll

`prefers-reduced-motion` повністю шанується — всі анімації вимикаються.

## Безпека форми

- Honeypot field `company_url`
- Min form-fill time check (`ts` hidden input)
- `strip_tags` + `preg_replace` на всіх вводах
- Email subject через `=?UTF-8?B?...?=` для нелатинських символів
- Telegram через cURL з SSL verify, fallback на `file_get_contents`
- HTTPS форсується через `.htaccess`
- `.htaccess` блокує прямий доступ до `config.php`, `lang/`, `partials/`, `leads/`

## Ліцензія

Proprietary. Усі права належать Axiom Technology.
