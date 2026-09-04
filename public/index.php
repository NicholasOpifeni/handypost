<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$pageTitle = 'Guardpost';
require BASE_PATH . '/src/views/header.php';
?>

<div class="hero">
    <h1>Authentication, built carefully.</h1>
    <p class="hero__lede">
        A small PHP application demonstrating password hashing, prepared statements,
        CSRF protection and session hardening — written from scratch, without a framework.
    </p>

    <?php if (is_logged_in()): ?>
        <a class="button" href="dashboard.php">Go to your dashboard</a>
    <?php else: ?>
        <a class="button" href="signup.php">Create an account</a>
        <a class="button button--quiet" href="login.php">Log in</a>
    <?php endif; ?>
</div>

<section class="notes">
    <h2>What this project demonstrates</h2>
    <ul>
        <li>Every query is a prepared statement with emulation disabled.</li>
        <li>Passwords are hashed with bcrypt; the hash never leaves the server.</li>
        <li>Session IDs are regenerated at login and on password change.</li>
        <li>All state-changing requests carry a CSRF token.</li>
        <li>All output is escaped at the point of rendering.</li>
        <li>Login responses are identical whether or not the account exists.</li>
    </ul>
</section>

<?php require BASE_PATH . '/src/views/footer.php'; ?>