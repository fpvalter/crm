<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119143249 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto ADD indice VARCHAR(20) DEFAULT NULL, ADD altura VARCHAR(20) DEFAULT NULL, ADD aro VARCHAR(20) DEFAULT NULL, ADD ht VARCHAR(20) DEFAULT NULL, ADD largura VARCHAR(20) DEFAULT NULL, ADD runflat VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE produto DROP indice, DROP altura, DROP aro, DROP ht, DROP largura, DROP runflat');
    }
}
