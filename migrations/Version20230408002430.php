<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408002430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instructor DROP dni');
        $this->addSql('ALTER TABLE instructor DROP nombre');
        $this->addSql('ALTER TABLE instructor DROP apellido');
        $this->addSql('ALTER TABLE instructor DROP email');
        $this->addSql('ALTER TABLE instructor DROP telefono');
        $this->addSql('ALTER TABLE instructor DROP domicilio');
        $this->addSql('ALTER TABLE instructor DROP ciudad');
        $this->addSql('ALTER TABLE instructor DROP password');
        $this->addSql('ALTER TABLE instructor DROP activo');
        $this->addSql('ALTER TABLE usuario ADD instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D8C4FC193 FOREIGN KEY (instructor_id) REFERENCES instructor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D8C4FC193 ON usuario (instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT FK_2265B05D8C4FC193');
        $this->addSql('DROP INDEX UNIQ_2265B05D8C4FC193');
        $this->addSql('ALTER TABLE usuario DROP instructor_id');
        $this->addSql('ALTER TABLE instructor ADD dni VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD apellido VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD telefono VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD domicilio TEXT NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD ciudad VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD activo BOOLEAN NOT NULL');
    }
}
