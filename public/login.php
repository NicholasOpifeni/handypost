<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$errors = flash('errors') ?? [];
$old = flash('old') ?? [];
$success = flash('success');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $user = find_user_by_email($email);

    $hash = $user['password_hash'] ?? DUMMY_PASSWORD_HASH;
    $passwordMatches = password_verify($password, $hash);

    if ($user === null || !$passwordMatches) {
        flash('errors', ['form' => 'Invalid email or password.']);
        flash('old', ['email' => $email]);
        redirect('login.php');
    }

    login_user($user);
    redirect('dashboard.php');
}

$pageTitle = 'Log in';
require BASE_PATH . '/src/views/header.php';
?>

<h1>Log in</h1>

<?php if ($success !== null): ?>
    <p class="notice notice--good"><?= e($success) ?></p>
<?php endif; ?>

<?php if (isset($errors['form'])): ?>
    <p class="notice notice--bad"><?= e($errors['form']) ?></p>
<?php endif; ?>

<form action="login.php" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email"
            value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required>
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="current-password" required>
    </div>

    <button type="submit">Log in</button>
</form>

<p><a href="signup.php">No account yet? Create one</a></p>

<?php require BASE_PATH . '/src/views/footer.php'; ?>