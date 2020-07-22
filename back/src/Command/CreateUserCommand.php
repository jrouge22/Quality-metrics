<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\UserRepository;
use App\Entity\User;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:user:create';

    private $userRepository;

    protected function configure()
    {
        $this
            ->setDescription('Créer un utilisateur.')
            ->setHelp('Créer un nouvel utilisateur. Requiert email, mot de passe et role.')
            ->addArgument('email', InputArgument::REQUIRED, 'Email de l\'utilisateur')
            ->addArgument('password', InputArgument::REQUIRED, 'Mot de passe de l\'utilisateur')
			->addArgument('roles', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, 'Role de l\'utilisateur');
    }


	public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
		
		$io->title('Création d\'un utilisateur');
		
		$inputRoles = $input->getArgument('roles');
		$roles = ['ROLE_USER'];

		if ($inputRoles) {
			$roles = array_merge($inputRoles, $roles);
		}

        $user = $this->userRepository->createNewUser(
			$input->getArgument('email'),
			$input->getArgument('password'),
			$roles
		);
		
		if (!$user instanceof User) {
			$io->error('Echec lors de la création de l\'utilisateur.');
			
            return Command::FAILURE;
		}

		$io->success('Utilisateur ' . $user->getUsername() . ' Créé.');
		
        return Command::SUCCESS;
    }
}