<?php

declare(strict_types=1);

$pageTitle = $pageTitle ?? 'handypost';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device=width, initial-scale=1">
    <title><?= e($pageTitle) ?></title>
</head>

<body>
    <header class="masthead">
        <a class="masthead__mark" href="index.php">Guardpost</a>

        <nav class="masthead__nav">
            <?php if ($navUser !== null): ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="profile.php">Profile</a>
                <form class="inline-form" action="logout.php" method="post">
                    <?= csrf_field() ?>
                    <button class="link-button" type="submit">Log out</button>
                </form>
            <?php else: ?>
                <a href="login.php">Log in</a>
                <a href="signup.php">Sign up</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="page"></main>
</body>

</html>