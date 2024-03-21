<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321130512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_D9BEC0C4C18272 (projet_id), INDEX IDX_D9BEC0C4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, competences LONGTEXT NOT NULL, disponibilite DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', cv VARCHAR(255) DEFAULT NULL, description_profil LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_441282A1A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, rapport_id INT DEFAULT NULL, user_id INT DEFAULT NULL, content LONGTEXT NOT NULL, date_evaluation DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_1323A5751DFBCC46 (rapport_id), INDEX IDX_1323A575A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichiers (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_969DB4ABC18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projet (id INT AUTO_INCREMENT NOT NULL, statut_id INT DEFAULT NULL, nom LONGTEXT NOT NULL, client VARCHAR(255) DEFAULT NULL, description LONGTEXT NOT NULL, budget DOUBLE PRECISION DEFAULT NULL, date_debut DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_50159CA9F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, tache_id INT DEFAULT NULL, projet_id INT DEFAULT NULL, user_id INT DEFAULT NULL, periode DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', resume_executif LONGTEXT NOT NULL, points_saillants LONGTEXT NOT NULL, resultats_obtenus LONGTEXT NOT NULL, appreciation_evolution_activite LONGTEXT NOT NULL, perspectives LONGTEXT NOT NULL, created_at DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_BE34A09CD2235D39 (tache_id), INDEX IDX_BE34A09CC18272 (projet_id), INDEX IDX_BE34A09CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut (id INT AUTO_INCREMENT NOT NULL, statut_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, couleur VARCHAR(255) DEFAULT NULL, INDEX IDX_E564F0BFF6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches (id INT AUTO_INCREMENT NOT NULL, projet_id INT DEFAULT NULL, statut_id INT DEFAULT NULL, description LONGTEXT NOT NULL, priorite VARCHAR(255) NOT NULL, date_debut DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', date_fin DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_3BF2CD98C18272 (projet_id), INDEX IDX_3BF2CD98F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taches_consultant (taches_id INT NOT NULL, consultant_id INT NOT NULL, INDEX IDX_A96B43EEB8A61670 (taches_id), INDEX IDX_A96B43EE44F779A2 (consultant_id), PRIMARY KEY(taches_id, consultant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5751DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fichiers ADD CONSTRAINT FK_969DB4ABC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CD2235D39 FOREIGN KEY (tache_id) REFERENCES taches (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CC18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE statut ADD CONSTRAINT FK_E564F0BFF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EEB8A61670 FOREIGN KEY (taches_id) REFERENCES taches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE taches_consultant ADD CONSTRAINT FK_A96B43EE44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4C18272');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4A76ED395');
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5751DFBCC46');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A76ED395');
        $this->addSql('ALTER TABLE fichiers DROP FOREIGN KEY FK_969DB4ABC18272');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9F6203804');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CD2235D39');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CC18272');
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09CA76ED395');
        $this->addSql('ALTER TABLE statut DROP FOREIGN KEY FK_E564F0BFF6203804');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98C18272');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98F6203804');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EEB8A61670');
        $this->addSql('ALTER TABLE taches_consultant DROP FOREIGN KEY FK_A96B43EE44F779A2');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE consultant');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE fichiers');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE statut');
        $this->addSql('DROP TABLE taches');
        $this->addSql('DROP TABLE taches_consultant');
        $this->addSql('DROP TABLE user');
    }
}
