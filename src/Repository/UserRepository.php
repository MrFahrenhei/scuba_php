<?php

namespace ScubaPHP\Repository;

class UserRepository
{
    public function __construct(private string $file)
    {
    }

    public function readAll(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $users = json_decode(file_get_contents($this->file), true);

        return is_array($users) ? $users : [];
    }

    public function findByEmail(string $email): array|false
    {
        foreach ($this->readAll() as $user) {
            if (strtolower($user['email']) === strtolower($email)) {
                return $user;
            }
        }

        return false;
    }

    public function create(array $user): void
    {
        $users = $this->readAll();
        $users[] = $user;

        file_put_contents($this->file, json_encode($users, JSON_PRETTY_PRINT));
    }
}
