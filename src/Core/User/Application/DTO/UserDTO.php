<?php

namespace App\Core\User\Application\DTO;

class UserDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $email,
    )
    {
    }
}