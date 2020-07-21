<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Project;
use App\Entity\Metric;
use App\Entity\ProjectMetric;

class IngestPHPCSCommand extends AbstractImportCommand
{
    protected static $defaultName = 'app:ingest:phpcs';

    private $file;
	private $project;

    protected function configure()
    {
        $this
            ->setDescription('Ingère le fichier PHPCS d\'un projet pour calculer les métriques et les enregistrer en base.')
            ->setHelp('Ingère le fichier PHPCS d\'un projet pour calculer les métriques et les enregistrer en base. Requiert un fichier phpcs et le code du projet')
            ->addArgument('file', InputArgument::REQUIRED, 'chemin du fichier PHPCS')
            ->addArgument('projectCode', InputArgument::REQUIRED, 'Code projet')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		parent::execute($input, $output);

    	$this->file = $this->projectDir . '/' . $input->getArgument('file');

		$this->io->title('Vérification du fichier');

		if (!$this->isFileExist($this->file)) {
            $this->io->error('Fichier `' . $this->file . '` inexistant.');
            return Command::FAILURE;
		}
		
		$this->io->text('Fichiers présent');

		// TODO : Créer un abstract Ingest ????
		$this->io->title('Vérification du projet');
		
		$this->project = $this->em->getRepository(Project::class)->findOneByCode($input->getArgument('projectCode'));

		if (!$this->project instanceof Project) {
            $this->io->error('Code Projet `' . $input->getArgument('projectCode') . '` ne correspond à aucun projet.');
            return Command::FAILURE;
		}
		
		$this->io->text('Projet ' . $this->projectCode . ' OK');

		$this->io->title('Traitement du fichier');
////////////////////////////////////////////////////////
// TODO : Créer le serializer en fonction du type de fichier
		$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		$this->import($serializer, $this->file, Metric::class);

		$this->io->success('Import terminé.');
        return Command::SUCCESS;
    }

// TODO : Créer un ImportCommandInterface contenant cette méthode. ATTENTION j'ai aps tjr le même nombre d'attribut, ça pose un soucis ??
	protected function import($serializer, $file, $class)
	{
		$metric = $this->em->getRepository($class)->findOneByName('Checkstyle');

		if (!$metric instanceof Metric) {
            $this->io->error('La métrique PHPMD n\'existe pas. Veuillez contacter l\'administrateur');

			return Command::FAILURE;
		}

		// TODO : Créer un service qui prend en entrée le fichier et retourne en sortie value + Tag. (Value + tag est-ce un modèle à créer ?????
		$projectMetric = new ProjectMetric();
		$projectMetric->setValue();
		$projectMetric->setTag();
		$projectMetric->setMetric($metric);
		$projectMetric->setProject($this->project);
		$this->io->text('Import du fichier ' . $file . ' terminé.');
		
		$this->em->persist($projectMetric);
		$this->em->flush();
	}
}