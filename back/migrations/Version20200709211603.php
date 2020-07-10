<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709211603 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Création des tables `project`, `project_version` et `project_metric`';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_version (project_id INT NOT NULL, version_id INT NOT NULL, INDEX IDX_2902DFA6166D1F9C (project_id), INDEX IDX_2902DFA64BBC2705 (version_id), PRIMARY KEY(project_id, version_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_metric (id INT AUTO_INCREMENT NOT NULL, metric_id INT NOT NULL, project_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, tag VARCHAR(255) NOT NULL, error_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_9072C5A9A952D583 (metric_id), INDEX IDX_9072C5A9166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project_version ADD CONSTRAINT FK_2902DFA6166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_version ADD CONSTRAINT FK_2902DFA64BBC2705 FOREIGN KEY (version_id) REFERENCES version (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_metric ADD CONSTRAINT FK_9072C5A9A952D583 FOREIGN KEY (metric_id) REFERENCES metric (id)');
        $this->addSql('ALTER TABLE project_metric ADD CONSTRAINT FK_9072C5A9166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_version DROP FOREIGN KEY FK_2902DFA6166D1F9C');
        $this->addSql('ALTER TABLE project_metric DROP FOREIGN KEY FK_9072C5A9166D1F9C');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_version');
        $this->addSql('DROP TABLE project_metric');
    }
}
