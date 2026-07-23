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
});

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
