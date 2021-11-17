<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211117121003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transportadora (id INT AUTO_INCREMENT NOT NULL, razao_social VARCHAR(255) NOT NULL, cnpj VARCHAR(14) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, codigo VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente ADD transportadora_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25862FB452 FOREIGN KEY (transportadora_id) REFERENCES transportadora (id)');
        $this->addSql('CREATE INDEX IDX_F41C9B25862FB452 ON cliente (transportadora_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25862FB452');
        $this->addSql('DROP TABLE transportadora');
        $this->addSql('DROP INDEX IDX_F41C9B25862FB452 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP transportadora_id');
    }
}
