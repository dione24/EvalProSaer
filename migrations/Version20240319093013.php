<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319093013 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet ADD statut_id INT DEFAULT NULL, DROP statut');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA9F6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_50159CA9F6203804 ON projet (statut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA9F6203804');
        $this->addSql('DROP INDEX IDX_50159CA9F6203804 ON projet');
        $this->addSql('ALTER TABLE projet ADD statut VARCHAR(255) NOT NULL, DROP statut_id');
    }
}
