<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$user = require_login();

$success = flash('success');

$pageTitle = 'Dashboard';
require BASE_PATH . '/src/views/header.php';
?>

<h1>Welcome back, <?= e($user['username']) ?></h1>

<?php if ($success !== null): ?>
    <p class="notice notice--good"><?= e($success) ?></p>
<?php endif; ?>

<dl class="detail-list">
    <dt>Username</dt>
    <dd><?= e($user['email']) ?></dd>

    <dt>Member since</dt>
    <dd><?= e(date('j F Y', strtotime((string) $user['created_at']))) ?></dd>
</dl>

<p><a href="profile.php">Edit your profile</a></p>

<?php require BASE_PATH . '/src/views/footer.php'; ?>