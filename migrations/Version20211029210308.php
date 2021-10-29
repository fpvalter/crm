<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029210308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cliente_user');
        $this->addSql('ALTER TABLE cliente ADD vendedor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B258361A8B8 FOREIGN KEY (vendedor_id) REFERENCES vendedor (id)');
        $this->addSql('CREATE INDEX IDX_F41C9B258361A8B8 ON cliente (vendedor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cliente_user (cliente_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_D63A1E2EA76ED395 (user_id), INDEX IDX_D63A1E2EDE734E51 (cliente_id), PRIMARY KEY(cliente_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cliente_user ADD CONSTRAINT FK_D63A1E2EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cliente_user ADD CONSTRAINT FK_D63A1E2EDE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B258361A8B8');
        $this->addSql('DROP INDEX IDX_F41C9B258361A8B8 ON cliente');
        $this->addSql('ALTER TABLE cliente DROP vendedor_id');
    }
}
