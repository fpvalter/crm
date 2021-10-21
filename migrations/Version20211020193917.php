<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020193917 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followup ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE followup ADD CONSTRAINT FK_1D1A7A3BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_1D1A7A3BA76ED395 ON followup (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followup DROP FOREIGN KEY FK_1D1A7A3BA76ED395');
        $this->addSql('DROP INDEX IDX_1D1A7A3BA76ED395 ON followup');
        $this->addSql('ALTER TABLE followup DROP user_id');
    }
}
