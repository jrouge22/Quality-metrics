<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\Project;

// TODO : A voir mais apriori pas utile cet abstract car on a pas besoin de EM notamment
class IngestAllCommand extends AbstractImportCommand
{
    protected static $defaultName = 'app:ingest:all';

    protected function configure()
    {
        $this
            ->setDescription('Ingère les fichiers des métriques de tout les projets')
            ->setHelp('Ingère les fichiers des métriques de tout les projets')
        ;
    }

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);
		
		$this->io->title('Ingestion de toutes les métriques des projets');

		$projects = $this->em->getRepository(Project::class)->findAll();

        $this->io->progressStart(count($projects));

		foreach ($projects as $project) {
			$command = $this->getApplication()->find('app:ingest:metrics-project');

			$arguments = [
				'--yell'  => true,
			];

			$result = $command->run(new ArrayInput($arguments), $output);
			
			if (!$result) {
				$this->io->caution('Erreur lors de l\ingestion du projet ' . $project->getName());
			}
			
            $this->io->progressAdvance();
		}

        $this->io->progressFinish();

		return Command::SUCCESS;
	}
}