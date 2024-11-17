<?php

namespace App\Core\User\UserInterface\Cli;

use App\Common\Bus\QueryBusInterface;
use App\Core\User\Application\DTO\UserDTO;
use App\Core\User\Application\Query\GetNoActiveUsersEmails\GetNoActiveUsersEmailsQuery;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:get:noactive:emails',
    description: 'Pobieranie maili nie aktywnych użytkowników'
)]
class GetNoActiveUsersEmails extends Command
{
    public function __construct(private readonly QueryBusInterface $bus)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $noActiveUsers = $this->bus->dispatch(new GetNoActiveUsersEmailsQuery());

        /** @var UserDTO $noActiveUser */
        foreach ($noActiveUsers as $noActiveUser) {
            $output->writeln($noActiveUser->email);
        }

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
    }
}