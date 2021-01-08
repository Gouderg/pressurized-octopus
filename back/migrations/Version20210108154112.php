<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108154112 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profondeur (id INT AUTO_INCREMENT NOT NULL, correspond_id INT NOT NULL, profondeur INT NOT NULL, INDEX IDX_E3804DEA98DE379A (correspond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tableplongee (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temps (id INT AUTO_INCREMENT NOT NULL, est_a_id INT NOT NULL, temps INT NOT NULL, palier15 INT DEFAULT NULL, palier12 INT DEFAULT NULL, palier9 INT DEFAULT NULL, palier6 INT DEFAULT NULL, palier3 INT DEFAULT NULL, INDEX IDX_60B4B72010C32089 (est_a_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profondeur ADD CONSTRAINT FK_E3804DEA98DE379A FOREIGN KEY (correspond_id) REFERENCES tableplongee (id)');
        $this->addSql('ALTER TABLE temps ADD CONSTRAINT FK_60B4B72010C32089 FOREIGN KEY (est_a_id) REFERENCES profondeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temps DROP FOREIGN KEY FK_60B4B72010C32089');
        $this->addSql('ALTER TABLE profondeur DROP FOREIGN KEY FK_E3804DEA98DE379A');
        $this->addSql('DROP TABLE profondeur');
        $this->addSql('DROP TABLE tableplongee');
        $this->addSql('DROP TABLE temps');
    }
}
