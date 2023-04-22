<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422170814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva_hangar ADD servicio_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C3471CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17911C3471CAA3E7 ON reserva_hangar (servicio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C3471CAA3E7');
        $this->addSql('DROP INDEX IDX_17911C3471CAA3E7');
        $this->addSql('ALTER TABLE reserva_hangar DROP servicio_id');
    }
}
