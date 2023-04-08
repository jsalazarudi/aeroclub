<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407184025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP dni');
        $this->addSql('ALTER TABLE alumno DROP nombre');
        $this->addSql('ALTER TABLE alumno DROP apellido');
        $this->addSql('ALTER TABLE alumno DROP email');
        $this->addSql('ALTER TABLE alumno DROP telefono');
        $this->addSql('ALTER TABLE alumno DROP domicilio');
        $this->addSql('ALTER TABLE alumno DROP ciudad');
        $this->addSql('ALTER TABLE alumno DROP password');
        $this->addSql('ALTER TABLE alumno DROP activo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE alumno ADD dni VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD apellido VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD telefono VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD domicilio TEXT NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD ciudad VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE alumno ADD activo BOOLEAN NOT NULL');
    }
}
