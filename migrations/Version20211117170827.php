<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117170827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transportadora ADD cidade_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transportadora ADD CONSTRAINT FK_32F6288D9586CC8 FOREIGN KEY (cidade_id) REFERENCES cidade (id)');
        $this->addSql('CREATE INDEX IDX_32F6288D9586CC8 ON transportadora (cidade_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transportadora DROP FOREIGN KEY FK_32F6288D9586CC8');
        $this->addSql('DROP INDEX IDX_32F6288D9586CC8 ON transportadora');
        $this->addSql('ALTER TABLE transportadora DROP cidade_id');
    }
}
