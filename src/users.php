<?php

declare(strict_types=1);

function create_user(string $username, string $email, string $password): ?int
{
    $statement = db()->prepare(
        'INSERT INTO users (username, email, password_hash)
         VALUES (:username, :email, :password_hash)'
    );

    try {
        $statement->execute([
            'username'      => $username,
            'email'         => $email,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);
    } catch (PDOException $exception) {
        if ($exception->getCode() === '23000') {
            return null;
        }

        throw $exception;
    }

    return (int) db()->lastInsertId();
}
