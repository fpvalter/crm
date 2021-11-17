<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117141335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negocio ADD contato_id INT NOT NULL');
        $this->addSql('ALTER TABLE negocio ADD CONSTRAINT FK_7528E379B279BE46 FOREIGN KEY (contato_id) REFERENCES contato (id)');
        $this->addSql('CREATE INDEX IDX_7528E379B279BE46 ON negocio (contato_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negocio DROP FOREIGN KEY FK_7528E379B279BE46');
        $this->addSql('DROP INDEX IDX_7528E379B279BE46 ON negocio');
        $this->addSql('ALTER TABLE negocio DROP contato_id');
    }
}
