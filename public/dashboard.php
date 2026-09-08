<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$user = require_login();

$success = flash('success');

$pageTitle = 'Dashboard';
require BASE_PATH . '/src/views/header.php';
?>

<div class="welcome">
    <h1>Welcome <?= e($user['username']) ?>!</h1>
    <p>You're signed in to Handypost.</p>
</div>

<?php if ($success !== null): ?>
    <p class="notice notice--good"><?= e($success) ?></p>
<?php endif; ?>

<div class="panel">
    <dl class="detail-list">
        <div>
            <dt>Username</dt>
            <dd><?= e($user['username']) ?></dd>
        </div>

        <div>
            <dt>Email address</dt>
            <dd><?= e($user['email']) ?></dd>
        </div>

        <div>
            <dt>Member since</dt>
            <dd><?= e(date('j F Y', strtotime((string) $user['created_at']))) ?></dd>
        </div>
    </dl>

    <a class="button" href="profile.php">Change profile</a>
</div>

<?php require BASE_PATH . '/src/views/footer.php'; ?>