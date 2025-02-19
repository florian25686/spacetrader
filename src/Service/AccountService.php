<?php
declare(strict_types=1);

namespace App\Service;

class AccountService
{
    public function getAccountToken(): string
    {
        return $_ENV['ACCOUNT_TOKEN'];
    }

    public function setAccountToken(string $token): void
    {
        // This function will ask the user for input and stores the token in a permanent storage
        // e.g. a database
    }
}
