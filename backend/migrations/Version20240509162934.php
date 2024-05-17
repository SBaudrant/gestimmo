<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509162934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rental_property DROP CONSTRAINT fk_bb9405ed4eb22e06');
        $this->addSql('DROP INDEX uniq_bb9405ed4eb22e06');
        $this->addSql('ALTER TABLE rental_property DROP current_lease_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rental_property ADD current_lease_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rental_property ADD CONSTRAINT fk_bb9405ed4eb22e06 FOREIGN KEY (current_lease_id) REFERENCES lease (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_bb9405ed4eb22e06 ON rental_property (current_lease_id)');
    }
}
