<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\Project;

class IngestMetricsProjectCommand extends AbstractImportCommand
{
    protected static $defaultName = 'app:ingest:metrics-project';

	private $projectCode;
	private $project;
	private $metricsPath;

    protected function configure()
    {
        $this
            ->setDescription('Ingère les fichiers des métriques d\'un projet')
            ->setHelp('Ingère les fichiers des métriques d\'un projet. Requiert le code du projet')
            ->addArgument('projectCode', InputArgument::REQUIRED, 'Code projet')
        ;
    }

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		parent::execute($input, $output);
		
		$this->io->title('Ingestion de toutes les métriques du projet');
		
		$this->projectCode = $input->getArgument('projectCode');
		$this->project = $this->em->getRepository(Project::class)->findOneByCode($this->projectCode);

		if (!$this->project instanceof Project) {
            $this->io->error('Code Projet `' . $this->projectCode . '` ne correspond à aucun projet.');
            return Command::FAILURE;
		}
		
		$this->metricsPath = 'metricsFiles/' . $this->projectCode;

		// TODO : Ici il faudra récupérer les métriques du projet et lancer les bon import en fonction
		$metrics = $this->project->getProjectMetrics();
        $this->io->progressStart(count($metrics));

		foreach ($metrics as $metric) {
			$returnCommand = $this->executeMetricCommand($metric->getName());
			$this->io->progressAdvance();
		}

        $this->io->progressFinish();

		// On considère un succès si au moins une des commande est SUCCESS
		if ($returnCodeCs || $returnCodePhpmd) {
			return Command::SUCCESS;
		}
		
		return Command::FAILURE;
		// ...
	}

	private function executeMetricCommand($metricName)
	{
		// TODO : Créer quelquepart une liste de contante contenant le nom des métriques. Dans l'entitée ? Ailleurs ?
		if ($metricName === 'phpcs') {
			return $this->phpcsCommand();
		}
		
		if ($metric->getName() === 'phpmd') {
			return $this->phpmdCommand();
		}
		
		return false;
	}

	private function phpcsCommand()
	{
		$this->io->text('Ingestion des métriques PHPCS');
		// TODO : Vérifier le nom du fichier et définir le répertoire ou l'on va le placer si ça ne convient pas
		return $this->metricCommand('app:ingest:phpcs', '/phpcs.xml');
	}

	private function phpmdCommand()
	{
		$this->io->text('Ingestion des métriques PHPMD');
		// TODO : Vérifier le nom du fichier et définir le répertoire ou l'on va le placer si ça ne convient pas
		return $this->metricCommand('app:ingest:phpmd', '/phpmd.xml');
	}
	

	private function metricCommand($command, $file)
	{
		$command = $this->getApplication()->find($command);

		$file = $this->metricsPath . $file;

		$arguments = [
			'file'    => $file,
			'projectCode' => $this->projectCode,
			'--yell'  => true
		];

		return $command->run(new ArrayInput($arguments), $output);
	}
}