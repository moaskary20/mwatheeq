import './bootstrap';

const hidePreloader = () => {
    const preloader = document.getElementById('site-preloader');
    if (!preloader || preloader.classList.contains('is-hidden')) return;

    preloader.classList.add('is-hidden');
    window.setTimeout(() => preloader.remove(), 550);
};

window.addEventListener('load', () => {
    window.setTimeout(hidePreloader, 400);
});

window.setTimeout(hidePreloader, 4000);

document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.querySelector('[data-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');
    const mobileOverlay = document.querySelector('[data-mobile-overlay]');
    const menuClose = document.querySelector('[data-menu-close]');
    const siteHeader = document.querySelector('[data-site-header]');
    const iconOpen = document.querySelector('[data-menu-icon-open]');
    const iconClose = document.querySelector('[data-menu-icon-close]');

    const setMenuOpen = (open) => {
        mobileMenu?.classList.toggle('is-open', open);
        mobileOverlay?.classList.toggle('is-open', open);
        mobileOverlay?.toggleAttribute('hidden', !open);
        mobileMenu?.setAttribute('aria-hidden', String(!open));
        menuButton?.setAttribute('aria-expanded', String(open));
        menuButton?.setAttribute(
            'aria-label',
            open
                ? (menuButton.dataset.labelClose || 'Close menu')
                : (menuButton.dataset.labelOpen || 'Open menu'),
        );
        document.body.classList.toggle('menu-open', open);
        iconOpen?.classList.toggle('hidden', open);
        iconClose?.classList.toggle('hidden', !open);
    };

    menuButton?.addEventListener('click', () => {
        const open = !mobileMenu?.classList.contains('is-open');
        setMenuOpen(open);
    });

    menuClose?.addEventListener('click', () => setMenuOpen(false));
    mobileOverlay?.addEventListener('click', () => setMenuOpen(false));

    document.querySelectorAll('[data-mobile-menu] a').forEach((link) => {
        link.addEventListener('click', () => setMenuOpen(false));
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setMenuOpen(false);
    });

    const onScroll = () => {
        siteHeader?.classList.toggle('is-scrolled', window.scrollY > 24);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.12, rootMargin: '0px 0px -40px 0px' },
    );

    document.querySelectorAll('.reveal, .reveal-left, .reveal-scale').forEach((el) => {
        observer.observe(el);
    });

    initHeroSlider();
    initServiceRequestModal();
});

function initServiceRequestModal() {
    const modal = document.querySelector('[data-service-request-modal]');
    const overlay = document.querySelector('[data-service-request-overlay]');
    const form = document.querySelector('[data-service-request-form]');
    const closeButtons = document.querySelectorAll('[data-service-request-close]');
    const serviceSelect = document.getElementById('service-request-service');
    const successAlert = document.querySelector('[data-service-request-success]');
    const errorAlert = document.querySelector('[data-service-request-error]');
    const submitButton = document.querySelector('[data-service-request-submit]');
    const submitLabel = document.querySelector('[data-service-request-submit-label]');

    if (!modal || !overlay || !form) return;

    const defaultSubmitLabel = submitLabel?.textContent?.trim() || '';
    const submittingLabel = modal.dataset.submittingLabel || 'Sending...';
    const genericError = modal.dataset.errorLabel || 'Error';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const clearAlerts = () => {
        if (successAlert) {
            successAlert.hidden = true;
            successAlert.textContent = '';
        }
        if (errorAlert) {
            errorAlert.hidden = true;
            errorAlert.textContent = '';
        }
        form.querySelectorAll('[data-error-for]').forEach((el) => {
            el.hidden = true;
            el.textContent = '';
        });
    };

    const setOpen = (open) => {
        modal.classList.toggle('is-open', open);
        overlay.classList.toggle('is-open', open);
        modal.toggleAttribute('hidden', !open);
        overlay.toggleAttribute('hidden', !open);
        modal.setAttribute('aria-hidden', String(!open));
        overlay.setAttribute('aria-hidden', String(!open));
        document.body.classList.toggle('service-request-open', open);

        if (open) {
            window.setTimeout(() => {
                document.getElementById('service-request-name')?.focus();
            }, 50);
        }
    };

    const openForService = (serviceId) => {
        clearAlerts();
        form.reset();
        if (serviceSelect && serviceId) {
            serviceSelect.value = String(serviceId);
        }
        if (submitButton) submitButton.disabled = false;
        if (submitLabel) submitLabel.textContent = defaultSubmitLabel;
        setOpen(true);
    };

    document.querySelectorAll('[data-service-request-open]').forEach((trigger) => {
        const open = () => openForService(trigger.getAttribute('data-service-id'));
        trigger.addEventListener('click', open);
        trigger.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                open();
            }
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener('click', () => setOpen(false));
    });

    overlay.addEventListener('click', () => setOpen(false));

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            setOpen(false);
        }
    });

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearAlerts();

        if (submitButton) submitButton.disabled = true;
        if (submitLabel) submitLabel.textContent = submittingLabel;

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new FormData(form),
            });

            const data = await response.json().catch(() => ({}));

            if (response.ok) {
                if (successAlert) {
                    successAlert.textContent = data.message || '';
                    successAlert.hidden = false;
                }
                form.reset();
                window.setTimeout(() => setOpen(false), 1400);
                return;
            }

            if (response.status === 422 && data.errors) {
                Object.entries(data.errors).forEach(([field, messages]) => {
                    const target = form.querySelector(`[data-error-for="${field}"]`);
                    if (!target) return;
                    target.textContent = Array.isArray(messages) ? messages[0] : String(messages);
                    target.hidden = false;
                });
            }

            if (errorAlert) {
                errorAlert.textContent = data.message || genericError;
                errorAlert.hidden = false;
            }
        } catch (_) {
            if (errorAlert) {
                errorAlert.textContent = genericError;
                errorAlert.hidden = false;
            }
        } finally {
            if (submitButton) submitButton.disabled = false;
            if (submitLabel) submitLabel.textContent = defaultSubmitLabel;
        }
    });
}

function initHeroSlider() {
    const root = document.querySelector('[data-hero-slider]');
    if (!root) return;

    const slides = Array.from(root.querySelectorAll('[data-slide]'));
    if (slides.length <= 1) return;

    const dots = Array.from(root.querySelectorAll('[data-slider-dot]'));
    const prevBtn = root.querySelector('[data-slider-prev]');
    const nextBtn = root.querySelector('[data-slider-next]');
    const duration = 6000;
    let index = 0;
    let timer = null;

    const restartProgress = (activeIndex) => {
        dots.forEach((dot, i) => {
            const progress = dot.querySelector('.hero-dot-progress');
            dot.classList.toggle('is-active', i === activeIndex);
            dot.classList.remove('is-paused');
            if (!progress) return;
            progress.style.animation = 'none';
            void progress.offsetWidth;
            progress.style.animation = '';
        });
    };

    const show = (nextIndex) => {
        index = (nextIndex + slides.length) % slides.length;

        slides.forEach((slide, i) => {
            const active = i === index;
            slide.classList.toggle('is-active', active);
            slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        });

        restartProgress(index);
    };

    const start = () => {
        stop();
        timer = window.setInterval(() => show(index + 1), duration);
        dots.forEach((dot) => dot.classList.remove('is-paused'));
    };

    const stop = () => {
        if (timer) {
            window.clearInterval(timer);
            timer = null;
        }
        dots.forEach((dot) => dot.classList.add('is-paused'));
    };

    prevBtn?.addEventListener('click', () => {
        show(index - 1);
        start();
    });

    nextBtn?.addEventListener('click', () => {
        show(index + 1);
        start();
    });

    dots.forEach((dot) => {
        dot.addEventListener('click', () => {
            show(Number(dot.dataset.sliderDot));
            start();
        });
    });

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    show(0);
    start();
}
