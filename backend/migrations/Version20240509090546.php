<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509090546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id BIGSERIAL NOT NULL, email VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL, active BOOLEAN NOT NULL, init_password_token_expiration TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, init_password_token VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493D240A56 ON "user" (init_password_token)');
        $this->addSql('COMMENT ON COLUMN "user".init_password_token_expiration IS \'(DC2Type:datetime_immutable)\'');

        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE lease_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rent_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (id INT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lease (id INT NOT NULL, rental_property_id BIGINT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, location_type INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E6C774954D6E2560 ON lease (rental_property_id)');
        $this->addSql('CREATE TABLE rent_payment (id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, amount DOUBLE PRECISION NOT NULL, payed_at DATE DEFAULT NULL, status INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE lease ADD CONSTRAINT FK_E6C774954D6E2560 FOREIGN KEY (rental_property_id) REFERENCES rental_property (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental_property ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD current_lease_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rental_property DROP adress');
        $this->addSql('ALTER TABLE rental_property DROP city');
        $this->addSql('ALTER TABLE rental_property DROP postal_code');
        $this->addSql('ALTER TABLE rental_property ADD CONSTRAINT FK_BB9405EDF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rental_property ADD CONSTRAINT FK_BB9405ED4EB22E06 FOREIGN KEY (current_lease_id) REFERENCES lease (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BB9405EDF5B7AF75 ON rental_property (address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BB9405ED4EB22E06 ON rental_property (current_lease_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "user"');
        
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rental_property DROP CONSTRAINT FK_BB9405EDF5B7AF75');
        $this->addSql('ALTER TABLE rental_property DROP CONSTRAINT FK_BB9405ED4EB22E06');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE lease_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rent_payment_id_seq CASCADE');
        $this->addSql('ALTER TABLE lease DROP CONSTRAINT FK_E6C774954D6E2560');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE lease');
        $this->addSql('DROP TABLE rent_payment');
        $this->addSql('DROP INDEX UNIQ_BB9405EDF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_BB9405ED4EB22E06');
        $this->addSql('ALTER TABLE rental_property ADD adress VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rental_property ADD postal_code VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rental_property DROP address_id');
        $this->addSql('ALTER TABLE rental_property DROP current_lease_id');
    }
}
