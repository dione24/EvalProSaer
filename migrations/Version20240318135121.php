<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318135121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, competences LONGTEXT NOT NULL, disponibilite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', cv VARCHAR(255) DEFAULT NULL, description_profil LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport_consultant ADD CONSTRAINT FK_EDAD4ED044F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98D4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EEB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EE44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_consultant DROP FOREIGN KEY FK_EDAD4ED044F779A2');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EE44F779A2');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98D4E271E1');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EEB8A61670');
    }
}
