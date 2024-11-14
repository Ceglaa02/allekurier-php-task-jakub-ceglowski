<?php

namespace App\Core\User\Application\Command\CreateUser;

class CreateUserCommand
{
    public function __construct(public readonly string $email)
    {}

}