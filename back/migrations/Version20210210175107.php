<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210210175107 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profondeur (id INT AUTO_INCREMENT NOT NULL, correspond_id INT DEFAULT NULL, profondeur INT NOT NULL, INDEX IDX_E3804DEA98DE379A (correspond_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tableplongee (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE temps (id INT AUTO_INCREMENT NOT NULL, esta_id INT NOT NULL, temps INT NOT NULL, palier15 INT DEFAULT NULL, palier12 INT DEFAULT NULL, palier9 INT DEFAULT NULL, palier6 INT DEFAULT NULL, palier3 INT DEFAULT NULL, INDEX IDX_60B4B720DF9C0918 (esta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profondeur ADD CONSTRAINT FK_E3804DEA98DE379A FOREIGN KEY (correspond_id) REFERENCES tableplongee (id)');
        $this->addSql('ALTER TABLE temps ADD CONSTRAINT FK_60B4B720DF9C0918 FOREIGN KEY (esta_id) REFERENCES profondeur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE temps DROP FOREIGN KEY FK_60B4B720DF9C0918');
        $this->addSql('ALTER TABLE profondeur DROP FOREIGN KEY FK_E3804DEA98DE379A');
        $this->addSql('DROP TABLE profondeur');
        $this->addSql('DROP TABLE tableplongee');
        $this->addSql('DROP TABLE temps');
        $this->addSql('DROP TABLE user');
    }
}
