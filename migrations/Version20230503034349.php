<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230503034349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE cuenta_corriente_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE instructor_vuelo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE unidades_pago_id_seq CASCADE');
        $this->addSql('ALTER TABLE instructor_vuelo DROP CONSTRAINT fk_64da0439ad96791b');
        $this->addSql('ALTER TABLE instructor_vuelo DROP CONSTRAINT fk_64da0439c580f9fb');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7a50781c9');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a72cfb04b0');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a740afad54');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7f2a5805d');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a771caa3e7');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a7245c76e4');
        $this->addSql('ALTER TABLE unidades_pago DROP CONSTRAINT fk_be00c50771caa3e7');
        $this->addSql('DROP TABLE instructor_vuelo');
        $this->addSql('DROP TABLE cuenta_corriente');
        $this->addSql('DROP TABLE unidades_pago');
        $this->addSql('ALTER TABLE usuario DROP activo');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE cuenta_corriente_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE instructor_vuelo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE unidades_pago_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE instructor_vuelo (id INT NOT NULL, instructor_id_id INT NOT NULL, vuelo_id_id INT NOT NULL, unidades_pagar INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_64da0439c580f9fb ON instructor_vuelo (vuelo_id_id)');
        $this->addSql('CREATE INDEX idx_64da0439ad96791b ON instructor_vuelo (instructor_id_id)');
        $this->addSql('CREATE TABLE cuenta_corriente (id INT NOT NULL, movimiento_cuenta_vuelo_id INT DEFAULT NULL, lista_precio_id INT NOT NULL, abono_id INT NOT NULL, venta_id INT DEFAULT NULL, servicio_id INT NOT NULL, reserva_hangar_id INT DEFAULT NULL, fecha TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, unidades_gastadas INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_36abb0a7245c76e4 ON cuenta_corriente (reserva_hangar_id)');
        $this->addSql('CREATE INDEX idx_36abb0a771caa3e7 ON cuenta_corriente (servicio_id)');
        $this->addSql('CREATE INDEX idx_36abb0a7f2a5805d ON cuenta_corriente (venta_id)');
        $this->addSql('CREATE INDEX idx_36abb0a740afad54 ON cuenta_corriente (abono_id)');
        $this->addSql('CREATE INDEX idx_36abb0a72cfb04b0 ON cuenta_corriente (lista_precio_id)');
        $this->addSql('CREATE INDEX idx_36abb0a7a50781c9 ON cuenta_corriente (movimiento_cuenta_vuelo_id)');
        $this->addSql('CREATE TABLE unidades_pago (id INT NOT NULL, servicio_id INT NOT NULL, unidad_relativa INT NOT NULL, fecha TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_be00c50771caa3e7 ON unidades_pago (servicio_id)');
        $this->addSql('ALTER TABLE instructor_vuelo ADD CONSTRAINT fk_64da0439ad96791b FOREIGN KEY (instructor_id_id) REFERENCES instructor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE instructor_vuelo ADD CONSTRAINT fk_64da0439c580f9fb FOREIGN KEY (vuelo_id_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7a50781c9 FOREIGN KEY (movimiento_cuenta_vuelo_id) REFERENCES movimiento_cuenta_vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a72cfb04b0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a740afad54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7f2a5805d FOREIGN KEY (venta_id) REFERENCES venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a771caa3e7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a7245c76e4 FOREIGN KEY (reserva_hangar_id) REFERENCES reserva_hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE unidades_pago ADD CONSTRAINT fk_be00c50771caa3e7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario ADD activo BOOLEAN NOT NULL');
    }
}
