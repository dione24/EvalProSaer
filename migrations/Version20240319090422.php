<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240319090422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A19D86650F');
        $this->addSql('DROP INDEX UNIQ_441282A19D86650F ON consultant');
        $this->addSql('ALTER TABLE consultant CHANGE user_id_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A1A76ED395 ON consultant (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('DROP INDEX UNIQ_441282A1A76ED395 ON consultant');
        $this->addSql('ALTER TABLE consultant CHANGE user_id user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A19D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A19D86650F ON consultant (user_id_id)');
    }
}
