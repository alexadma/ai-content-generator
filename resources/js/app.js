// ============================================
// INKRAFT — Main JavaScript (Vite entry)
// ============================================

// ---- Typing Animation ----
const typingLines = [
    "Subject: 🌞 Our Biggest Summer Sale Is Here!\n\nHey there,\n\nWarm weather calls for even warmer deals. This weekend only — enjoy up to 50% off our entire summer collection. Whether you're after beachwear, accessories, or our bestselling sunscreen bundle, now is the perfect time to stock up.\n\nDon't miss out. Offer ends Sunday at midnight.\n\n→ Shop the sale now",
    "🚀 Big news: Our summer sale just dropped.\n\nUp to 50% off. This weekend only. No code needed — discounts applied at checkout.\n\nTap to shop before it's gone 👇",
    "# Summer Sale: Up to 50% Off — This Weekend Only\n\nThe sun is out and so are our best deals of the year. We've slashed prices across our entire summer lineup — think bold prints, lightweight layers, and the accessories you've been eyeing all season.\n\nShop now before Sunday's deadline."
];

let currentLine = 0;
let charIndex = 0;
let isDeleting = false;
let typingTimeout;

const outputEl = document.getElementById('typingOutput');
const cursorEl = document.getElementById('cursor');

function typeText() {
    if (!outputEl) return;

    const fullText = typingLines[currentLine];

    if (!isDeleting) {
        charIndex++;
        outputEl.textContent = fullText.slice(0, charIndex);

        if (charIndex === fullText.length) {
            // Pause at end
            typingTimeout = setTimeout(() => {
                isDeleting = true;
                typeText();
            }, 3500);
            return;
        }
        typingTimeout = setTimeout(typeText, 22);
    } else {
        charIndex -= 3;
        outputEl.textContent = fullText.slice(0, Math.max(0, charIndex));

        if (charIndex <= 0) {
            isDeleting = false;
            charIndex = 0;
            currentLine = (currentLine + 1) % typingLines.length;
            typingTimeout = setTimeout(typeText, 600);
            return;
        }
        typingTimeout = setTimeout(typeText, 8);
    }
}

// Start typing after a short delay
setTimeout(typeText, 1200);

// ---- Counter Animation ----
function animateCounter(el, target, suffix = '') {
    const duration = 1800;
    const start = performance.now();
    const isLarge = target >= 1000;

    function update(now) {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        // Ease out quart
        const eased = 1 - Math.pow(1 - progress, 4);
        const current = Math.round(eased * target);

        if (isLarge) {
            el.textContent = current.toLocaleString();
        } else {
            el.textContent = current;
        }

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            el.textContent = isLarge ? target.toLocaleString() : target;
        }
    }

    requestAnimationFrame(update);
}

// ---- Scroll Reveal & Intersection Observer ----
const observerOptions = {
    threshold: 0.12,
    rootMargin: '0px 0px -40px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');

            // Handle counter elements
            if (entry.target.classList.contains('stats__grid')) {
                const numbers = entry.target.querySelectorAll('[data-count]');
                numbers.forEach(numEl => {
                    const target = parseInt(numEl.dataset.count);
                    animateCounter(numEl, target);
                });
            }

            observer.unobserve(entry.target);
        }
    });
}, observerOptions);

// Apply reveal to sections
document.querySelectorAll('.features__grid, .steps, .stats__grid, .types-grid, .cta__inner, .section-header').forEach(el => {
    el.classList.add('reveal');
    observer.observe(el);
});

// ---- Mobile Nav ----
const burger = document.getElementById('burger');
const mobileMenu = document.getElementById('mobileMenu');

if (burger && mobileMenu) {
    burger.addEventListener('click', () => {
        mobileMenu.classList.toggle('open');
        // Animate burger to X
        const spans = burger.querySelectorAll('span');
        if (mobileMenu.classList.contains('open')) {
            spans[0].style.cssText = 'transform: translateY(6.5px) rotate(45deg)';
            spans[1].style.cssText = 'opacity: 0; transform: scaleX(0)';
            spans[2].style.cssText = 'transform: translateY(-6.5px) rotate(-45deg)';
        } else {
            spans.forEach(s => s.removeAttribute('style'));
        }
    });

    // Close on link click
    mobileMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            mobileMenu.classList.remove('open');
            burger.querySelectorAll('span').forEach(s => s.removeAttribute('style'));
        });
    });
}

// ---- Active Nav Link on Scroll ----
const sections = document.querySelectorAll('section[id]');
const navLinks = document.querySelectorAll('.nav__link');

const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const id = entry.target.getAttribute('id');
            navLinks.forEach(link => {
                link.classList.toggle('active', link.getAttribute('href') === `#${id}`);
            });
        }
    });
}, { threshold: 0.5 });

sections.forEach(section => sectionObserver.observe(section));

// ---- Content Type Pills interactivity ----
document.querySelectorAll('.type-pill').forEach(pill => {
    pill.addEventListener('click', () => {
        document.querySelectorAll('.type-pill').forEach(p => p.classList.remove('type-pill--active'));
        pill.classList.add('type-pill--active');
    });
});

// ---- Smooth anchor scrolling ----
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const targetId = this.getAttribute('href').slice(1);
        const target = document.getElementById(targetId);
        if (target) {
            e.preventDefault();
            const navHeight = 68;
            const top = target.getBoundingClientRect().top + window.scrollY - navHeight - 20;
            window.scrollTo({ top, behavior: 'smooth' });
        }
    });
});

// ---- Nav background opacity on scroll ----
const nav = document.querySelector('.nav');
window.addEventListener('scroll', () => {
    if (window.scrollY > 20) {
        nav?.classList.add('scrolled');
    } else {
        nav?.classList.remove('scrolled');
    }
}, { passive: true });

document.addEventListener('DOMContentLoaded', function () {
    console.log("DOM READY");

    const form = document.getElementById('contentForm');

    if (!form) {
        console.log("FORM TIDAK DITEMUKAN");
        return;
    }

    console.log("FORM DITEMUKAN");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        console.log("SUBMIT KEDETECT");

        const formData = new FormData(form);

        try {
            const response = await fetch("/generate", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: formData
            });

            const data = await response.json();
            console.log("RESPONSE:", data);

        } catch (err) {
            console.error("ERROR:", err);
        }
    });
});