<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319101119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98D4E271E1');
        $this->addSql('DROP INDEX IDX_3BF2CD98D4E271E1 ON taches');
        $this->addSql('ALTER TABLE taches CHANGE projet_id_id projet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD98C18272 ON taches (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98C18272');
        $this->addSql('DROP INDEX IDX_3BF2CD98C18272 ON taches');
        $this->addSql('ALTER TABLE taches CHANGE projet_id projet_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98D4E271E1 FOREIGN KEY (projet_id_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD98D4E271E1 ON taches (projet_id_id)');
    }
}
