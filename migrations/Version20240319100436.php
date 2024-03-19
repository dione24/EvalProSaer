<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319100436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut ADD statut_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statut ADD CONSTRAINT FK_E564F0BFF6203804 FOREIGN KEY (statut_id) REFERENCES statut (id)');
        $this->addSql('CREATE INDEX IDX_E564F0BFF6203804 ON statut (statut_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut DROP FOREIGN KEY FK_E564F0BFF6203804');
        $this->addSql('DROP INDEX IDX_E564F0BFF6203804 ON statut');
        $this->addSql('ALTER TABLE statut DROP statut_id');
    }
}
