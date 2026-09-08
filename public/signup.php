<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

require_guest();

$errors = flash('errors') ?? [];
$old = flash('old') ?? [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    csrf_verify();

    $input = [
        'username'         => trim($_POST['username'] ?? ''),
        'email'            => trim($_POST['email'] ?? ''),
        'password'         => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
    ];

    $errors = validate_signup($input);

    if ($errors === []) {
        $userId = create_user($input['username'], $input['email'], $input['password']);

        if ($userId === null) {
            $errors['email'] = 'That email address is already registered.';
        } else {
            flash('success', 'Account created. Log in to continue.');
            redirect('login.php');
        }
    }

    flash('errors', $errors);
    flash('old', ['username' => $input['username'], 'email' => $input['email']]);
    redirect('signup.php');
}

$pageTitle = 'Create an account';
$layout = 'auth';
require BASE_PATH . '/src/views/header.php';
?>

<div class="panel">
    <h1>Sign up</h1>
    <hr class="panel__rule">

    <form action="signup.php" method="post" novalidate>
        <?= csrf_field() ?>

        <div class="field">
            <label for="username">Username</label>
            <input id="username" name="username" type="text" placeholder="Your name"
                value="<?= e($old['username'] ?? '') ?>" autocomplete="username" required>
            <?php if (isset($errors['username'])): ?>
                <p class="field__error"><?= e($errors['username']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="email">Email address</label>
            <input id="email" name="email" type="email" placeholder="you@example.com"
                value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required>
            <?php if (isset($errors['email'])): ?>
                <p class="field__error"><?= e($errors['email']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="••••••••"
                autocomplete="new-password" required>
            <p class="field__hint">At least 8 characters.</p>
            <?php if (isset($errors['password'])): ?>
                <p class="field__error"><?= e($errors['password']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="confirm_password">Confirm password</label>
            <input id="confirm_password" name="confirm_password" type="password"
                placeholder="••••••••" autocomplete="new-password" required>
            <?php if (isset($errors['confirm_password'])): ?>
                <p class="field__error"><?= e($errors['confirm_password']) ?></p>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button class="button button--block" type="submit">Create account</button>
        </div>
    </form>

    <p class="panel__aside">Already have an account? <a href="login.php">Log in</a></p>
</div>

<?php require BASE_PATH . '/src/views/footer.php'; ?>