<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211127120402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification ADD negocio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CA7D879E4F FOREIGN KEY (negocio_id) REFERENCES negocio (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CA7D879E4F ON notification (negocio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CA7D879E4F');
        $this->addSql('DROP INDEX IDX_BF5476CA7D879E4F ON notification');
        $this->addSql('ALTER TABLE notification DROP negocio_id');
    }
}
