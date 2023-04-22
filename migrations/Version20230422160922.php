<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422160922 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7245c76e4');
        $this->addSql('DROP INDEX idx_36abb0a7245c76e4');
        $this->addSql('ALTER TABLE cuenta_corriente DROP reserva_hangar_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP deuda_remanente');
        $this->addSql('ALTER TABLE reserva_hangar ADD cuenta_corriente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C341FB75A3B FOREIGN KEY (cuenta_corriente_id) REFERENCES cuenta_corriente (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17911C341FB75A3B ON reserva_hangar (cuenta_corriente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C341FB75A3B');
        $this->addSql('DROP INDEX IDX_17911C341FB75A3B');
        $this->addSql('ALTER TABLE reserva_hangar DROP cuenta_corriente_id');
        $this->addSql('ALTER TABLE cuenta_corriente ADD reserva_hangar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD deuda_remanente INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7245c76e4 FOREIGN KEY (reserva_hangar_id) REFERENCES reserva_hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_36abb0a7245c76e4 ON cuenta_corriente (reserva_hangar_id)');
    }
}
