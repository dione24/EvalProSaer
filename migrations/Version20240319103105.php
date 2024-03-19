<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319103105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport ADD consultant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C44F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C44F779A2 ON rapport (consultant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C44F779A2');
        $this->addSql('DROP INDEX IDX_BE34A09C44F779A2 ON rapport');
        $this->addSql('ALTER TABLE rapport DROP consultant_id');
    }
}
