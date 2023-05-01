<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230501165412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE pago_mensualidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE pago_mensualidad (id INT NOT NULL, lista_precio_id INT DEFAULT NULL, abono_id INT DEFAULT NULL, mensualidad_id INT DEFAULT NULL, fecha TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4267CC1B2CFB04B0 ON pago_mensualidad (lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_4267CC1B40AFAD54 ON pago_mensualidad (abono_id)');
        $this->addSql('CREATE INDEX IDX_4267CC1B87826C22 ON pago_mensualidad (mensualidad_id)');
        $this->addSql('ALTER TABLE pago_mensualidad ADD CONSTRAINT FK_4267CC1B2CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pago_mensualidad ADD CONSTRAINT FK_4267CC1B40AFAD54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE pago_mensualidad ADD CONSTRAINT FK_4267CC1B87826C22 FOREIGN KEY (mensualidad_id) REFERENCES mensualidad (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE pago_mensualidad_id_seq CASCADE');
        $this->addSql('ALTER TABLE pago_mensualidad DROP CONSTRAINT FK_4267CC1B2CFB04B0');
        $this->addSql('ALTER TABLE pago_mensualidad DROP CONSTRAINT FK_4267CC1B40AFAD54');
        $this->addSql('ALTER TABLE pago_mensualidad DROP CONSTRAINT FK_4267CC1B87826C22');
        $this->addSql('DROP TABLE pago_mensualidad');
    }
}
