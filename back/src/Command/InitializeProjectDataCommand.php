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
use App\Entity\Project;
use App\Entity\ProjectMetric;
use App\Entity\Version;

class InitializeProjectDataCommand extends AbstractImportCommand
{
    protected static $defaultName = 'app:project:initialize';

    private $projectFile;
    private $metricProjectFile;

    private $versions;
    private $projects;
    private $metrics;

    protected function configure()
    {
        $this
            ->setDescription('Initialise les données projets.')
            ->setHelp('Initialise les données projets (Projets, techno des projets et métriques des projets) à partir des 2 fichiers à placer dans le répertoire Data.')
            ->addArgument('projectFile', InputArgument::REQUIRED, 'chemin du fichier de données des projetcs')
            ->addArgument('metricProjectFile', InputArgument::REQUIRED, 'chemin du fichier de données des métriques des projets');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
		parent::execute($input, $output);

		$this->isLock();

        $this->projectFile = $this->projectDir . '/' . $input->getArgument('projectFile');
        $this->metricProjectFile = $this->projectDir . '/' . $input->getArgument('metricProjectFile');


        $this->io->title('Initialisation des données');

        $this->io->title('Vérification des fichiers');

        if (!$this->isFileExist($this->projectFile)) {
            $this->io->error('Fichier `' . $this->projectFile . '` inexistant.');
            return Command::FAILURE;
        }

        if (!$this->isFileExist($this->metricProjectFile)) {
            $this->io->error('Fichier `' . $this->metricProjectFile . '` inexistant.');
            return Command::FAILURE;
        }

        $this->io->text('Fichiers présents');

        $this->io->title('Traitement des projets');

        $this->versions = $this->em->getRepository(Version::class)->findAllIndexed('version');
        $this->metrics = $this->em->getRepository(Metric::class)->findAllIndexed('name');

        $serializer = new Serializer([new ObjectNormalizer()], [new CsvEncoder()]);

        $this->import($serializer, $this->projectFile, Project::class);
        $this->import($serializer, $this->metricProjectFile, ProjectMetric::class);

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
            case Project::class:
                $project = new Project();
                $project->setName($line['name']);
                $project->setCode($line['code']);

                $versions = explode(',', $line['versions']);

                // TODO : Il faudra voir comment gérer techno/version. La j'ai triché car les versions SF et react sont différentes...
                foreach ($versions as $version) {
                    if (!array_key_exists($version, $this->versions)) {
                        $this->io->error('La version ' . $version . ' n\'existe pas.');

                        return Command::FAILURE;
                    }

                    $project->addVersion($this->versions[$version]);
                }

                $this->projects[$line['code']] = $project;

                return $project;
            case ProjectMetric::class:
                $projectMetric = new ProjectMetric();

                $projectMetric->setTag($line['tag']);

                if (!array_key_exists($line['metric'], $this->metrics)) {
                    $this->io->error('La métrique ' . $line['metric'] . ' n\'existe pas.');

                    return Command::FAILURE;
                }

                $projectMetric->setMetric($this->metrics[$line['metric']]);

                if (!array_key_exists($line['codeProject'], $this->projects)) {
                    $this->io->error('Le projet ' . $line['codeProject'] . ' n\'existe pas.');

                    return Command::FAILURE;
                }

                $projectMetric->setProject($this->projects[$line['codeProject']]);

                $projectMetric->setValue($line['value']);

                return $projectMetric;
            default:
                $this->io->error('Echec d\'import : Le type d\'objet à importer n\'existe pas.');

                return Command::FAILURE;
        }
    }
}