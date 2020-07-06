<?php

namespace App\Tests\Func\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CreateUserCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('app:data:initialize');
        $commandTester = new CommandTester($command);
        $commandTester->execute([
            'metricFile' => 'metric.csv',
			'technoFile' => 'techno.csv'
        ]);

        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('Initialisation des données', $output);
        $this->assertStringContainsString('==========================', $output);
        $this->assertStringContainsString('Vérification des fichiers', $output);
        $this->assertStringContainsString('=========================', $output);
        $this->assertStringContainsString('[ERROR] Fichier `/var/www/html/metric.csv` inexistant.', $output);
    }
}