<?php

declare(strict_types=1);

require dirname(__DIR__) . '/src/bootstrap.php';

$user = require_login();

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

    $errors = validate_profile($input);

    if ($errors === []) {
        $updated = update_user_profile((int) $user['id'], $input['username'], $input['email']);

        if (!$updated) {
            $errors['email'] = 'That email address is already in use.';
        } else {
            if ($input['password'] !== '') {
                update_user_password((int) $user['id'], $input['password']);
                session_regenerate_id(true);
            }

            flash('success', 'Your profile has been updated.');
            redirect('dashboard.php');
        }
    }

    flash('errors', $errors);
    flash('old', ['username' => $input['username'], 'email' => $input['email']]);
    redirect('profile.php');
}

$pageTitle = 'Your profile';
require BASE_PATH . '/src/views/header.php';
?>

<h1>Your profile</h1>

<form action="profile.php" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" type="text"
            value="<?= e($old['username'] ?? $user['username']) ?>"
            autocomplete="username" required>
        <?php if (isset($errors['username'])): ?>
            <p class="field__error"><?= e($errors['username']) ?></p>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email"
            value="<?= e($old['email'] ?? $user['email']) ?>"
            autocomplete="email" required>
        <?php if (isset($errors['email'])): ?>
            <p class="field__error"><?= e($errors['email']) ?></p>
        <?php endif; ?>
    </div>

    <fieldset class="fieldset">
        <legend>Change your password</legend>
        <p class="field__hint">Leave both fields empty to keep your current password.</p>

        <div class="field">
            <label for="password">New password</label>
            <input id="password" name="password" type="password" autocomplete="new-password">
            <?php if (isset($errors['password'])): ?>
                <p class="field__error"><?= e($errors['password']) ?></p>
            <?php endif; ?>
        </div>

        <div class="field">
            <label for="confirm_password">Confirm new password</label>
            <input id="confirm_password" name="confirm_password" type="password"
                autocomplete="new-password">
            <?php if (isset($errors['confirm_password'])): ?>
                <p class="field__error"><?= e($errors['confirm_password']) ?></p>
            <?php endif; ?>
        </div>
    </fieldset>

    <button type="submit">Save changes</button>
</form>

<?php require BASE_PATH . '/src/views/footer.php'; ?>