<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inkraft — AI Content Generator</title>
    <meta name="description" content="Generate compelling content in seconds with AI. Marketing copy, emails, blog posts, social media — all powered by advanced language models." />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Navigation --}}
    <nav class="nav">
        <div class="nav__inner">
            <a href="/" class="nav__logo">
                <span class="nav__logo-mark">✦</span>
                <span class="nav__logo-text">Inkraft</span>
            </a>
            <div class="nav__links">
                <a href="#features" class="nav__link">Features</a>
                <a href="#how" class="nav__link">How it works</a>
                <a href="#pricing" class="nav__link">Pricing</a>
            </div>
            <div class="nav__actions">
                <a href="{{ route('login') }}" class="btn btn--ghost">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn--primary">Get started free</a>
            </div>
            <button class="nav__burger" id="burger" aria-label="Toggle menu">
                <span></span><span></span><span></span>
            </button>
        </div>
        <div class="nav__mobile" id="mobileMenu">
            <a href="#features" class="nav__mobile-link">Features</a>
            <a href="#how" class="nav__mobile-link">How it works</a>
            <a href="#pricing" class="nav__mobile-link">Pricing</a>
            <a href="{{ route('login') }}" class="nav__mobile-link">Sign in</a>
            <a href="{{ route('register') }}" class="btn btn--primary nav__mobile-cta">Get started free</a>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="hero">
        <div class="hero__bg-grid"></div>
        <div class="hero__orb hero__orb--1"></div>
        <div class="hero__orb hero__orb--2"></div>

        <div class="container">
            <div class="hero__badge">
                <span class="hero__badge-dot"></span>
                Powered by Claude &amp; GPT-4
            </div>
            <h1 class="hero__headline">
                Write less.<br/>
                <span class="hero__headline-accent">Create more.</span>
            </h1>
            <p class="hero__subheadline">
                Generate marketing copy, email campaigns, blog posts, and social media content — in seconds. Just describe what you need.
            </p>
            <div class="hero__actions">
                <a href="{{ route('register') }}" class="btn btn--primary btn--lg">
                    Start generating free
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <a href="#demo" class="btn btn--outline btn--lg">See a demo</a>
            </div>
            <p class="hero__footnote">No credit card required · Free 20 generations/month</p>
        </div>

        {{-- Floating content preview card --}}
        <div class="hero__preview container">
            <div class="preview-card" id="previewCard">
                <div class="preview-card__header">
                    <div class="preview-card__dots">
                        <span></span><span></span><span></span>
                    </div>
                    <span class="preview-card__label">Live preview</span>
                </div>
                <div class="preview-card__form">
                    <div class="preview-card__field">
                        <label>Content type</label>
                        <div class="preview-card__pill">Email Newsletter</div>
                    </div>
                    <div class="preview-card__field">
                        <label>Topic</label>
                        <div class="preview-card__pill">Summer sale announcement</div>
                    </div>
                    <div class="preview-card__field">
                        <label>Tone</label>
                        <div class="preview-card__pill">Persuasive &amp; friendly</div>
                    </div>
                </div>
                <div class="preview-card__output" id="outputArea">
                    <div class="preview-card__output-label">Generated content</div>
                    <div class="preview-card__typing" id="typingOutput"></div>
                    <div class="preview-card__cursor" id="cursor">|</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="stats">
        <div class="container">
            <div class="stats__grid">
                <div class="stats__item">
                    <span class="stats__number" data-count="50000">0</span>
                    <span class="stats__label">Pieces generated</span>
                </div>
                <div class="stats__item">
                    <span class="stats__number" data-count="8">0</span>
                    <span class="stats__label">Content types</span>
                </div>
                <div class="stats__item">
                    <span class="stats__number" data-count="3200">0</span>
                    <span class="stats__label">Active users</span>
                </div>
                <div class="stats__item">
                    <span class="stats__number" data-count="98">0</span>
                    <span class="stats__suffix">%</span>
                    <span class="stats__label">Satisfaction rate</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="features" id="features">
        <div class="container">
            <div class="section-header">
                <p class="section-eyebrow">What we offer</p>
                <h2 class="section-title">Everything you need to write smarter</h2>
                <p class="section-subtitle">From a quick social post to a full email campaign — Inkraft handles every content format your brand needs.</p>
            </div>
            <div class="features__grid">
                <div class="feature-card feature-card--accent">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="feature-card__title">8 Content Types</h3>
                    <p class="feature-card__desc">Blog posts, ad copy, emails, social media, product descriptions, press releases, landing pages, and scripts — all in one place.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/><path d="M12 8v4l3 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="feature-card__title">Instant Generation</h3>
                    <p class="feature-card__desc">Get publish-ready content in under 10 seconds. No waiting, no re-prompting — just results.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="feature-card__title">Audience Targeting</h3>
                    <p class="feature-card__desc">Specify your target audience and let AI craft messaging that resonates — not just fills a template.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    </div>
                    <h3 class="feature-card__title">Tone Control</h3>
                    <p class="feature-card__desc">Formal, casual, persuasive, witty, empathetic — set the exact voice that matches your brand personality.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><rect x="3" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="3" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="3" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/><rect x="14" y="14" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.5"/></svg>
                    </div>
                    <h3 class="feature-card__title">Generation History</h3>
                    <p class="feature-card__desc">Every piece is saved. Search, revisit, and rebuild from your past generations — your creative library grows with you.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="feature-card__title">Copy &amp; Export</h3>
                    <p class="feature-card__desc">One-click copy to clipboard or download as a .txt file — ready to paste anywhere instantly.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works --}}
    <section class="how" id="how">
        <div class="container">
            <div class="section-header">
                <p class="section-eyebrow">Process</p>
                <h2 class="section-title">From idea to content in 3 steps</h2>
            </div>
            <div class="steps">
                <div class="step">
                    <div class="step__number">01</div>
                    <div class="step__content">
                        <h3 class="step__title">Describe your need</h3>
                        <p class="step__desc">Choose a content type, enter your topic, add keywords, and define your audience and tone. Takes about 30 seconds.</p>
                    </div>
                </div>
                <div class="step__connector">
                    <svg width="40" height="2" viewBox="0 0 40 2"><path d="M0 1h40" stroke="currentColor" stroke-width="1" stroke-dasharray="4 3"/></svg>
                </div>
                <div class="step">
                    <div class="step__number">02</div>
                    <div class="step__content">
                        <h3 class="step__title">AI does the work</h3>
                        <p class="step__desc">Our engine sends your input to a powerful LLM and generates tailored, high-quality content — in real time.</p>
                    </div>
                </div>
                <div class="step__connector">
                    <svg width="40" height="2" viewBox="0 0 40 2"><path d="M0 1h40" stroke="currentColor" stroke-width="1" stroke-dasharray="4 3"/></svg>
                </div>
                <div class="step">
                    <div class="step__number">03</div>
                    <div class="step__content">
                        <h3 class="step__title">Copy, export, publish</h3>
                        <p class="step__desc">Copy to clipboard or download as .txt. Your content is also saved to your personal history for future reference.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Content Types Showcase --}}
    <section class="content-types">
        <div class="container">
            <div class="section-header">
                <p class="section-eyebrow">Supported formats</p>
                <h2 class="section-title">One tool, every content format</h2>
            </div>
            <div class="types-grid">
                <div class="type-pill type-pill--active">📧 Email Newsletter</div>
                <div class="type-pill">📝 Blog Post</div>
                <div class="type-pill">📣 Ad Copy</div>
                <div class="type-pill">📱 Social Media</div>
                <div class="type-pill">🛍 Product Description</div>
                <div class="type-pill">📰 Press Release</div>
                <div class="type-pill">🎯 Landing Page</div>
                <div class="type-pill">🎬 Video Script</div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="cta" id="pricing">
        <div class="container">
            <div class="cta__inner">
                <div class="cta__badge">Free to start</div>
                <h2 class="cta__title">Start creating content today</h2>
                <p class="cta__subtitle">20 free generations per month. No credit card. No commitment. Cancel anytime.</p>
                <a href="{{ route('register') }}" class="btn btn--white btn--lg">
                    Create free account
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="footer__inner">
                <div class="footer__brand">
                    <a href="/" class="nav__logo">
                        <span class="nav__logo-mark">✦</span>
                        <span class="nav__logo-text">Inkraft</span>
                    </a>
                    <p class="footer__tagline">AI-powered content generation for modern teams.</p>
                </div>
                <div class="footer__links">
                    <div class="footer__col">
                        <span class="footer__col-title">Product</span>
                        <a href="#features">Features</a>
                        <a href="#how">How it works</a>
                        <a href="#pricing">Pricing</a>
                    </div>
                    <div class="footer__col">
                        <span class="footer__col-title">Account</span>
                        <a href="{{ route('login') }}">Sign in</a>
                        <a href="{{ route('register') }}">Register</a>
                    </div>
                </div>
            </div>
            <div class="footer__bottom">
                <p>&copy; {{ date('Y') }} Inkraft. Built with Laravel &amp; Vite.</p>
            </div>
        </div>
    </footer>

</body>
</html>