<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Core\Invoice\Application\Command\CreateInvoice\CreateInvoiceCommand;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(private readonly UserRepositoryInterface $userRepository){}

    public function __invoke(CreateUserCommand $command): void
    {
        $this->userRepository->save(new User($command->email));
        $this->userRepository->flush();
    }
}