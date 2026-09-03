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

const DUMMY_PASSWORD_HASH = '$2y$12$0e0Vm4gwtUPxrM33AMiBe.P1nWnMSVCd5twAZ9D2POf50ofKVhycW
';

function find_user_by_email(string $email): ?array
{
    $statement = db()->prepare(
        'SELECT id, username, email, password_hash
         FROM users
         WHERE email = :email
         LIMIT 1'
    );

    $statement->execute(['email' => $email]);

    $user = $statement->fetch();

    return $user === false ? null : $user;
}

function find_user_by_id(int $id): ?array
{
    $statement = db()->prepare(
        'SELECT id, username, email, created_at
         FROM users
         WHERE id = :id
         LIMIT 1'
    );

    $statement->execute(['id' => $id]);

    $user = $statement->fetch();

    return $user === false ? null : $user;
}
