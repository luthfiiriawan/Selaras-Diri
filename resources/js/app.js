document.documentElement.classList.add('motion-ready');

const revealItems = [...document.querySelectorAll('.reveal')];

if ('IntersectionObserver' in window && revealItems.length) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
        });
    }, {
        rootMargin: '0px 0px -10% 0px',
        threshold: 0.12,
    });

    revealItems.forEach((item) => observer.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (event) => {
        const target = document.querySelector(anchor.getAttribute('href'));

        if (!target) {
            return;
        }

        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});

const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

document.querySelectorAll('[data-hero-carousel]').forEach((root) => {
    if (root.dataset.heroReady === 'true') {
        return;
    }

    root.dataset.heroReady = 'true';

    const slides = [...root.querySelectorAll('[data-hero-slide]')];

    if (slides.length <= 1) {
        return;
    }

    let activeIndex = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    let timer = null;
    const interval = Number.parseInt(root.dataset.heroInterval || '6500', 10);

    const showSlide = (nextIndex) => {
        activeIndex = nextIndex;
        slides.forEach((slide, index) => {
            const isActive = index === activeIndex;
            const image = slide.querySelector('img');

            slide.classList.toggle('is-active', isActive);
            slide.classList.toggle('opacity-100', isActive);
            slide.classList.toggle('opacity-0', !isActive);
            slide.classList.toggle('z-[1]', isActive);
            image?.classList.toggle('animate-hero-kenburns', isActive && !reducedMotionQuery.matches);
        });
    };

    const rotate = () => showSlide((activeIndex + 1) % slides.length);
    const hoverTarget = root.closest('.hero-overlay') || root;
    const stop = () => {
        window.clearInterval(timer);
        timer = null;
    };
    const start = () => {
        if (timer || reducedMotionQuery.matches || document.hidden) {
            return;
        }

        timer = window.setInterval(rotate, interval);
    };

    hoverTarget.addEventListener('mouseenter', stop);
    hoverTarget.addEventListener('mouseleave', start);
    hoverTarget.addEventListener('focusin', stop);
    hoverTarget.addEventListener('focusout', start);
    document.addEventListener('visibilitychange', () => (document.hidden ? stop() : start()));
    reducedMotionQuery.addEventListener('change', () => (reducedMotionQuery.matches ? stop() : start()));

    start();
});

document.querySelectorAll('[data-carousel-root]').forEach((root) => {
    const track = root.querySelector('[data-carousel-track]');
    const prev = root.querySelector('[data-carousel-prev]');
    const next = root.querySelector('[data-carousel-next]');

    if (!track || !prev || !next) {
        return;
    }

    const stepSize = () => {
        const card = track.querySelector('article');
        const gap = parseFloat(getComputedStyle(track).columnGap || '20') || 20;
        return card ? card.offsetWidth + gap : track.clientWidth * 0.8;
    };

    const updateButtons = () => {
        const max = track.scrollWidth - track.clientWidth - 4;
        prev.disabled = track.scrollLeft <= 4;
        next.disabled = track.scrollLeft >= max;
    };

    prev.addEventListener('click', () => track.scrollBy({ left: -stepSize(), behavior: 'smooth' }));
    next.addEventListener('click', () => track.scrollBy({ left: stepSize(), behavior: 'smooth' }));
    track.addEventListener('scroll', updateButtons, { passive: true });
    window.addEventListener('resize', updateButtons);
    updateButtons();
});
