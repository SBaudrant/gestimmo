<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509163953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lease ADD rent_base DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE lease ADD rent_fees DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD proposed_rent_base DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD proposed_rent_fees DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD proposed_payment_day INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rental_property DROP proposed_rent_base');
        $this->addSql('ALTER TABLE rental_property DROP proposed_rent_fees');
        $this->addSql('ALTER TABLE rental_property DROP proposed_payment_day');
        $this->addSql('ALTER TABLE lease DROP rent_base');
        $this->addSql('ALTER TABLE lease DROP rent_fees');
    }
}
