<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240403085216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, employee_id INT NOT NULL, active TINYINT(1) NOT NULL, employee_id_wd VARCHAR(255) NOT NULL, pref_lastname VARCHAR(255) NOT NULL, pref_firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seniorities (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, profile_start_date DATETIME NOT NULL, level1 VARCHAR(255) DEFAULT NULL, level2 VARCHAR(255) DEFAULT NULL, level3 VARCHAR(255) DEFAULT NULL, level4 VARCHAR(255) DEFAULT NULL, level5 VARCHAR(255) DEFAULT NULL, level6 VARCHAR(255) DEFAULT NULL, level7 VARCHAR(255) DEFAULT NULL, level8 VARCHAR(255) DEFAULT NULL, level9 VARCHAR(255) DEFAULT NULL, level10 VARCHAR(255) DEFAULT NULL, management_level VARCHAR(255) NOT NULL, management_chain VARCHAR(255) NOT NULL, seniority VARCHAR(255) NOT NULL, position_id VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, created_at DATE NOT NULL, INDEX IDX_BD6756768C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE seniorities ADD CONSTRAINT FK_BD6756768C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seniorities DROP FOREIGN KEY FK_BD6756768C03F15C');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE seniorities');
    }
}
