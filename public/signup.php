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

$success = flash('success');

$pageTitle = 'Create an account';
require BASE_PATH . '/src/views/header.php';
?>

<h1>Create an account</h1>

<?php if ($success !== null): ?>
    <p class="notice notice--good"><?= e($success) ?></p>
<?php endif; ?>

<form action="signup.php" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text"
            value="<?= e($old['username'] ?? '') ?>" autocomplete="username" required>
        <?php if (isset($errors['username'])): ?>
            <p class="field__error"><?= e($errors['username']) ?></p>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email"
            value="<?= e($old['email'] ?? '') ?>" autocomplete="email" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field__error"><?= e($errors['email']) ?></p>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" autocomplete="new-password" required>
        <p class="field__hint">At least 8 characters.</p>
        <?php if (isset($errors['password'])): ?>
            <p class="field__error"><?= e($errors['password']) ?></p>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="confirm_password">Confirm password</label>
        <input id="confirm_password" name="confirm_password" type="password"
            autocomplete="new-password" required>
        <?php if (isset($errors['confirm_password'])): ?>
            <p class="field__error"><?= e($errors['confirm_password']) ?></p>
        <?php endif; ?>
    </div>

    <button type="submit">Create account</button>
</form>

<p><a href="login.php">Already have an account?</a></p>

<?php require BASE_PATH . '/src/views/footer.php'; ?>