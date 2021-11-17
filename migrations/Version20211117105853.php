<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117105853 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente ADD cidade_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B259586CC8 FOREIGN KEY (cidade_id) REFERENCES cidade (id)');
        $this->addSql('CREATE INDEX IDX_F41C9B259586CC8 ON cliente (cidade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B259586CC8');
        $this->addSql('DROP INDEX IDX_F41C9B259586CC8 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP cidade_id');
    }
}
