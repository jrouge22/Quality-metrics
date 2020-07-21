<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use App\Entity\Metric;
use App\Entity\Techno;
use App\Entity\Version;

class InitializeSystemDataCommand extends AbstractImportCommand
{
    protected static $defaultName = 'app:data:initialize';

    private $metricFile;
	private $technoFile;

	private $technos = [];
	private $metrics = [];

    protected function configure()
    {
        $this
            ->setDescription('Initialise les données système.')
            ->setHelp('Initialise les données système (Technos, versions et métriques) à partir des 2 fichiers à placer dans le répertoire Data.')
            ->addArgument('metricFile', InputArgument::REQUIRED, 'chemin du fichier de données des métriques')
            ->addArgument('technoFile', InputArgument::REQUIRED, 'chemin du fichier de données des technos')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		parent::execute($input, $output);

		$this->isLock();

    	$this->metricFile = $this->projectDir . '/' . $input->getArgument('metricFile');
    	$this->technoFile = $this->projectDir . '/' . $input->getArgument('technoFile');

        $this->io->title('Initialisation des données');
		
		$this->io->title('Vérification des fichiers');

		if (!$this->isFileExist($this->metricFile)) {
            $this->io->error('Fichier `' . $this->metricFile . '` inexistant.');
            return Command::FAILURE;
		}
		
		if (!$this->isFileExist($this->technoFile)) {
            $this->io->error('Fichier `' . $this->technoFile . '` inexistant.');
            return Command::FAILURE;
		}
		
		$this->io->text('Fichiers présents');

		$this->io->title('Traitement des métriques');

		$serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

		$this->import($serializer, $this->metricFile, Metric::class);
		$this->import($serializer, $this->technoFile, Techno::class);

		$this->io->success('Import terminé.');
        return Command::SUCCESS;
    }

	protected function import($serializer, $file, $class)
	{
		$context = [
		    CsvEncoder::DELIMITER_KEY => ';',
		    CsvEncoder::ENCLOSURE_KEY => '"',
		    CsvEncoder::ESCAPE_CHAR_KEY => '\\',
		    CsvEncoder::KEY_SEPARATOR_KEY => ',',
		];

		$data = $serializer->decode(file_get_contents($file), 'csv', $context);

        $this->io->progressStart(count($data));
		
		foreach ($data as $line) {
			$entity = $this->createEntity($line, $class);

			$this->em->persist($entity);
			$this->io->progressAdvance();
		}
		
		$this->em->flush();
		
		$this->io->progressFinish();
		$this->io->text('Import du fichier ' . $file . ' terminé.');
	}

	protected function createEntity($line, $class)
	{
		switch ($class) {
			case Metric::class:
				$metric = new Metric();
				$metric->setName($line['name']);
				$metric->setLevelOk($line['levelOk']);
				$metric->setLevelNice($line['levelNice']);
				
				// TODO : Objet pas encore persist. On aura peut être pas l'ID et ça ne amrchera pas pour le addMetric. A vérifier
				$this->metrics[$line['name']] = $metric;

				return $metric;
			case Techno::class:
				$version = new Version();
				$version->setVersion($line['version']);
				$version->setIsLts($line['isLts']);

				if (!empty(trim($line['endSupport']))) {
					$date = \DateTime::createFromFormat('Y/m', $line['endSupport']);
					$date->modify('last day of this month');

					$version->setEndSupport($date);
				}
				
				$techno = new Techno();

				if (array_key_exists($line['name'], $this->technos)) {
					$techno = $this->technos[$line['name']];
				}

				$techno->setName($line['name']);
				$techno->addVersion($version);

				$metrics = explode(',', $line['metrics']);
				foreach ($metrics as $metric) {
					if (!array_key_exists($metric, $this->metrics)) {
						$this->io->error('La métrique '. $metric . 'n\'existe pas.');

						return Command::FAILURE;
					}

					$techno->addMetric($this->metrics[$metric]);
				}
				
				$this->technos[$line['name']] = $techno;

				return $techno;
			default:
				$this->io->error('Echec d\'import : Le type d\'objet à importer n\'existe pas.');

			   return Command::FAILURE;
		}
	}
}