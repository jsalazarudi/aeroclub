<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429011427 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva_vuelo DROP CONSTRAINT fk_217af5cc67b66cf3');
        $this->addSql('ALTER TABLE reserva_vuelo DROP CONSTRAINT fk_217af5cce83688ee');
        $this->addSql('DROP INDEX uniq_217af5cce83688ee');
        $this->addSql('DROP INDEX idx_217af5cc67b66cf3');
        $this->addSql('ALTER TABLE reserva_vuelo ADD avion_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_vuelo ADD reserva_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_vuelo DROP avion_id_id');
        $this->addSql('ALTER TABLE reserva_vuelo DROP reserva_id_id');
        $this->addSql('ALTER TABLE reserva_vuelo ADD CONSTRAINT FK_217AF5CC80BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva_vuelo ADD CONSTRAINT FK_217AF5CCD67139E8 FOREIGN KEY (reserva_id) REFERENCES reserva (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_217AF5CC80BBB841 ON reserva_vuelo (avion_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_217AF5CCD67139E8 ON reserva_vuelo (reserva_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reserva_vuelo DROP CONSTRAINT FK_217AF5CC80BBB841');
        $this->addSql('ALTER TABLE reserva_vuelo DROP CONSTRAINT FK_217AF5CCD67139E8');
        $this->addSql('DROP INDEX IDX_217AF5CC80BBB841');
        $this->addSql('DROP INDEX UNIQ_217AF5CCD67139E8');
        $this->addSql('ALTER TABLE reserva_vuelo ADD avion_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_vuelo ADD reserva_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_vuelo DROP avion_id');
        $this->addSql('ALTER TABLE reserva_vuelo DROP reserva_id');
        $this->addSql('ALTER TABLE reserva_vuelo ADD CONSTRAINT fk_217af5cc67b66cf3 FOREIGN KEY (avion_id_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva_vuelo ADD CONSTRAINT fk_217af5cce83688ee FOREIGN KEY (reserva_id_id) REFERENCES reserva (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_217af5cce83688ee ON reserva_vuelo (reserva_id_id)');
        $this->addSql('CREATE INDEX idx_217af5cc67b66cf3 ON reserva_vuelo (avion_id_id)');
    }
}
