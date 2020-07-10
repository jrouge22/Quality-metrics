<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200630115908 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Création des tables `metric`, `techno`, `techno_metric` et `version`';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE metric (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, level_ok INT DEFAULT NULL, level_nice INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno_metric (techno_id INT NOT NULL, metric_id INT NOT NULL, INDEX IDX_B02D010A51F3C1BC (techno_id), INDEX IDX_B02D010AA952D583 (metric_id), PRIMARY KEY(techno_id, metric_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE version (id INT AUTO_INCREMENT NOT NULL, techno_id INT NOT NULL, version VARCHAR(255) NOT NULL, is_lts TINYINT(1) DEFAULT NULL, end_support DATETIME DEFAULT NULL, INDEX IDX_BF1CD3C351F3C1BC (techno_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE techno_metric ADD CONSTRAINT FK_B02D010A51F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE techno_metric ADD CONSTRAINT FK_B02D010AA952D583 FOREIGN KEY (metric_id) REFERENCES metric (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE version ADD CONSTRAINT FK_BF1CD3C351F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE techno_metric DROP FOREIGN KEY FK_B02D010AA952D583');
        $this->addSql('ALTER TABLE techno_metric DROP FOREIGN KEY FK_B02D010A51F3C1BC');
        $this->addSql('ALTER TABLE version DROP FOREIGN KEY FK_BF1CD3C351F3C1BC');
        $this->addSql('DROP TABLE metric');
        $this->addSql('DROP TABLE techno');
        $this->addSql('DROP TABLE techno_metric');
        $this->addSql('DROP TABLE version');
    }
}
