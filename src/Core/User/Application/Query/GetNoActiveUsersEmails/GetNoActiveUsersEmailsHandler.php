<?php

namespace App\Core\User\Application\Query\GetNoActiveUsersEmails;

use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\User;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetNoActiveUsersEmailsHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    )
    {
    }

    public function __invoke(GetNoActiveUsersEmailsQuery $query): array
    {
        $noActiveUsers = $this->userRepository->getNoActiveUsers();

        return array_map(function (User $noActiveUser) {
            return new UserDTO(
                $noActiveUser->getId(),
                $noActiveUser->getEmail(),
            );

        }, $noActiveUsers);
    }
}