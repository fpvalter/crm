<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211030124040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B2520332D99 ON cliente (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F41C9B25C8C6906B ON cliente (cnpj)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C384AB4220332D99 ON contato (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C81CFEF020332D99 ON estabelecimento (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C81CFEF0C8C6906B ON estabelecimento (cnpj)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5CAC49D720332D99 ON produto (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1AC8086620332D99 ON seguimento (codigo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9797982E20332D99 ON vendedor (codigo)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_F41C9B2520332D99 ON cliente');
        $this->addSql('DROP INDEX UNIQ_F41C9B25C8C6906B ON cliente');
        $this->addSql('DROP INDEX UNIQ_C384AB4220332D99 ON contato');
        $this->addSql('DROP INDEX UNIQ_C81CFEF020332D99 ON estabelecimento');
        $this->addSql('DROP INDEX UNIQ_C81CFEF0C8C6906B ON estabelecimento');
        $this->addSql('DROP INDEX UNIQ_5CAC49D720332D99 ON produto');
        $this->addSql('DROP INDEX UNIQ_1AC8086620332D99 ON seguimento');
        $this->addSql('DROP INDEX UNIQ_9797982E20332D99 ON vendedor');
    }
}
