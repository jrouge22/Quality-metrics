<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\LockableTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class AbstractImportCommand extends Command
{
    use LockableTrait;

	protected $projectDir;
	protected $em;

	protected $io;
	protected $fileSystem;

	public function __construct(EntityManagerInterface $entityManager, KernelInterface $kernel)
    {
        $this->em = $entityManager;
        $this->projectDir = $kernel->getProjectDir();
		$this->fileSystem = new Filesystem();

        parent::__construct();
    }
	

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io = new SymfonyStyle($input, $output);
	}

	protected function isLock()
	{
        if (!$this->lock()) {
            $this->io->caution('La commande est déjà lancé par un autre process. Attendez la fin du process déjà en cours pour relancer la commande si besoin.');

            return Command::SUCCESS;
        }
	}

	protected function isFileExist($file)
	{
		if ($this->fileSystem->exists($file)) {
			return true;
		}
		
		return false;
	}
}