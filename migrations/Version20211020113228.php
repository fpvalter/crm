<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211020113228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_user (cliente_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D63A1E2EDE734E51 (cliente_id), INDEX IDX_D63A1E2EA76ED395 (user_id), PRIMARY KEY(cliente_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE followup (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, descricao LONGTEXT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_1D1A7A3BDE734E51 (cliente_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seguimento (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendedor (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, nome VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente_user ADD CONSTRAINT FK_D63A1E2EDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cliente_user ADD CONSTRAINT FK_D63A1E2EA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE followup ADD CONSTRAINT FK_1D1A7A3BDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE cliente ADD seguimento_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25777DB232 FOREIGN KEY (seguimento_id) REFERENCES seguimento (id)');
        $this->addSql('CREATE INDEX IDX_F41C9B25777DB232 ON cliente (seguimento_id)');
        $this->addSql('ALTER TABLE equipe ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE estabelecimento ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE produto ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD vendedor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6498361A8B8 FOREIGN KEY (vendedor_id) REFERENCES vendedor (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6498361A8B8 ON user (vendedor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25777DB232');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6498361A8B8');
        $this->addSql('DROP TABLE cliente_user');
        $this->addSql('DROP TABLE followup');
        $this->addSql('DROP TABLE seguimento');
        $this->addSql('DROP TABLE vendedor');
        $this->addSql('DROP INDEX IDX_F41C9B25777DB232 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP seguimento_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE equipe DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE estabelecimento DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE produto DROP created_at, DROP updated_at');
        $this->addSql('DROP INDEX UNIQ_8D93D6498361A8B8 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP vendedor_id');
    }
}
