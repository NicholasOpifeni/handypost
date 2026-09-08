<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? 'Handypost';
$layout = $layout ?? 'default';
$navUser = current_user();
$currentPage = basename($_SERVER['SCRIPT_NAME']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($pageTitle) ?> — Handypost</title>
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="layout-<?= e($layout) ?>">

    <?php if ($layout !== 'auth'): ?>
        <header class="masthead">
            <a class="masthead__mark" href="index.php">
                <span class="masthead__dot">H</span>
                Handypost
            </a>

            <nav class="masthead__nav">
                <a class="<?= $currentPage === 'index.php' ? 'is-current' : '' ?>" href="index.php">Home</a>
                <a class="<?= $currentPage === 'about.php' ? 'is-current' : '' ?>" href="about.php">About</a>
                <a class="<?= $currentPage === 'contact.php' ? 'is-current' : '' ?>" href="contact.php">Contact</a>

                <?php if ($navUser !== null): ?>
                    <details class="usermenu">
                        <summary class="usermenu__trigger">
                            <span class="usermenu__avatar"><?= e(mb_strtoupper(mb_substr($navUser['username'], 0, 1))) ?></span>
                            <span class="usermenu__caret"></span>
                        </summary>

                        <div class="usermenu__panel">
                            <p class="usermenu__who"><?= e($navUser['username']) ?></p>
                            <a href="dashboard.php">Dashboard</a>
                            <a href="profile.php">Change Profile</a>
                            <form action="logout.php" method="post">
                                <?= csrf_field() ?>
                                <button class="usermenu__logout" type="submit">Logout</button>
                            </form>
                        </div>
                    </details>
                <?php else: ?>
                    <a href="login.php">Login</a>
                    <a class="masthead__cta" href="signup.php">Signup</a>
                <?php endif; ?>
            </nav>
        </header>
    <?php endif; ?>

    <main class="shell<?= $layout === 'landing' ? '' : ' page' ?>">
        <?php if ($layout === 'auth'): ?>
            <a class="auth-brand" href="index.php">Handypost</a>
        <?php endif; ?>