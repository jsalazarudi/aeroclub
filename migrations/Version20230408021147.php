<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230408021147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE piloto DROP dni');
        $this->addSql('ALTER TABLE piloto DROP nombre');
        $this->addSql('ALTER TABLE piloto DROP apellido');
        $this->addSql('ALTER TABLE piloto DROP email');
        $this->addSql('ALTER TABLE piloto DROP telefono');
        $this->addSql('ALTER TABLE piloto DROP domicilio');
        $this->addSql('ALTER TABLE piloto DROP ciudad');
        $this->addSql('ALTER TABLE piloto DROP password');
        $this->addSql('ALTER TABLE piloto DROP activo');
        $this->addSql('ALTER TABLE usuario ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D9AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D9AAD4A8D ON usuario (piloto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE piloto ADD dni VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD nombre VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD apellido VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD telefono VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD domicilio TEXT NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD ciudad VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD activo BOOLEAN NOT NULL');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT FK_2265B05D9AAD4A8D');
        $this->addSql('DROP INDEX UNIQ_2265B05D9AAD4A8D');
        $this->addSql('ALTER TABLE usuario DROP piloto_id');
    }
}
