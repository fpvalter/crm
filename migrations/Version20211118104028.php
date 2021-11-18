<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211118104028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE familia (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE grupo (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marca (id INT AUTO_INCREMENT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subfamilia (id INT AUTO_INCREMENT NOT NULL, familia_id INT NOT NULL, codigo VARCHAR(255) DEFAULT NULL, descricao VARCHAR(255) NOT NULL, INDEX IDX_150B6A80D02563A3 (familia_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE subfamilia ADD CONSTRAINT FK_150B6A80D02563A3 FOREIGN KEY (familia_id) REFERENCES familia (id)');
        $this->addSql('ALTER TABLE produto ADD familia_id INT DEFAULT NULL, ADD subfamilia_id INT DEFAULT NULL, ADD marca_id INT DEFAULT NULL, ADD grupo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D7D02563A3 FOREIGN KEY (familia_id) REFERENCES familia (id)');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D78FB48400 FOREIGN KEY (subfamilia_id) REFERENCES subfamilia (id)');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D781EF0041 FOREIGN KEY (marca_id) REFERENCES marca (id)');
        $this->addSql('ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D79C833003 FOREIGN KEY (grupo_id) REFERENCES grupo (id)');
        $this->addSql('CREATE INDEX IDX_5CAC49D7D02563A3 ON produto (familia_id)');
        $this->addSql('CREATE INDEX IDX_5CAC49D78FB48400 ON produto (subfamilia_id)');
        $this->addSql('CREATE INDEX IDX_5CAC49D781EF0041 ON produto (marca_id)');
        $this->addSql('CREATE INDEX IDX_5CAC49D79C833003 ON produto (grupo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D7D02563A3');
        $this->addSql('ALTER TABLE subfamilia DROP FOREIGN KEY FK_150B6A80D02563A3');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D79C833003');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D781EF0041');
        $this->addSql('ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D78FB48400');
        $this->addSql('DROP TABLE familia');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE marca');
        $this->addSql('DROP TABLE subfamilia');
        $this->addSql('DROP INDEX IDX_5CAC49D7D02563A3 ON produto');
        $this->addSql('DROP INDEX IDX_5CAC49D78FB48400 ON produto');
        $this->addSql('DROP INDEX IDX_5CAC49D781EF0041 ON produto');
        $this->addSql('DROP INDEX IDX_5CAC49D79C833003 ON produto');
        $this->addSql('ALTER TABLE produto DROP familia_id, DROP subfamilia_id, DROP marca_id, DROP grupo_id');
    }
}
