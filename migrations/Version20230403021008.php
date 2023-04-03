<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403021008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno ADD activo BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD activo BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD activo BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE socio ADD activo BOOLEAN NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE socio DROP activo');
        $this->addSql('ALTER TABLE instructor DROP activo');
        $this->addSql('ALTER TABLE piloto DROP activo');
        $this->addSql('ALTER TABLE alumno DROP activo');
    }
}
