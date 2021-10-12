<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012113704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_info (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, credito DOUBLE PRECISION DEFAULT NULL, credito_validade DATE DEFAULT NULL, dias_ultima_compra INT DEFAULT NULL, UNIQUE INDEX UNIQ_9020F930DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contato (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, nome VARCHAR(100) NOT NULL, data_nascimento DATE DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(50) DEFAULT NULL, observacao LONGTEXT DEFAULT NULL, INDEX IDX_C384AB42DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente_info ADD CONSTRAINT FK_9020F930DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE contato ADD CONSTRAINT FK_C384AB42DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente_info');
        $this->addSql('DROP TABLE contato');
    }
}
