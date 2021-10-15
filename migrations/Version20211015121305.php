<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211015121305 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE empresa (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, db VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe (id INT AUTO_INCREMENT NOT NULL, user_gerente_id INT DEFAULT NULL, user_supervisor_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, INDEX IDX_2449BA15FD8DB3E1 (user_gerente_id), INDEX IDX_2449BA15F767010F (user_supervisor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipe_user (equipe_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_84DA47B76D861B89 (equipe_id), INDEX IDX_84DA47B7A76ED395 (user_id), PRIMARY KEY(equipe_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE estabelecimento (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) NOT NULL, cnpj VARCHAR(14) NOT NULL, razao_social VARCHAR(255) NOT NULL, logradouro VARCHAR(255) DEFAULT NULL, numero VARCHAR(100) DEFAULT NULL, bairro VARCHAR(100) DEFAULT NULL, cep VARCHAR(10) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, telefone VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) NOT NULL, categoria VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produto_estabelecimento (id INT AUTO_INCREMENT NOT NULL, estabelecimento_id INT NOT NULL, produto_id INT NOT NULL, dias_ultima_venda INT DEFAULT NULL, diferenca_entrada_saida DOUBLE PRECISION DEFAULT NULL, INDEX IDX_97C120764DBB2654 (estabelecimento_id), INDEX IDX_97C12076105CFD56 (produto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15FD8DB3E1 FOREIGN KEY (user_gerente_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE equipe ADD CONSTRAINT FK_2449BA15F767010F FOREIGN KEY (user_supervisor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE equipe_user ADD CONSTRAINT FK_84DA47B76D861B89 FOREIGN KEY (equipe_id) REFERENCES equipe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipe_user ADD CONSTRAINT FK_84DA47B7A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE produto_estabelecimento ADD CONSTRAINT FK_97C120764DBB2654 FOREIGN KEY (estabelecimento_id) REFERENCES estabelecimento (id)');
        $this->addSql('ALTER TABLE produto_estabelecimento ADD CONSTRAINT FK_97C12076105CFD56 FOREIGN KEY (produto_id) REFERENCES produto (id)');
        $this->addSql('ALTER TABLE cliente_info ADD r INT DEFAULT NULL, ADD f INT DEFAULT NULL, ADD v INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD estabelecimento_id INT DEFAULT NULL, ADD nome VARCHAR(255) DEFAULT NULL, ADD telefone VARCHAR(100) DEFAULT NULL, ADD codigo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494DBB2654 FOREIGN KEY (estabelecimento_id) REFERENCES estabelecimento (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494DBB2654 ON user (estabelecimento_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE equipe_user DROP FOREIGN KEY FK_84DA47B76D861B89');
        $this->addSql('ALTER TABLE produto_estabelecimento DROP FOREIGN KEY FK_97C120764DBB2654');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6494DBB2654');
        $this->addSql('ALTER TABLE produto_estabelecimento DROP FOREIGN KEY FK_97C12076105CFD56');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE equipe');
        $this->addSql('DROP TABLE equipe_user');
        $this->addSql('DROP TABLE estabelecimento');
        $this->addSql('DROP TABLE produto');
        $this->addSql('DROP TABLE produto_estabelecimento');
        $this->addSql('ALTER TABLE cliente_info DROP r, DROP f, DROP v');
        $this->addSql('DROP INDEX IDX_8D93D6494DBB2654 ON `user`');
        $this->addSql('ALTER TABLE `user` DROP estabelecimento_id, DROP nome, DROP telefone, DROP codigo');
    }
}
