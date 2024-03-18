<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318103342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultant DROP FOREIGN KEY FK_441282A1A76ED395');
        $this->addSql('DROP INDEX UNIQ_441282A1A76ED395 ON consultant');
        $this->addSql('ALTER TABLE consultant DROP user_id');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL COMMENT \'(DC2Type:json)\', DROP role');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON user (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_USERNAME ON user');
        $this->addSql('ALTER TABLE user ADD role VARCHAR(255) NOT NULL, DROP username, DROP roles');
        $this->addSql('ALTER TABLE consultant ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultant ADD CONSTRAINT FK_441282A1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_441282A1A76ED395 ON consultant (user_id)');
    }
}
