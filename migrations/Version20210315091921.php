<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210315091921 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD invoice_number VARCHAR(255) DEFAULT NULL, ADD phone_number VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE listing ADD is_open TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE user ADD is_active TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP invoice_number, DROP phone_number');
        $this->addSql('ALTER TABLE listing DROP is_open');
        $this->addSql('ALTER TABLE user DROP is_active');
    }
}
