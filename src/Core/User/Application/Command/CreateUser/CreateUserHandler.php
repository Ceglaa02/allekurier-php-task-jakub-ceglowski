<?php

namespace App\Core\User\Application\Command\CreateUser;

use App\Common\Mailer\SMPTMailer;
use App\Core\Invoice\Application\Command\CreateInvoice\CreateInvoiceCommand;
use App\Core\Invoice\Infrastructure\Notification\Email\Mailer;
use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateUserHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly EventDispatcherInterface $eventDispatcher,
    ){}

    public function __invoke(CreateUserCommand $command): void
    {
        $email = $command->email;

        $this->userRepository->save(new User($email));
        $this->userRepository->flush();

        $this->eventDispatcher->dispatch(new UserCreatedEvent($this->userRepository->getByEmail($email)));
    }
}