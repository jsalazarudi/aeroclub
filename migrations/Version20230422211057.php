<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422211057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT fk_17911c341fb75a3b');
        $this->addSql('DROP INDEX idx_17911c341fb75a3b');
        $this->addSql('ALTER TABLE reserva_hangar ADD abono_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva_hangar RENAME COLUMN cuenta_corriente_id TO lista_precio_id');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C342CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C3440AFAD54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_17911C342CFB04B0 ON reserva_hangar (lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_17911C3440AFAD54 ON reserva_hangar (abono_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C342CFB04B0');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C3440AFAD54');
        $this->addSql('DROP INDEX IDX_17911C342CFB04B0');
        $this->addSql('DROP INDEX IDX_17911C3440AFAD54');
        $this->addSql('ALTER TABLE reserva_hangar ADD cuenta_corriente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva_hangar DROP lista_precio_id');
        $this->addSql('ALTER TABLE reserva_hangar DROP abono_id');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT fk_17911c341fb75a3b FOREIGN KEY (cuenta_corriente_id) REFERENCES cuenta_corriente (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_17911c341fb75a3b ON reserva_hangar (cuenta_corriente_id)');
    }
}
