/* ============================================================
   AXIOM TECHNOLOGY — main.js  v2
   - Pin-stack panel system (CodePen-style scale/fade)
   - IntersectionObserver-based reveals (robust under pinning)
   - Calculator with live number tweens
   - Popup, lead form, custom cursor, magnetic CTAs
   ============================================================ */

(function () {
    'use strict';

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isFinePointer = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

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

        // Order matters slightly: prepare DOM mutations (split text) before observers
        initPreloader();
        initHeader();
        initMobileNav();
        initTechShowcase();
        prepareSplitChars();
        prepareSplitLines();
        initReveals();             // IntersectionObserver-based — independent of pin
        initHeroCharIntro();       // first-paint cascade
        initChips();
        initProductCardParallax();
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
        initSalons();
        initTechVerbs();
        initInside();
        initPanelStack();          // pin-stack last — relies on layout being ready

        // Final layout sync
        if (hasGSAP) {
            window.addEventListener('load', () => ScrollTrigger.refresh());
        }
    });


    /* =========================================================
       HEADER — shrink + glass on scroll
       ========================================================= */
    function initHeader() {
        const header = document.querySelector('[data-header]');
        if (!header) return;
        const onScroll = () => {
            header.classList.toggle('is-scrolled', window.scrollY > 30);
        };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }


    /* =========================================================
       MOBILE NAV
       ========================================================= */
    function initMobileNav() {
        const toggle = document.querySelector('[data-nav-toggle]');
        const panel = document.querySelector('[data-nav-mobile]');
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
       SPLIT CHARS — for hero only (per-character cascade on load)
       Pre-process DOM so chars are ready, then run intro animation.
       ========================================================= */
    function prepareSplitChars() {
        document.querySelectorAll('[data-split]').forEach(line => {
            if (line.dataset.splitDone) return;

            const buildWord = (wordText) => {
                const wordEl = document.createElement('span');
                wordEl.className = 'split-word';
                for (const ch of wordText) {
                    const c = document.createElement('span');
                    c.className = 'split-char';
                    c.textContent = ch;
                    wordEl.appendChild(c);
                }
                return wordEl;
            };
            const splitText = (text) => {
                const out = [];
                text.split(/(\s+)/).forEach(tok => {
                    if (tok === '') return;
                    if (/^\s+$/.test(tok)) out.push(document.createTextNode(tok));
                    else out.push(buildWord(tok));
                });
                return out;
            };
            const wrap = (node) => {
                const out = [];
                node.childNodes.forEach(child => {
                    if (child.nodeType === Node.TEXT_NODE) {
                        out.push(...splitText(child.textContent));
                    } else if (child.nodeType === Node.ELEMENT_NODE) {
                        const wrapped = wrap(child);
                        const wrapper = document.createElement(child.tagName.toLowerCase());
                        wrapper.append(...wrapped);
                        out.push(wrapper);
                    }
                });
                return out;
            };
            const tmp = document.createElement('span');
            tmp.innerHTML = line.innerHTML;
            line.innerHTML = '';
            line.append(...wrap(tmp));
            line.dataset.splitDone = '1';
        });
    }

    function initHeroCharIntro() {
        if (prefersReducedMotion) {
            document.querySelectorAll('[data-split] .split-char').forEach(s => {
                s.style.opacity = 1; s.style.transform = 'none';
            });
            return;
        }

        const heroLines = document.querySelectorAll('.hero-title [data-split]');
        if (!heroLines.length) return;

        if (window.gsap) {
            const tl = gsap.timeline({ delay: 0.15 });
            heroLines.forEach((line, i) => {
                const chars = line.querySelectorAll('.split-char');
                tl.to(chars, {
                    y: 0,
                    opacity: 1,
                    duration: 0.95,
                    stagger: 0.018,
                    ease: 'expo.out',
                }, i * 0.10);
            });
        } else {
            // CSS fallback
            heroLines.forEach((line, li) => {
                line.querySelectorAll('.split-char').forEach((s, i) => {
                    s.style.transition = `opacity 0.7s ease ${(li * 0.1 + i * 0.018)}s, transform 0.7s ease ${(li * 0.1 + i * 0.018)}s`;
                    requestAnimationFrame(() => {
                        s.style.opacity = 1;
                        s.style.transform = 'translateY(0)';
                    });
                });
            });
        }
    }


    /* =========================================================
       SPLIT LINES — wrap section titles in mask + inner span.
       Reveal handled by IntersectionObserver below.
       ========================================================= */
    function prepareSplitLines() {
        document.querySelectorAll('[data-split-lines]').forEach(el => {
            if (el.dataset.splitLinesDone) return;
            const original = el.innerHTML;
            const inner = document.createElement('span');
            inner.className = 'split-line-inner';
            inner.innerHTML = original;
            const mask = document.createElement('span');
            mask.className = 'split-line';
            mask.appendChild(inner);
            el.innerHTML = '';
            el.appendChild(mask);
            el.dataset.splitLinesDone = '1';
        });
    }


    /* =========================================================
       REVEALS — IntersectionObserver, robust under pinning.
       Adds .is-revealed class once an element enters viewport.
       CSS handles the actual transitions.
       ========================================================= */
    function initReveals() {
        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            document.querySelectorAll('[data-anim], [data-split-lines], [data-pillar], [data-product], [data-adv-card], [data-income-row], [data-big-number]').forEach(el => el.classList.add('is-revealed'));
            return;
        }

        const targets = document.querySelectorAll(
            '[data-anim="fade-up"], [data-anim="hero-visual"], [data-split-lines], [data-pillar], [data-product], [data-adv-card], [data-income-row], [data-big-number]'
        );

        const STAGGER_SELECTORS = ['[data-pillar]', '[data-product]', '[data-adv-card]', '[data-income-row]'];

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const group = el.parentElement;
                if (group) {
                    for (const sel of STAGGER_SELECTORS) {
                        if (el.matches(sel)) {
                            const peers = Array.from(group.querySelectorAll(sel));
                            const idx = peers.indexOf(el);
                            if (idx >= 0) el.style.transitionDelay = (idx * 0.07) + 's';
                            break;
                        }
                    }
                }
                el.classList.add('is-revealed');
                observer.unobserve(el);
            });
        }, {
            threshold: 0.15,
            rootMargin: '0px 0px -8% 0px'
        });

        targets.forEach(el => observer.observe(el));
    }


    /* =========================================================
       CHIPS — perpetual float + magnetic pull
       ========================================================= */
    function initChips() {
        const chips = document.querySelectorAll('[data-chip]');
        if (!chips.length) return;

        if (window.gsap && !prefersReducedMotion) {
            chips.forEach((chip, i) => {
                gsap.set(chip, { opacity: 0, y: 24, scale: 0.92 });
                gsap.to(chip, {
                    opacity: 1, y: 0, scale: 1,
                    duration: 1.0,
                    ease: 'expo.out',
                    delay: 0.7 + i * 0.12
                });
            });
        } else {
            chips.forEach(c => { c.style.opacity = 1; c.style.transform = 'none'; });
        }

        if (!isFinePointer || !window.gsap || prefersReducedMotion) return;
        const visual = document.querySelector('.hero-visual');
        if (!visual) return;
        const handlers = [];
        chips.forEach(chip => {
            const xT = gsap.quickTo(chip, 'x', { duration: 0.6, ease: 'power3.out' });
            const yT = gsap.quickTo(chip, 'y', { duration: 0.6, ease: 'power3.out' });
            handlers.push((ev) => {
                const r = visual.getBoundingClientRect();
                const cx = r.left + r.width / 2;
                const cy = r.top + r.height / 2;
                xT((ev.clientX - cx) * 0.05);
                yT((ev.clientY - cy) * 0.05);
            });
        });
        window.addEventListener('mousemove', (ev) => handlers.forEach(h => h(ev)), { passive: true });
    }


    /* =========================================================
       PRODUCT CARD MOUSE PARALLAX
       ========================================================= */
    function initProductCardParallax() {
        if (!isFinePointer || !window.gsap) return;
        document.querySelectorAll('[data-product]').forEach(card => {
            const img = card.querySelector('.product-image img');
            if (!img) return;
            const xT = gsap.quickTo(img, 'x', { duration: 0.7, ease: 'power3.out' });
            const yT = gsap.quickTo(img, 'y', { duration: 0.7, ease: 'power3.out' });
            card.addEventListener('mousemove', (ev) => {
                const r = card.getBoundingClientRect();
                const dx = ((ev.clientX - r.left) / r.width - 0.5) * 14;
                const dy = ((ev.clientY - r.top) / r.height - 0.5) * 8;
                xT(dx); yT(dy);
            });
            card.addEventListener('mouseleave', () => { xT(0); yT(0); });
        });
    }


    /* =========================================================
       TESTIMONIAL RAIL
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
            return card.getBoundingClientRect().width + 18;
        };
        prev && prev.addEventListener('click', () => track.scrollBy({ left: -stepSize(), behavior: 'smooth' }));
        next && next.addEventListener('click', () => track.scrollBy({ left: stepSize(), behavior: 'smooth' }));

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
    }


    /* =========================================================
       FAQ accordion
       ========================================================= */
    function initFAQ() {
        // CSS-only animation via grid-template-rows: 0fr → 1fr.
        // JS only toggles class + enforces single-open behaviour.
        const items = document.querySelectorAll('[data-faq]');
        items.forEach(item => {
            const btn = item.querySelector('[data-faq-toggle]');
            if (!btn) return;
            btn.addEventListener('click', () => {
                const willOpen = !item.classList.contains('is-open');
                items.forEach(other => {
                    if (other !== item) {
                        other.classList.remove('is-open');
                        const otherBtn = other.querySelector('[data-faq-toggle]');
                        if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
                    }
                });
                item.classList.toggle('is-open', willOpen);
                btn.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            });
        });
    }


    /* =========================================================
       CALCULATOR
       ========================================================= */
    function initCalculator() {
        const calc = document.querySelector('.calc-card');
        if (!calc) return;
        const inputs = {
            proc: calc.querySelector('[data-input="proc"]'),
            avg: calc.querySelector('[data-input="avg"]'),
            lease: calc.querySelector('[data-input="lease"]'),
        };
        const outs = {
            proc: calc.querySelector('[data-out="proc"]'),
            avg: calc.querySelector('[data-out="avg"]'),
            lease: calc.querySelector('[data-out="lease"]'),
            gross: calc.querySelector('[data-out="gross"]'),
            leaseOut: calc.querySelector('[data-out="leaseOut"]'),
            net: calc.querySelector('[data-out="net"]'),
        };
        const accent = calc.querySelector('.calc-result--accent');

        const fmt = (n) => new Intl.NumberFormat('uk-UA').format(Math.round(n)).replace(/ /g, ' ');
        const state = { gross: 0, lease: 0, net: 0 };

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

        let pulseT;
        function pulseAccent() {
            if (!accent) return;
            accent.classList.add('is-pulsing');
            clearTimeout(pulseT);
            pulseT = setTimeout(() => accent.classList.remove('is-pulsing'), 500);
        }

        function updateFill() {
            Object.values(inputs).forEach(input => {
                if (!input) return;
                const min = +input.min, max = +input.max;
                const val = +input.value;
                const pct = ((val - min) / (max - min)) * 100;
                input.style.setProperty('--fill', pct + '%');
            });
        }

        function compute() {
            const p = +inputs.proc.value;
            const a = +inputs.avg.value;
            const l = +inputs.lease.value;
            const gross = p * a;
            const net = gross - l;
            outs.proc.textContent = p;
            outs.avg.textContent = a;
            outs.lease.textContent = fmt(l);
            tweenNumber(outs.gross, state.gross, gross, fmt);
            tweenNumber(outs.leaseOut, state.lease, l, fmt);
            tweenNumber(outs.net, state.net, net, fmt);
            state.gross = gross; state.lease = l; state.net = net;
            updateFill();
            pulseAccent();
        }

        Object.values(inputs).forEach(input => {
            if (input) input.addEventListener('input', compute);
        });
        compute();
    }


    /* =========================================================
       POPUP
       ========================================================= */
    function initPopup() {
        const popup = document.querySelector('[data-popup]');
        if (!popup) return;
        const open = () => {
            popup.classList.add('is-open');
            popup.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
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
       LEAD FORM
       ========================================================= */
    function initLeadForm() {
        document.querySelectorAll('[data-lead-form]').forEach(form => {
            const txt = form.querySelector('.form-submit-text');
            if (txt) txt.dataset.original = txt.textContent;

            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const submit = form.querySelector('.form-submit');
                const errorEl = form.querySelector('[data-form-error]');
                const successEl = form.querySelector('[data-form-success]');
                const tx = form.querySelector('.form-submit-text');

                if (errorEl) errorEl.hidden = true;
                submit.classList.add('is-busy');
                if (tx) tx.textContent = 'Sending...';

                const data = new FormData(form);

                if (data.get('company_url')) {
                    submit.classList.remove('is-busy');
                    if (tx) tx.textContent = tx.dataset.original;
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
                    if (successEl) {
                        successEl.classList.add('is-active');
                        successEl.setAttribute('aria-hidden', 'false');
                    }
                    form.reset();
                    if (window.dataLayer) {
                        window.dataLayer.push({ event: 'lead_submitted', source: form.closest('[data-popup]') ? 'popup' : 'inline' });
                    }
                } catch (err) {
                    if (errorEl) errorEl.hidden = false;
                } finally {
                    submit.classList.remove('is-busy');
                    if (tx) tx.textContent = tx.dataset.original || tx.textContent;
                }
            });
        });
    }


    /* =========================================================
       STICKY MOBILE CTA
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
       FLOATING WIDGET
       ========================================================= */
    function initFloatingWidget() {
        const fw = document.querySelector('[data-floating]');
        if (!fw) return;
        const onScroll = () => {
            const inHero = window.scrollY < window.innerHeight * 0.75;
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
                xT((e.clientX - (r.left + r.width / 2)) * 0.18);
                yT((e.clientY - (r.top + r.height / 2)) * 0.22);
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

        const dot = cursor.querySelector('.cursor-dot');
        const ring = cursor.querySelector('.cursor-ring');
        const dotX = gsap.quickTo(dot, 'x', { duration: 0.05, ease: 'none' });
        const dotY = gsap.quickTo(dot, 'y', { duration: 0.05, ease: 'none' });
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
       SMOOTH ANCHORS
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


    /* =========================================================
       PIN-STACK PANEL SYSTEM (CodePen GreenSock pattern)
       Each panel pins, scales down, fades — next panel slides over.
       ========================================================= */
    function initPanelStack() {
        // v5: restore CodePen-exact pin-stack (GreenSock pinned-panels-with-overscroll)
        // Tech verbs panel is excluded via [data-panel-skip] (it runs its own scroll).
        if (!window.gsap || !window.ScrollTrigger || prefersReducedMotion) return;
        if (window.matchMedia('(max-width: 1024px)').matches) return;

        const panels = gsap.utils.toArray('[data-panel]:not([data-panel-skip])');
        if (panels.length < 2) return;
        // last panel doesn't pin (matches codepen)
        panels.pop();

        panels.forEach((panel) => {
            const inner = panel.querySelector('.panel-content');
            if (!inner) return;

            const panelHeight = inner.offsetHeight;
            const winH = window.innerHeight;
            const diff = panelHeight - winH;
            const fakeScrollRatio = diff > 0 ? diff / (diff + winH) : 0;

            if (fakeScrollRatio) {
                panel.style.marginBottom = (panelHeight * fakeScrollRatio) + 'px';
            }

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: panel,
                    start: 'bottom bottom',
                    end: () => fakeScrollRatio ? `+=${inner.offsetHeight}` : 'bottom top',
                    pinSpacing: false,
                    pin: true,
                    scrub: true,
                    invalidateOnRefresh: true,
                }
            });

            if (fakeScrollRatio) {
                tl.to(inner, {
                    yPercent: -100,
                    y: () => window.innerHeight,
                    duration: 1 / (1 - fakeScrollRatio) - 1,
                    ease: 'none'
                });
            }
            tl.fromTo(panel,
                { scale: 1, opacity: 1 },
                { scale: 0.7, opacity: 0.5, duration: 0.9, ease: 'none' }
            ).to(panel, { opacity: 0, duration: 0.1, ease: 'none' });
        });

        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => ScrollTrigger.refresh());
        }
        window.addEventListener('resize', () => ScrollTrigger.refresh());
        return;

        // legacy code below — kept for reference, never reached

        panels.forEach((panel) => {
            const inner = panel.querySelector('.panel-content');
            if (!inner) return;

            // Measure
            const panelHeight = inner.offsetHeight;
            const winH = window.innerHeight;
            const diff = panelHeight - winH;
            const ratio = diff > 0 ? diff / (diff + winH) : 0;

            if (ratio > 0) {
                panel.style.marginBottom = (panelHeight * ratio) + 'px';
            }

            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: panel,
                    start: 'bottom bottom',
                    end: () => ratio ? `+=${inner.offsetHeight}` : 'bottom top',
                    pin: true,
                    pinSpacing: false,
                    scrub: true,
                    invalidateOnRefresh: true,
                }
            });

            // Inner fake-scroll if content > viewport
            if (ratio > 0) {
                tl.to(inner, {
                    yPercent: -100,
                    y: () => window.innerHeight,
                    duration: 1 / (1 - ratio) - 1,
                    ease: 'none'
                });
            }

            tl.fromTo(panel,
                { scale: 1, opacity: 1 },
                { scale: 0.7, opacity: 0.5, duration: 0.9, ease: 'none' }
            ).to(panel, { opacity: 0, duration: 0.1, ease: 'none' });
        });

        // Refresh on font load (display fonts can shift heights)
        if (document.fonts && document.fonts.ready) {
            document.fonts.ready.then(() => ScrollTrigger.refresh());
        }
        window.addEventListener('resize', () => ScrollTrigger.refresh());
    }


    /* =========================================================
       PRELOADER — premium logo + signal + brand text
       Min display 2.2s, fade out, then unlock body scroll.
       ========================================================= */
    function initPreloader() {
        const preloader = document.querySelector('[data-preloader]');
        if (!preloader) {
            document.body.classList.remove('is-loading');
            return;
        }

        const minTime = prefersReducedMotion ? 400 : 2500;
        const start = performance.now();

        const dismiss = () => {
            const elapsed = performance.now() - start;
            const wait = Math.max(0, minTime - elapsed);
            setTimeout(() => {
                preloader.classList.add('is-leaving');
                setTimeout(() => {
                    preloader.parentNode && preloader.parentNode.removeChild(preloader);
                    document.body.classList.remove('is-loading');
                    if (window.ScrollTrigger) ScrollTrigger.refresh();
                }, prefersReducedMotion ? 220 : 900);
            }, wait);
        };

        if (document.readyState === 'complete') {
            dismiss();
        } else {
            window.addEventListener('load', dismiss, { once: true });
        }

        // Safety net: never block more than 6s
        setTimeout(() => {
            if (document.body.classList.contains('is-loading')) {
                preloader.classList.add('is-leaving');
                setTimeout(() => {
                    preloader.parentNode && preloader.parentNode.removeChild(preloader);
                    document.body.classList.remove('is-loading');
                }, 600);
            }
        }, 6000);
    }


    /* =========================================================
       TECH SHOWCASE — clickable / hover tabs + auto-rotate
       ========================================================= */
    function initTechShowcase() {
        const root = document.querySelector('[data-tech-showcase]');
        if (!root) return;

        const tabs   = Array.from(root.querySelectorAll('[data-tech-tab]'));
        const images = Array.from(root.querySelectorAll('[data-tech-image]'));
        const cards  = Array.from(root.querySelectorAll('[data-tech-card]'));
        if (!tabs.length) return;

        const ROTATE_MS = 5500;
        let active = 0;
        let timer = null;
        let isHover = false;

        // expose duration so CSS progress bar matches
        root.style.setProperty('--tech-rotate', (ROTATE_MS / 1000) + 's');

        function setActive(i, opts = {}) {
            if (i === active && !opts.force) return;
            tabs.forEach((t, idx) => {
                const on = idx === i;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-selected', on ? 'true' : 'false');
                t.tabIndex = on ? 0 : -1;
            });
            images.forEach((im, idx) => im.classList.toggle('is-active', idx === i));
            cards.forEach((c, idx) => {
                const on = idx === i;
                c.classList.toggle('is-active', on);
                c.setAttribute('aria-hidden', on ? 'false' : 'true');
            });
            active = i;
        }

        function startRotate() {
            stopRotate();
            if (prefersReducedMotion) return;
            timer = setInterval(() => {
                if (!isHover) setActive((active + 1) % tabs.length);
            }, ROTATE_MS);
        }
        function stopRotate() {
            if (timer) { clearInterval(timer); timer = null; }
        }

        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => { setActive(i); startRotate(); });
            tab.addEventListener('mouseenter', () => {
                isHover = true;
                if (!isFinePointer) return;
                setActive(i);
            });
            tab.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    e.preventDefault();
                    const next = (i + 1) % tabs.length;
                    setActive(next); tabs[next].focus(); startRotate();
                } else if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    e.preventDefault();
                    const next = (i - 1 + tabs.length) % tabs.length;
                    setActive(next); tabs[next].focus(); startRotate();
                } else if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    setActive(i); startRotate();
                }
            });
        });
        root.addEventListener('mouseleave', () => { isHover = false; });
        root.addEventListener('mouseenter', () => { isHover = true; });

        // Pause rotation when offscreen, resume when visible
        if ('IntersectionObserver' in window) {
            const io = new IntersectionObserver((entries) => {
                entries.forEach(entry => entry.isIntersecting ? startRotate() : stopRotate());
            }, { threshold: 0.25 });
            io.observe(root);
        } else {
            startRotate();
        }

        setActive(0, { force: true });

        // v4: pin-scroll mode (desktop, GSAP available, not reduced)
        if (window.gsap && window.ScrollTrigger && !prefersReducedMotion &&
            !window.matchMedia('(max-width: 1024px)').matches) {
            stopRotate();
            const count = tabs.length;
            ScrollTrigger.create({
                trigger: root,
                start: 'top top+=80',
                end: () => '+=' + (window.innerHeight * (count - 0.4)),
                pin: true,
                pinSpacing: true,
                scrub: 0.5,
                invalidateOnRefresh: true,
                onUpdate: (self) => {
                    const idx = Math.min(count - 1, Math.max(0, Math.floor(self.progress * count)));
                    setActive(idx);
                }
            });
        }
    }


    /* =========================================================
       SALONS — scrubbing word reveal + counter ticks
       ========================================================= */
    function initSalons() {
        const stage = document.querySelector('[data-salons]');
        if (!stage) return;

        // Word reveal scrub
        const words = stage.querySelectorAll('.sw-word');
        if (words.length && window.gsap && window.ScrollTrigger && !prefersReducedMotion) {
            ScrollTrigger.create({
                trigger: stage.querySelector('[data-salons-words]'),
                start: 'top 78%',
                end: 'bottom 60%',
                scrub: 0.5,
                onUpdate: (self) => {
                    const p = self.progress;
                    const cutoff = Math.floor(p * words.length);
                    words.forEach((w, i) => {
                        w.classList.toggle('is-on', i <= cutoff);
                    });
                }
            });
        } else {
            words.forEach(w => w.classList.add('is-on'));
        }

        // Counter ticks + stat reveal
        const stats = stage.querySelectorAll('[data-stat-item]');
        const counters = stage.querySelectorAll('[data-counter]');
        if (!('IntersectionObserver' in window)) {
            counters.forEach(c => c.textContent = c.dataset.to + (c.dataset.suffix || ''));
            stats.forEach(s => s.classList.add('is-on'));
            return;
        }
        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const idx = Array.from(stats).indexOf(entry.target);
                setTimeout(() => entry.target.classList.add('is-on'), idx * 120);
                entry.target.querySelectorAll('[data-counter]').forEach(c => {
                    const from = +(c.dataset.from || 0);
                    const to = +(c.dataset.to || 0);
                    const suffix = c.dataset.suffix || '';
                    if (window.gsap && !prefersReducedMotion) {
                        const obj = { v: from };
                        gsap.to(obj, {
                            v: to, duration: 1.4, ease: 'expo.out', delay: idx * 0.12,
                            onUpdate: () => c.textContent = Math.round(obj.v) + suffix
                        });
                    } else {
                        c.textContent = to + suffix;
                    }
                });
                io.unobserve(entry.target);
            });
        }, { threshold: 0.4 });
        stats.forEach(s => io.observe(s));
    }


    /* =========================================================
       INSIDE AXIOM — CSS sticky + IntersectionObserver markers
       (replaces GSAP pin — robust under LiteSpeed/cache plugins)
       ========================================================= */
    function initInside() {
        const track = document.querySelector('[data-inside-track]');
        if (!track) return;
        const frames   = Array.from(track.querySelectorAll('[data-inside-frame]'));
        const tabs     = Array.from(track.querySelectorAll('[data-inside-tab]'));
        const markers  = Array.from(track.querySelectorAll('[data-inside-marker]'));
        const progress = track.querySelector('[data-inside-progress]');
        const total = frames.length;
        if (!total) return;

        const setActive = (i) => {
            i = Math.max(0, Math.min(total - 1, i));
            frames.forEach((f, k) => f.classList.toggle('is-active', k === i));
            tabs.forEach((t, k) => {
                t.classList.toggle('is-active', k === i);
                t.setAttribute('aria-current', k === i ? 'true' : 'false');
            });
            if (progress) progress.style.setProperty('--p', ((i + 1) / total * 100) + '%');
        };

        // Mobile / reduced-motion: stack all frames visible, no sticky
        if (window.matchMedia('(max-width: 1024px)').matches || prefersReducedMotion) {
            frames.forEach(f => f.classList.add('is-active'));
            tabs.forEach((t, k) => t.classList.toggle('is-active', k === 0));
            return;
        }

        setActive(0);

        // IntersectionObserver: marker becomes "active" when its centre crosses
        // the viewport centre. rootMargin -49% top / -49% bottom = 2% strip.
        if ('IntersectionObserver' in window && markers.length) {
            const io = new IntersectionObserver((entries) => {
                // multiple may match during fast scroll; pick the latest active
                let pick = -1;
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const idx = parseInt(entry.target.dataset.insideMarker, 10);
                        if (!Number.isNaN(idx)) pick = Math.max(pick, idx);
                    }
                });
                if (pick >= 0) setActive(pick);
            }, {
                rootMargin: '-49% 0% -49% 0%',
                threshold: 0
            });
            markers.forEach(m => io.observe(m));
        } else {
            frames.forEach(f => f.classList.add('is-active'));
        }

        // Tab click → smooth-scroll to that marker
        tabs.forEach((tab, i) => {
            tab.addEventListener('click', () => {
                const m = markers[i];
                if (!m) return;
                const top = m.getBoundingClientRect().top + window.scrollY - window.innerHeight * 0.5 + m.offsetHeight * 0.5;
                window.scrollTo({ top, behavior: prefersReducedMotion ? 'auto' : 'smooth' });
            });
        });
    }


    /* =========================================================
       TECH VERBS — CodePen aidenwood scroll-driven brightness
       ========================================================= */
    function initTechVerbs() {
        const list = document.querySelector('.tech-verbs');
        if (!list) return;
        const items = gsap.utils.toArray(list.querySelectorAll('li'));
        if (!items.length) return;

        if (prefersReducedMotion || !window.gsap || !window.ScrollTrigger) {
            items.forEach(i => i.classList.add('is-active'));
            return;
        }

        gsap.set(items, { opacity: (i) => i === 0 ? 1 : 0.2 });

        const dimmer = gsap.timeline()
            .to(items.slice(1), { opacity: 1, stagger: 0.5, ease: 'none' })
            .to(items.slice(0, items.length - 1), {
                opacity: 0.2, stagger: 0.5, ease: 'none'
            }, 0);

        ScrollTrigger.create({
            trigger: items[0],
            endTrigger: items[items.length - 1],
            start: 'center center',
            end: 'center center',
            animation: dimmer,
            scrub: 0.2,
        });

        // Mark "active" — opacity > 0.85 → ink color via .is-active
        ScrollTrigger.create({
            trigger: list,
            start: 'top top',
            end: 'bottom bottom',
            onUpdate: () => {
                const center = window.innerHeight / 2;
                let bestIdx = 0, bestDist = Infinity;
                items.forEach((el, i) => {
                    const r = el.getBoundingClientRect();
                    const c = r.top + r.height / 2;
                    const d = Math.abs(c - center);
                    if (d < bestDist) { bestDist = d; bestIdx = i; }
                });
                items.forEach((el, i) => el.classList.toggle('is-active', i === bestIdx));
            }
        });
    }

})();
