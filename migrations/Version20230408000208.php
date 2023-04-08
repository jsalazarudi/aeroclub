<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408000208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE socio DROP dni');
        $this->addSql('ALTER TABLE socio DROP nombre');
        $this->addSql('ALTER TABLE socio DROP apellido');
        $this->addSql('ALTER TABLE socio DROP email');
        $this->addSql('ALTER TABLE socio DROP telefono');
        $this->addSql('ALTER TABLE socio DROP domicilio');
        $this->addSql('ALTER TABLE socio DROP ciudad');
        $this->addSql('ALTER TABLE socio DROP password');
        $this->addSql('ALTER TABLE socio DROP activo');
        $this->addSql('ALTER TABLE usuario ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05DDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DDA04E6A9 ON usuario (socio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE socio ADD dni VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD apellido VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD telefono VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD domicilio TEXT NOT NULL');
        $this->addSql('ALTER TABLE socio ADD ciudad VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD activo BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT FK_2265B05DDA04E6A9');
        $this->addSql('DROP INDEX UNIQ_2265B05DDA04E6A9');
        $this->addSql('ALTER TABLE usuario DROP socio_id');
    }
}
