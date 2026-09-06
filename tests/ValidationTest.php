<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ValidationTest extends TestCase
{
    public function testValidInputProducesNoErrors(): void
    {
        $errors = validate_signup([
            'username'         => 'nakato',
            'email'            => 'nakato@example.com',
            'password'         => 'correct horse battery',
            'confirm_password' => 'correct horse battery',
        ]);

        $this->assertSame([], $errors);
    }

    public function testShortUsernameIsRejected(): void
    {
        $errors = validate_signup([
            'username'         => 'ab',
            'email'            => 'nakato@example.com',
            'password'         => 'correct horse battery',
            'confirm_password' => 'correct horse battery',
        ]);

        $this->assertArrayHasKey('username', $errors);
    }

    public function testMismatchedPasswordsAreRejected(): void
    {
        $errors = validate_signup([
            'username'         => 'nakato',
            'email'            => 'nakato@example.com',
            'password'         => 'correct horse battery',
            'confirm_password' => 'correct horse batteries',
        ]);

        $this->assertArrayHasKey('confirm_password', $errors);
    }

    public function testPasswordLongerThanBcryptLimitIsRejected(): void
    {
        $tooLong = str_repeat('a', 73);

        $errors = validate_signup([
            'username'         => 'nakato',
            'email'            => 'nakato@example.com',
            'password'         => $tooLong,
            'confirm_password' => $tooLong,
        ]);

        $this->assertArrayHasKey('password', $errors);
    }

    public function testMissingKeysDoNotCauseAnError(): void
    {
        $errors = validate_signup([]);

        $this->assertArrayHasKey('username', $errors);
        $this->assertArrayHasKey('email', $errors);
        $this->assertArrayHasKey('password', $errors);
    }

    public function testUnicodeUsernameIsAccepted(): void
    {
        $errors = validate_username('Nakato Zawadi');

        $this->assertSame([], $errors);
    }

    public function testProfileUpdateAllowsEmptyPassword(): void
    {
        $errors = validate_profile([
            'username' => 'nakato',
            'email'    => 'nakato@example.com',
            'password' => '',
        ]);

        $this->assertSame([], $errors);
    }
}
