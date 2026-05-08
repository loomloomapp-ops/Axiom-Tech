/* ============================================================
   AXIOM TECHNOLOGY — main.js
   GSAP + ScrollTrigger choreography, calculator, form, popup.
   ============================================================ */

(function () {
    'use strict';

    const prefersReducedMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isFinePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    /* Wait for GSAP global */
    function ready(fn) {
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        const hasGSAP = typeof window.gsap !== 'undefined';
        if (hasGSAP) {
            gsap.registerPlugin(ScrollTrigger);
            gsap.config({ nullTargetWarn: false });
            gsap.defaults({ ease: 'power3.out' });
        }

        initHeader();
        initMobileNav();
        initSplitTextHero();
        initSplitTextLines();
        initFadeUps();
        initHeroVisual();
        initChips();
        initBigNumber();
        initIncomeRows();
        initProductCards();
        initAdvantages();
        initTestimonialRail();
        initFAQ();
        initCalculator();
        initPopup();
        initLeadForm();
        initStickyMobileCTA();
        initFloatingWidget();
        initMagneticButtons();
        initCustomCursor();
        initSmoothAnchors();
    });


    /* =========================================================
       HEADER — shrink + glass on scroll
       ========================================================= */
    function initHeader() {
        const header = document.querySelector('[data-header]');
        if (!header) return;
        let last = 0;
        const onScroll = () => {
            const y = window.scrollY;
            header.classList.toggle('is-scrolled', y > 30);
            last = y;
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }


    /* =========================================================
       MOBILE NAV
       ========================================================= */
    function initMobileNav() {
        const toggle = document.querySelector('[data-nav-toggle]');
        const panel  = document.querySelector('[data-nav-mobile]');
        if (!toggle || !panel) return;

        const close = () => {
            toggle.classList.remove('is-open');
            panel.classList.remove('is-open');
            panel.setAttribute('aria-hidden', 'true');
            toggle.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        };
        const open = () => {
            toggle.classList.add('is-open');
            panel.classList.add('is-open');
            panel.setAttribute('aria-hidden', 'false');
            toggle.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        };
        toggle.addEventListener('click', () => {
            toggle.classList.contains('is-open') ? close() : open();
        });
        panel.querySelectorAll('a').forEach(a => a.addEventListener('click', close));
    }


    /* =========================================================
       SPLIT TEXT — Hero (per-character cascade)
       ========================================================= */
    function initSplitTextHero() {
        if (!window.gsap || prefersReducedMotion) {
            document.querySelectorAll('[data-split]').forEach(el => el.style.opacity = 1);
            return;
        }
        const lines = document.querySelectorAll('.hero-title [data-split]');
        if (!lines.length) return;

        // Wrap every visible char in a span
        const tl = gsap.timeline({ delay: 0.12 });

        lines.forEach((line, i) => {
            const orig = line.innerHTML;
            const tmp = document.createElement('span');
            tmp.innerHTML = orig;

            // Walk text nodes, wrap chars; preserve <em> tags
            const wrap = (node) => {
                const out = [];
                node.childNodes.forEach(child => {
                    if (child.nodeType === Node.TEXT_NODE) {
                        const text = child.textContent;
                        for (const ch of text) {
                            const s = document.createElement('span');
                            s.className = 'split-char';
                            s.textContent = ch;
                            if (ch === ' ') s.style.width = '0.28em';
                            out.push(s);
                        }
                    } else if (child.nodeType === Node.ELEMENT_NODE) {
                        const inner = wrap(child);
                        const wrapper = document.createElement(child.tagName.toLowerCase());
                        wrapper.append(...inner);
                        out.push(wrapper);
                    }
                });
                return out;
            };
            line.innerHTML = '';
            line.append(...wrap(tmp));

            const chars = line.querySelectorAll('.split-char');
            tl.to(chars, {
                y: 0,
                opacity: 1,
                duration: 0.9,
                stagger: 0.018,
                ease: 'expo.out'
            }, i * 0.12);
        });
    }


    /* =========================================================
       SPLIT LINES — Section titles (line-mask reveal)
       ========================================================= */
    function initSplitTextLines() {
        if (!window.gsap || prefersReducedMotion) {
            document.querySelectorAll('[data-split-lines]').forEach(el => el.style.opacity = 1);
            return;
        }
        const titles = document.querySelectorAll('[data-split-lines]');
        titles.forEach(el => {
            // Wrap inner content (incl. <em>) into a single span we can mask
            const original = el.innerHTML;
            const inner = document.createElement('span');
            inner.className = 'split-line-inner';
            inner.innerHTML = original;
            const mask = document.createElement('span');
            mask.className = 'split-line';
            mask.appendChild(inner);
            el.innerHTML = '';
            el.appendChild(mask);

            gsap.fromTo(inner,
                { yPercent: 110 },
                {
                    yPercent: 0,
                    duration: 1.05,
                    ease: 'expo.out',
                    scrollTrigger: { trigger: el, start: 'top 86%', once: true }
                }
            );
        });
    }


    /* =========================================================
       FADE UPS (eyebrows, paragraphs, CTAs)
       ========================================================= */
    function initFadeUps() {
        if (!window.gsap || prefersReducedMotion) {
            document.querySelectorAll('[data-anim="fade-up"]').forEach(el => {
                el.style.opacity = 1; el.style.transform = 'none';
            });
            return;
        }
        ScrollTrigger.batch('[data-anim="fade-up"]', {
            start: 'top 88%',
            once: true,
            onEnter: batch => {
                gsap.to(batch, {
                    y: 0, opacity: 1,
                    duration: 0.9,
                    ease: 'expo.out',
                    stagger: 0.08
                });
            }
        });
    }


    /* =========================================================
       HERO VISUAL — entrance + parallax
       ========================================================= */
    function initHeroVisual() {
        const visual = document.querySelector('.hero-visual');
        if (!visual) return;

        if (window.gsap && !prefersReducedMotion) {
            gsap.to(visual, {
                opacity: 1, y: 0, scale: 1,
                duration: 1.4,
                ease: 'expo.out',
                delay: 0.25,
            });

            const product = visual.querySelector('.hero-product');
            if (product) {
                gsap.to(product, {
                    yPercent: -10,
                    ease: 'none',
                    scrollTrigger: {
                        trigger: '.hero',
                        start: 'top top',
                        end: 'bottom top',
                        scrub: 0.6
                    }
                });
            }
        } else {
            visual.style.opacity = 1; visual.style.transform = 'none';
        }
    }


    /* =========================================================
       CHIPS — perpetual float + magnetic pull on hover
       ========================================================= */
    function initChips() {
        const chips = document.querySelectorAll('[data-chip]');
        if (!chips.length || !window.gsap || prefersReducedMotion) {
            chips.forEach(c => { c.style.opacity = 1; c.style.transform = 'none'; });
            return;
        }
        chips.forEach((chip, i) => {
            gsap.set(chip, { opacity: 0, y: 30, scale: 0.9 });
            gsap.to(chip, {
                opacity: 1, y: 0, scale: 1,
                duration: 1.0,
                ease: 'expo.out',
                delay: 0.6 + i * 0.12
            });
            gsap.to(chip, {
                y: '+=10',
                duration: 3.2 + i * 0.4,
                ease: 'sine.inOut',
                yoyo: true, repeat: -1,
                delay: 1.6 + i * 0.3
            });
        });

        if (!isFinePointer) return;
        const visual = document.querySelector('.hero-visual');
        if (!visual) return;
        const rect = () => visual.getBoundingClientRect();
        const handlers = [];
        chips.forEach(chip => {
            let xT = gsap.quickTo(chip, 'x', { duration: 0.6, ease: 'power3.out' });
            let yT = gsap.quickTo(chip, 'y', { duration: 0.6, ease: 'power3.out' });
            handlers.push((ev) => {
                const r = rect();
                const cx = r.left + r.width / 2;
                const cy = r.top + r.height / 2;
                const dx = (ev.clientX - cx) * 0.05;
                const dy = (ev.clientY - cy) * 0.05;
                xT(dx);
                yT(dy);
            });
        });
        window.addEventListener('mousemove', (ev) => handlers.forEach(h => h(ev)), { passive: true });
    }


    /* =========================================================
       BIG NUMBER — mask reveal
       ========================================================= */
    function initBigNumber() {
        const bn = document.querySelector('[data-big-number]');
        if (!bn) return;
        const text = bn.querySelector('.bn-text');
        if (!text) return;

        if (!window.gsap || prefersReducedMotion) {
            text.style.transform = 'none'; return;
        }
        gsap.to(text, {
            yPercent: 0,
            duration: 1.4,
            ease: 'expo.out',
            scrollTrigger: { trigger: bn, start: 'top 78%', once: true }
        });
    }


    /* =========================================================
       INCOME ROWS — stagger reveal + odometer
       ========================================================= */
    function initIncomeRows() {
        const rows = document.querySelectorAll('[data-income-row]');
        if (!rows.length || !window.gsap || prefersReducedMotion) return;

        gsap.set(rows, { opacity: 0, y: 14 });
        ScrollTrigger.batch(rows, {
            start: 'top 88%',
            once: true,
            onEnter: batch => gsap.to(batch, {
                opacity: 1, y: 0,
                duration: 0.8,
                ease: 'expo.out',
                stagger: 0.08
            })
        });
    }


    /* =========================================================
       PRODUCT CARDS — entrance reveal + magnetic image
       ========================================================= */
    function initProductCards() {
        const cards = document.querySelectorAll('[data-product]');
        if (!cards.length) return;

        if (window.gsap && !prefersReducedMotion) {
            gsap.set(cards, { opacity: 0, y: 36 });
            ScrollTrigger.batch(cards, {
                start: 'top 86%',
                once: true,
                onEnter: batch => gsap.to(batch, {
                    opacity: 1, y: 0,
                    duration: 1.0,
                    ease: 'expo.out',
                    stagger: 0.12
                })
            });

            // Stagger feature lines per card on enter view
            cards.forEach(card => {
                const items = card.querySelectorAll('.product-feats li, .spec');
                gsap.set(items, { opacity: 0, y: 12 });
                gsap.to(items, {
                    opacity: 1, y: 0,
                    duration: 0.7,
                    stagger: 0.04,
                    ease: 'expo.out',
                    scrollTrigger: { trigger: card, start: 'top 78%', once: true }
                });
            });
        }

        // Subtle parallax on product image inside card
        if (isFinePointer && window.gsap) {
            cards.forEach(card => {
                const img = card.querySelector('.product-image img');
                if (!img) return;
                const xT = gsap.quickTo(img, 'x', { duration: 0.7, ease: 'power3.out' });
                const yT = gsap.quickTo(img, 'y', { duration: 0.7, ease: 'power3.out' });
                card.addEventListener('mousemove', (ev) => {
                    const r = card.getBoundingClientRect();
                    const dx = ((ev.clientX - r.left) / r.width - 0.5) * 16;
                    const dy = ((ev.clientY - r.top)  / r.height - 0.5) * 10;
                    xT(dx); yT(dy);
                });
                card.addEventListener('mouseleave', () => { xT(0); yT(0); });
            });
        }
    }


    /* =========================================================
       ADVANTAGES — clip-path wipe in
       ========================================================= */
    function initAdvantages() {
        const cards = document.querySelectorAll('[data-adv-card]');
        if (!cards.length || !window.gsap || prefersReducedMotion) return;

        gsap.set(cards, { opacity: 0, y: 24, clipPath: 'inset(0 0 100% 0)' });
        ScrollTrigger.batch(cards, {
            start: 'top 86%',
            once: true,
            onEnter: batch => gsap.to(batch, {
                opacity: 1, y: 0,
                clipPath: 'inset(0 0 0% 0)',
                duration: 1.1,
                ease: 'expo.out',
                stagger: 0.08
            })
        });
    }


    /* =========================================================
       TESTIMONIAL RAIL — drag + arrow buttons
       ========================================================= */
    function initTestimonialRail() {
        const rail = document.querySelector('[data-rail]');
        if (!rail) return;
        const track = rail.querySelector('[data-rail-track]');
        const prev = rail.querySelector('[data-rail-prev]');
        const next = rail.querySelector('[data-rail-next]');
        if (!track) return;

        const stepSize = () => {
            const card = track.querySelector('.testimonial');
            if (!card) return 360;
            return card.getBoundingClientRect().width + 20;
        };
        prev && prev.addEventListener('click', () => {
            track.scrollBy({ left: -stepSize(), behavior: 'smooth' });
        });
        next && next.addEventListener('click', () => {
            track.scrollBy({ left: stepSize(), behavior: 'smooth' });
        });

        // Drag-to-scroll
        let isDown = false, startX = 0, scrollLeft = 0;
        track.addEventListener('pointerdown', (e) => {
            isDown = true; startX = e.pageX - track.offsetLeft; scrollLeft = track.scrollLeft;
            track.setPointerCapture(e.pointerId);
        });
        track.addEventListener('pointermove', (e) => {
            if (!isDown) return;
            const x = e.pageX - track.offsetLeft;
            track.scrollLeft = scrollLeft - (x - startX) * 1.1;
        });
        track.addEventListener('pointerup', () => isDown = false);
        track.addEventListener('pointercancel', () => isDown = false);

        if (window.gsap && !prefersReducedMotion) {
            const cards = track.querySelectorAll('.testimonial');
            gsap.set(cards, { opacity: 0, y: 24 });
            gsap.to(cards, {
                opacity: 1, y: 0,
                duration: 0.9,
                ease: 'expo.out',
                stagger: 0.08,
                scrollTrigger: { trigger: rail, start: 'top 80%', once: true }
            });
        }
    }


    /* =========================================================
       FAQ — accordion height auto
       ========================================================= */
    function initFAQ() {
        const items = document.querySelectorAll('[data-faq]');
        items.forEach(item => {
            const btn  = item.querySelector('[data-faq-toggle]');
            const body = item.querySelector('[data-faq-body]');
            if (!btn || !body) return;
            btn.addEventListener('click', () => {
                const isOpen = item.classList.toggle('is-open');
                btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                if (window.gsap && !prefersReducedMotion) {
                    if (isOpen) {
                        gsap.fromTo(body,
                            { height: 0 },
                            { height: 'auto', duration: 0.55, ease: 'expo.out' }
                        );
                    } else {
                        gsap.to(body, { height: 0, duration: 0.4, ease: 'expo.in' });
                    }
                } else {
                    body.style.height = isOpen ? body.scrollHeight + 'px' : '0';
                }
            });
        });
    }


    /* =========================================================
       CALCULATOR — sliders, live tween, accent pulse
       ========================================================= */
    function initCalculator() {
        const calc = document.querySelector('.calc-card');
        if (!calc) return;
        const inputs = {
            proc:  calc.querySelector('[data-input="proc"]'),
            avg:   calc.querySelector('[data-input="avg"]'),
            lease: calc.querySelector('[data-input="lease"]'),
        };
        const outs = {
            proc:     calc.querySelector('[data-out="proc"]'),
            avg:      calc.querySelector('[data-out="avg"]'),
            lease:    calc.querySelector('[data-out="lease"]'),
            gross:    calc.querySelector('[data-out="gross"]'),
            leaseOut: calc.querySelector('[data-out="leaseOut"]'),
            net:      calc.querySelector('[data-out="net"]'),
        };
        const accent = calc.querySelector('.calc-result--accent');

        const fmt = (n) => {
            const fixed = Math.round(n);
            return new Intl.NumberFormat('uk-UA').format(fixed).replace(/ /g, ' ');
        };
        const state = { gross: 0, lease: 0, net: 0 };

        function compute() {
            const p = +inputs.proc.value;
            const a = +inputs.avg.value;
            const l = +inputs.lease.value;
            const gross = p * a;
            const net = gross - l;
            outs.proc.textContent  = p;
            outs.avg.textContent   = a;
            outs.lease.textContent = fmt(l);
            tweenNumber(outs.gross,    state.gross,    gross,  fmt);
            tweenNumber(outs.leaseOut, state.lease,    l,      fmt);
            tweenNumber(outs.net,      state.net,      net,    fmt);
            state.gross = gross; state.lease = l; state.net = net;
            updateFill();
            pulseAccent();
        }

        function tweenNumber(el, from, to, formatter) {
            if (!window.gsap || prefersReducedMotion) {
                el.textContent = formatter(to); return;
            }
            const obj = { v: from };
            gsap.to(obj, {
                v: to,
                duration: 0.55,
                ease: 'power3.out',
                onUpdate: () => el.textContent = formatter(obj.v)
            });
        }

        let pulseTL;
        function pulseAccent() {
            if (!accent) return;
            accent.classList.add('is-pulsing');
            clearTimeout(pulseTL);
            pulseTL = setTimeout(() => accent.classList.remove('is-pulsing'), 500);
        }

        function updateFill() {
            Object.values(inputs).forEach(input => {
                const min = +input.min, max = +input.max;
                const val = +input.value;
                const pct = ((val - min) / (max - min)) * 100;
                input.style.setProperty('--fill', pct + '%');
            });
        }

        Object.values(inputs).forEach(input => {
            input.addEventListener('input', compute);
        });
        compute();
    }


    /* =========================================================
       POPUP
       ========================================================= */
    function initPopup() {
        const popup = document.querySelector('[data-popup]');
        if (!popup) return;
        const card = popup.querySelector('.popup-card');

        const open = () => {
            popup.classList.add('is-open');
            popup.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            // Focus first input
            setTimeout(() => {
                const first = popup.querySelector('input, select');
                if (first) first.focus();
            }, 350);
        };
        const close = () => {
            popup.classList.remove('is-open');
            popup.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        document.querySelectorAll('[data-open-popup]').forEach(btn => {
            btn.addEventListener('click', (e) => { e.preventDefault(); open(); });
        });
        popup.querySelectorAll('[data-popup-close]').forEach(btn => {
            btn.addEventListener('click', close);
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && popup.classList.contains('is-open')) close();
        });
    }


    /* =========================================================
       LEAD FORM — submit handler (works on every form instance)
       ========================================================= */
    function initLeadForm() {
        const forms = document.querySelectorAll('[data-lead-form]');
        forms.forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const submit = form.querySelector('.form-submit');
                const errorEl = form.querySelector('[data-form-error]');
                const successEl = form.querySelector('[data-form-success]');
                const txt = form.querySelector('.form-submit-text');

                if (errorEl) { errorEl.hidden = true; }
                submit.classList.add('is-busy');
                if (txt) txt.textContent = txt.dataset.busy || (form.dataset.busyText || (window.AXIOM_T && AXIOM_T.busy) || 'Sending...');

                const data = new FormData(form);

                // Honeypot check
                if (data.get('company_url')) {
                    submit.classList.remove('is-busy');
                    return;
                }

                try {
                    const resp = await fetch('api/lead.php', {
                        method: 'POST',
                        body: data,
                        headers: { 'Accept': 'application/json' }
                    });
                    const json = await resp.json().catch(() => ({}));
                    if (!resp.ok || !json.ok) throw new Error(json.error || 'failed');

                    if (successEl && window.gsap && !prefersReducedMotion) {
                        successEl.classList.add('is-active');
                        successEl.setAttribute('aria-hidden', 'false');
                    } else if (successEl) {
                        successEl.classList.add('is-active');
                    }
                    form.reset();

                    // Push GA / dataLayer event if exists
                    if (window.dataLayer) {
                        window.dataLayer.push({ event: 'lead_submitted', source: form.closest('[data-popup]') ? 'popup' : 'inline' });
                    }
                } catch (err) {
                    if (errorEl) errorEl.hidden = false;
                } finally {
                    submit.classList.remove('is-busy');
                    if (txt) txt.textContent = txt.dataset.original || txt.textContent;
                }
            });

            // Cache original submit text
            const txt = form.querySelector('.form-submit-text');
            if (txt) txt.dataset.original = txt.textContent;
        });
    }


    /* =========================================================
       STICKY MOBILE CTA — show after hero
       ========================================================= */
    function initStickyMobileCTA() {
        const cta = document.querySelector('.sticky-mobile-cta');
        if (!cta) return;
        const onScroll = () => {
            cta.classList.toggle('is-visible', window.scrollY > window.innerHeight * 0.6);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }


    /* =========================================================
       FLOATING WIDGET — show after first viewport
       ========================================================= */
    function initFloatingWidget() {
        const fw = document.querySelector('[data-floating]');
        if (!fw) return;
        const onScroll = () => {
            const inHero  = window.scrollY < window.innerHeight * 0.75;
            const inFinal = window.scrollY + window.innerHeight > document.documentElement.scrollHeight - 200;
            fw.classList.toggle('is-visible', !inHero && !inFinal);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }


    /* =========================================================
       MAGNETIC BUTTONS
       ========================================================= */
    function initMagneticButtons() {
        if (!isFinePointer || !window.gsap || prefersReducedMotion) return;
        document.querySelectorAll('[data-magnet]').forEach(btn => {
            const xT = gsap.quickTo(btn, 'x', { duration: 0.5, ease: 'power3.out' });
            const yT = gsap.quickTo(btn, 'y', { duration: 0.5, ease: 'power3.out' });
            btn.addEventListener('mousemove', (e) => {
                const r = btn.getBoundingClientRect();
                const dx = (e.clientX - (r.left + r.width / 2)) * 0.18;
                const dy = (e.clientY - (r.top  + r.height / 2)) * 0.22;
                xT(dx); yT(dy);
            });
            btn.addEventListener('mouseleave', () => { xT(0); yT(0); });
        });
    }


    /* =========================================================
       CUSTOM CURSOR
       ========================================================= */
    function initCustomCursor() {
        if (!isFinePointer || prefersReducedMotion) return;
        const cursor = document.querySelector('[data-cursor]');
        if (!cursor || !window.gsap) return;

        const dot  = cursor.querySelector('.cursor-dot');
        const ring = cursor.querySelector('.cursor-ring');

        const dotX  = gsap.quickTo(dot,  'x', { duration: 0.05, ease: 'none' });
        const dotY  = gsap.quickTo(dot,  'y', { duration: 0.05, ease: 'none' });
        const ringX = gsap.quickTo(ring, 'x', { duration: 0.45, ease: 'power3.out' });
        const ringY = gsap.quickTo(ring, 'y', { duration: 0.45, ease: 'power3.out' });

        window.addEventListener('mousemove', (e) => {
            dotX(e.clientX); dotY(e.clientY);
            ringX(e.clientX); ringY(e.clientY);
        });

        document.querySelectorAll('a, button, [data-magnet], [role="button"]').forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('is-hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('is-hover'));
        });
    }


    /* =========================================================
       SMOOTH ANCHORS — close popup on hash nav, smooth scroll
       ========================================================= */
    function initSmoothAnchors() {
        document.querySelectorAll('a[href^="#"]').forEach(a => {
            a.addEventListener('click', (e) => {
                const id = a.getAttribute('href');
                if (id.length < 2) return;
                const target = document.querySelector(id);
                if (!target) return;
                e.preventDefault();
                const top = target.getBoundingClientRect().top + window.scrollY - 60;
                window.scrollTo({ top, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
            });
        });
    }

})();
