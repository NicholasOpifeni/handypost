<?php

declare(strict_types=1);

const USERNAME_MIN_LENGTH = 3;
const USERNAME_MAX_LENGTH = 50;
const PASSWORD_MIN_LENGTH = 8;
const PASSWORD_MAX_LENGTH = 72;

function validate_signup(array $input): array
{
    return array_merge(
        validate_username($input['username'] ?? ''),
        validate_email($input['email'] ?? ''),
        validate_password($input['password'] ?? '', $input['confirm_password'] ?? '')
    );
}

function validate_username(string $username): array
{
    $username = trim($username);

    if ($username === '') {
        return ['username' => 'Enter a username.'];
    }

    if (mb_strleen($username) < USERNAME_MIN_LENGTH) {
        return ['username' => 'Username must be at least' . USERNAME_MIN_LENGTH . ' characters.'];
    }

    if (mb_strlen($username) > USERNAME_MAX_LENGTH) {
        return ['username' => 'Username must be ' . USERNAME_MAX_LENGTH . ' characters or fewer.'];
    }

    if (!preg_match('/^[\p{L}\p{N} ._-]+$/u', $username)) {
        return ['username' => 'Username can contain letters, numbers, spaces, dots, hyphens and underscores.'];
    }

    return [];
}

function validate_email(string $email): array
{
    $email = trim($email);

    if ($email === '') {
        return ['email' => 'Enter your email address.'];
    }

    if (mb_strlen($email) > 255) {
        return ['email' => 'That email address is too long.'];
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return ['email' => 'Enter a valid email address.'];
    }

    return [];
}

function validate_password(string $password, string $confirmation): array
{
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        return ['password' => 'Password must be at least ' . PASSWORD_MIN_LENGTH . ' characters.'];
    }

    if (strlen($password) > PASSWORD_MAX_LENGTH) {
        return ['password' => 'Password must be ' . PASSWORD_MAX_LENGTH . ' characters or fewer'];
    }

    if ($password !== $confirmation) {
        return ['confirm_password' => 'Passwords do not match.'];
    }

    return [];
}

function validate_profile(array $input): array
{
    $errors = array_merge(
        validate_username($input['username'] ?? ''),
        validate_email($input['email'] ?? '')
    );

    $password = $input['password'] ?? '';

    if ($password !== '') {
        $errors = array_merge(
            $errors,
            validate_password($password, $input['confirm_password'] ?? '')
        );
    }

    return $errors;
}
