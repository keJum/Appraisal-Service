<?php

namespace App\Command;

use App\Dto\UserDto;
use App\Exception\ValidateException;
use App\Factory\UserFactory;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'service:user-create',
    description: 'Создать нового пользователя',
)]
class ServiceUserCreateCommand extends Command
{
    public function __construct(
        private readonly UserFactory $userFactory
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'Email for new created user')
        ;
    }

    /**
     * @throws ValidateException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');

        $helper = $this->getHelper('question');
        $question = new Question('Введите пароль: ');
        $question->setHidden(true);
        $question->setValidator(function ($value) {
            if (empty($value)) {
                throw new RuntimeException('Пароль не может быть пустым.');
            }
            return $value;
        });

        $password = $helper->ask($input, $output, $question);

        $output->writeln('Пароль введён.');

        $this->userFactory->createOrChange(new UserDto($email, $password));

        $io->success('Данные по пользователям обновлены');

        return Command::SUCCESS;
    }
}
