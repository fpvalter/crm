<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211012112112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, codigo_cliente VARCHAR(100) DEFAULT NULL, cnpj VARCHAR(14) NOT NULL, razao_social VARCHAR(255) NOT NULL, logradouro VARCHAR(255) DEFAULT NULL, numero VARCHAR(100) DEFAULT NULL, bairro VARCHAR(100) DEFAULT NULL, cep VARCHAR(10) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telefone1 VARCHAR(50) DEFAULT NULL, telefone2 VARCHAR(50) DEFAULT NULL, telefone3 VARCHAR(50) DEFAULT NULL, observacao LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente');
    }
}
