<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416224401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a744c354f3');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7ed1cd59c');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a750343fc1');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a79f1ab70d');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a73477c7e0');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7d3127ec7');
        $this->addSql('DROP INDEX idx_36abb0a7d3127ec7');
        $this->addSql('DROP INDEX idx_36abb0a73477c7e0');
        $this->addSql('DROP INDEX idx_36abb0a79f1ab70d');
        $this->addSql('DROP INDEX idx_36abb0a750343fc1');
        $this->addSql('DROP INDEX idx_36abb0a7ed1cd59c');
        $this->addSql('DROP INDEX idx_36abb0a744c354f3');
        $this->addSql('ALTER TABLE cuenta_corriente ADD movimiento_cuenta_vuelo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD lista_precio_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD abono_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD venta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD servicio_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD reserva_hangar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente DROP movimiento_cuenta_vuelo_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP lista_precio_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP abono_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP venta_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP servicio_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP reserva_hangar_id_id');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A7A50781C9 FOREIGN KEY (movimiento_cuenta_vuelo_id) REFERENCES movimiento_cuenta_vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A72CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A740AFAD54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A7F2A5805D FOREIGN KEY (venta_id) REFERENCES venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A771CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A7245C76E4 FOREIGN KEY (reserva_hangar_id) REFERENCES reserva_hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_36ABB0A7A50781C9 ON cuenta_corriente (movimiento_cuenta_vuelo_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A72CFB04B0 ON cuenta_corriente (lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A740AFAD54 ON cuenta_corriente (abono_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A7F2A5805D ON cuenta_corriente (venta_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A771CAA3E7 ON cuenta_corriente (servicio_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A7245C76E4 ON cuenta_corriente (reserva_hangar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A7A50781C9');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A72CFB04B0');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A740AFAD54');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A7F2A5805D');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A771CAA3E7');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A7245C76E4');
        $this->addSql('DROP INDEX IDX_36ABB0A7A50781C9');
        $this->addSql('DROP INDEX IDX_36ABB0A72CFB04B0');
        $this->addSql('DROP INDEX IDX_36ABB0A740AFAD54');
        $this->addSql('DROP INDEX IDX_36ABB0A7F2A5805D');
        $this->addSql('DROP INDEX IDX_36ABB0A771CAA3E7');
        $this->addSql('DROP INDEX IDX_36ABB0A7245C76E4');
        $this->addSql('ALTER TABLE cuenta_corriente ADD movimiento_cuenta_vuelo_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD lista_precio_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD abono_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD venta_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD servicio_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD reserva_hangar_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente DROP movimiento_cuenta_vuelo_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP lista_precio_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP abono_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP venta_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP servicio_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP reserva_hangar_id');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a744c354f3 FOREIGN KEY (movimiento_cuenta_vuelo_id_id) REFERENCES movimiento_cuenta_vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7ed1cd59c FOREIGN KEY (lista_precio_id_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a750343fc1 FOREIGN KEY (abono_id_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a79f1ab70d FOREIGN KEY (venta_id_id) REFERENCES venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a73477c7e0 FOREIGN KEY (servicio_id_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7d3127ec7 FOREIGN KEY (reserva_hangar_id_id) REFERENCES reserva_hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_36abb0a7d3127ec7 ON cuenta_corriente (reserva_hangar_id_id)');
        $this->addSql('CREATE INDEX idx_36abb0a73477c7e0 ON cuenta_corriente (servicio_id_id)');
        $this->addSql('CREATE INDEX idx_36abb0a79f1ab70d ON cuenta_corriente (venta_id_id)');
        $this->addSql('CREATE INDEX idx_36abb0a750343fc1 ON cuenta_corriente (abono_id_id)');
        $this->addSql('CREATE INDEX idx_36abb0a7ed1cd59c ON cuenta_corriente (lista_precio_id_id)');
        $this->addSql('CREATE INDEX idx_36abb0a744c354f3 ON cuenta_corriente (movimiento_cuenta_vuelo_id_id)');
    }
}
