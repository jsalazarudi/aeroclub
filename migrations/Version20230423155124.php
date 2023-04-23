<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423155124 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD lista_precio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD servicio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD abono_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD CONSTRAINT FK_27912D5D2CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD CONSTRAINT FK_27912D5D71CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD CONSTRAINT FK_27912D5D40AFAD54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_27912D5D2CFB04B0 ON movimiento_cuenta_vuelo (lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_27912D5D71CAA3E7 ON movimiento_cuenta_vuelo (servicio_id)');
        $this->addSql('CREATE INDEX IDX_27912D5D40AFAD54 ON movimiento_cuenta_vuelo (abono_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP CONSTRAINT FK_27912D5D2CFB04B0');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP CONSTRAINT FK_27912D5D71CAA3E7');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP CONSTRAINT FK_27912D5D40AFAD54');
        $this->addSql('DROP INDEX IDX_27912D5D2CFB04B0');
        $this->addSql('DROP INDEX IDX_27912D5D71CAA3E7');
        $this->addSql('DROP INDEX IDX_27912D5D40AFAD54');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP lista_precio_id');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP servicio_id');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP abono_id');
    }
}
