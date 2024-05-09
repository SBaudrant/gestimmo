<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509095526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE tenant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE tenant (id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tenant_lease (tenant_id INT NOT NULL, lease_id INT NOT NULL, PRIMARY KEY(tenant_id, lease_id))');
        $this->addSql('CREATE INDEX IDX_F95798A19033212A ON tenant_lease (tenant_id)');
        $this->addSql('CREATE INDEX IDX_F95798A1D3CA542C ON tenant_lease (lease_id)');
        $this->addSql('ALTER TABLE tenant_lease ADD CONSTRAINT FK_F95798A19033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tenant_lease ADD CONSTRAINT FK_F95798A1D3CA542C FOREIGN KEY (lease_id) REFERENCES lease (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE tenant_id_seq CASCADE');
        $this->addSql('ALTER TABLE tenant_lease DROP CONSTRAINT FK_F95798A19033212A');
        $this->addSql('ALTER TABLE tenant_lease DROP CONSTRAINT FK_F95798A1D3CA542C');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE tenant_lease');
    }
}
