<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240402073922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seniorities DROP FOREIGN KEY FK_BD675676DE2EA743');
        $this->addSql('DROP INDEX UNIQ_BD675676DE2EA743 ON seniorities');
        $this->addSql('ALTER TABLE seniorities CHANGE employee_id_wd_id employee_id INT NOT NULL');
        $this->addSql('ALTER TABLE seniorities ADD CONSTRAINT FK_BD6756768C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD6756768C03F15C ON seniorities (employee_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seniorities DROP FOREIGN KEY FK_BD6756768C03F15C');
        $this->addSql('DROP INDEX UNIQ_BD6756768C03F15C ON seniorities');
        $this->addSql('ALTER TABLE seniorities CHANGE employee_id employee_id_wd_id INT NOT NULL');
        $this->addSql('ALTER TABLE seniorities ADD CONSTRAINT FK_BD675676DE2EA743 FOREIGN KEY (employee_id_wd_id) REFERENCES employee (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BD675676DE2EA743 ON seniorities (employee_id_wd_id)');
    }
}
