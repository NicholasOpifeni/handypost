<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$pageTitle = 'Secure accounts for small teams';
$layout = 'landing';
require BASE_PATH . '/src/views/header.php';
?>

<section class="hero">
    <div class="hero__inner">
        <div class="hero__copy">
            <h1>The Secure Sign-In You Really Want</h1>

            <p class="hero__lede">
                We handle accounts, passwords and sessions properly, so your team can
                spend its time on the product your customers actually came for.
            </p>

            <div class="hero__actions">
                <?php if (is_logged_in()): ?>
                    <a class="button button--accent" href="dashboard.php">Go to your dashboard</a>
                <?php else: ?>
                    <a class="button button--accent" href="signup.php">Get Started</a>
                    <a class="button button--ghost" href="about.php">How it works</a>
                <?php endif; ?>
            </div>
        </div>

        <svg class="hero__art" viewBox="0 0 560 440" xmlns="http://www.w3.org/2000/svg"
            role="img" aria-label="Illustration of a dashboard protected by a shield">
            <ellipse cx="280" cy="220" rx="252" ry="196" fill="rgba(255,255,255,0.07)" />

            <rect x="60" y="60" width="360" height="230" rx="14" fill="#ffffff" />
            <rect x="60" y="60" width="360" height="32" rx="14" fill="#dfe6ef" />
            <rect x="60" y="78" width="360" height="14" fill="#dfe6ef" />
            <circle cx="82" cy="76" r="5" fill="#eb9d4a" />
            <circle cx="100" cy="76" r="5" fill="#c3cddb" />
            <circle cx="118" cy="76" r="5" fill="#c3cddb" />

            <rect x="90" y="200" width="28" height="60" rx="5" fill="#ccd7e4" />
            <rect x="128" y="170" width="28" height="90" rx="5" fill="#ccd7e4" />
            <rect x="166" y="140" width="28" height="120" rx="5" fill="#eb9d4a" />
            <rect x="204" y="185" width="28" height="75" rx="5" fill="#ccd7e4" />

            <rect x="262" y="130" width="120" height="11" rx="5.5" fill="#dfe6ef" />
            <rect x="262" y="152" width="94" height="11" rx="5.5" fill="#dfe6ef" />
            <rect x="262" y="174" width="110" height="11" rx="5.5" fill="#dfe6ef" />
            <rect x="262" y="212" width="72" height="26" rx="13" fill="#2b8a80" />

            <rect x="222" y="290" width="36" height="34" fill="#17304d" />
            <rect x="170" y="322" width="140" height="13" rx="6.5" fill="#17304d" />

            <path d="M420 232 L490 258 V318 C490 360 462 388 420 402 C378 388 350 360 350 318 V258 Z"
                fill="#eb9d4a" />
            <circle cx="420" cy="302" r="17" fill="#17304d" />
            <path d="M412 312 L428 312 L433 350 L407 350 Z" fill="#17304d" />
        </svg>
    </div>
</section>

<section class="section">
    <div class="wrap">
        <div class="section__head">
            <p class="section__eyebrow">How it works</p>
            <h2>Three steps to a working account system</h2>
            <p class="section__lede">
                No SDK to learn and no vendor lock-in. Handypost is a small, readable
                PHP application you run yourself.
            </p>
        </div>

        <div class="cards">
            <article class="card">
                <div class="card__num">1</div>
                <h3>Create an account</h3>
                <p>Sign up with an email address and a password of at least eight
                    characters. Nothing else is collected.</p>
            </article>

            <article class="card">
                <div class="card__num">2</div>
                <h3>Sign in securely</h3>
                <p>Your session is issued a fresh identifier on every login, stored in
                    a cookie your browser's scripts cannot read.</p>
            </article>

            <article class="card">
                <div class="card__num">3</div>
                <h3>Manage your details</h3>
                <p>Update your name, email or password at any time from your profile.
                    Changing a password reissues your session.</p>
            </article>
        </div>
    </div>
</section>

<?php require BASE_PATH . '/src/views/footer.php'; ?>