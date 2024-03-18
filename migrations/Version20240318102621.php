<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318102621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, nom LONGTEXT NOT NULL, client VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, budget DOUBLE PRECISION DEFAULT NULL, date_debut DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', statut VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, projet_id_id INT DEFAULT NULL, periode DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', realisations LONGTEXT NOT NULL, difficultes LONGTEXT NOT NULL, propositions_innovation LONGTEXT NOT NULL, auto_evaluation LONGTEXT NOT NULL, evaluation_responsable LONGTEXT NOT NULL, INDEX IDX_BE34A09CD4E271E1 (projet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport_consultant (rapport_id INT NOT NULL, consultant_id INT NOT NULL, INDEX IDX_EDAD4ED01DFBCC46 (rapport_id), INDEX IDX_EDAD4ED044F779A2 (consultant_id), PRIMARY KEY(rapport_id, consultant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches (id INT AUTO_INCREMENT NOT NULL, projet_id_id INT DEFAULT NULL, description LONGTEXT NOT NULL, dependance VARCHAR(255) DEFAULT NULL, priorite VARCHAR(255) NOT NULL, estimation_temps DOUBLE PRECISION NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_3BF2CD98D4E271E1 (projet_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches_consultant (taches_id INT NOT NULL, consultant_id INT NOT NULL, INDEX IDX_A96B43EEB8A61670 (taches_id), INDEX IDX_A96B43EE44F779A2 (consultant_id), PRIMARY KEY(taches_id, consultant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CD4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE rapport_consultant ADD CONSTRAINT FK_EDAD4ED01DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rapport_consultant ADD CONSTRAINT FK_EDAD4ED044F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98D4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EEB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EE44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consultant ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A1A76ED395 ON consultant (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CD4E271E1');
        $this->addSql('ALTER TABLE rapport_consultant DROP FOREIGN KEY FK_EDAD4ED01DFBCC46');
        $this->addSql('ALTER TABLE rapport_consultant DROP FOREIGN KEY FK_EDAD4ED044F779A2');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98D4E271E1');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EEB8A61670');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EE44F779A2');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE rapport_consultant');
        $this->addSql('DROP TABLE taches');
        $this->addSql('DROP TABLE taches_consultant');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('DROP INDEX UNIQ_441282A1A76ED395 ON consultant');
        $this->addSql('ALTER TABLE consultant DROP user_id');
    }
}
