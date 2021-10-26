<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211026115028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followup ADD negocio_id INT DEFAULT NULL, ADD tipo VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE followup ADD CONSTRAINT FK_1D1A7A3B7D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
        $this->addSql('CREATE INDEX IDX_1D1A7A3B7D879E4F ON followup (negocio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE followup DROP FOREIGN KEY FK_1D1A7A3B7D879E4F');
        $this->addSql('DROP INDEX IDX_1D1A7A3B7D879E4F ON followup');
        $this->addSql('ALTER TABLE followup DROP negocio_id, DROP tipo');
    }
}
