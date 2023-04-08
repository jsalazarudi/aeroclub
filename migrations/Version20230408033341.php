<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408033341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tesorero DROP nombre');
        $this->addSql('ALTER TABLE tesorero DROP apellido');
        $this->addSql('ALTER TABLE tesorero DROP correo');
        $this->addSql('ALTER TABLE tesorero DROP password');
        $this->addSql('ALTER TABLE tesorero DROP activo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tesorero ADD nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tesorero ADD apellido VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tesorero ADD correo VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tesorero ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tesorero ADD activo BOOLEAN NOT NULL');
    }
}
