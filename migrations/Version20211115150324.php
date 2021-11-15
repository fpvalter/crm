<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211115150324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente ADD nome_fantasia VARCHAR(255) DEFAULT NULL, ADD complemento VARCHAR(255) DEFAULT NULL, ADD site VARCHAR(255) DEFAULT NULL, ADD tipo_pessoa VARCHAR(1) DEFAULT NULL, ADD email_nfe VARCHAR(255) DEFAULT NULL, ADD email_financeiro VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cliente DROP nome_fantasia, DROP complemento, DROP site, DROP tipo_pessoa, DROP email_nfe, DROP email_financeiro');
    }
}
