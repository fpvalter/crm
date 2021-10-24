<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211024145400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE negocio (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, negocio_etapa_id INT DEFAULT NULL, titulo VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7528E379DE734E51 (cliente_id), INDEX IDX_7528E3791DCCCC1F (negocio_etapa_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE negocio_etapa (id INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, ordem INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nota_fiscal (id INT AUTO_INCREMENT NOT NULL, estabelecimento_id INT NOT NULL, produto_id INT NOT NULL, cliente_id INT NOT NULL, numero INT NOT NULL, serie VARCHAR(10) NOT NULL, emissao DATE NOT NULL, quantidade DOUBLE PRECISION NOT NULL, valor_unitario DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_6C2C0C684DBB2654 (estabelecimento_id), INDEX IDX_6C2C0C68105CFD56 (produto_id), INDEX IDX_6C2C0C68DE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE negocio ADD CONSTRAINT FK_7528E379DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE negocio ADD CONSTRAINT FK_7528E3791DCCCC1F FOREIGN KEY (negocio_etapa_id) REFERENCES negocio_etapa (id)');
        $this->addSql('ALTER TABLE nota_fiscal ADD CONSTRAINT FK_6C2C0C684DBB2654 FOREIGN KEY (estabelecimento_id) REFERENCES estabelecimento (id)');
        $this->addSql('ALTER TABLE nota_fiscal ADD CONSTRAINT FK_6C2C0C68105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE nota_fiscal ADD CONSTRAINT FK_6C2C0C68DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE negocio DROP FOREIGN KEY FK_7528E3791DCCCC1F');
        $this->addSql('DROP TABLE negocio');
        $this->addSql('DROP TABLE negocio_etapa');
        $this->addSql('DROP TABLE nota_fiscal');
    }
}
