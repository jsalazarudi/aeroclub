<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230422172025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mensualidad_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mensualidad (id INT NOT NULL, socio_id INT NOT NULL, servicio_id INT NOT NULL, hasta DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F84F44FDA04E6A9 ON mensualidad (socio_id)');
        $this->addSql('CREATE INDEX IDX_6F84F44F71CAA3E7 ON mensualidad (servicio_id)');
        $this->addSql('ALTER TABLE mensualidad ADD CONSTRAINT FK_6F84F44FDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mensualidad ADD CONSTRAINT FK_6F84F44F71CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE mensualidad_id_seq CASCADE');
        $this->addSql('ALTER TABLE mensualidad DROP CONSTRAINT FK_6F84F44FDA04E6A9');
        $this->addSql('ALTER TABLE mensualidad DROP CONSTRAINT FK_6F84F44F71CAA3E7');
        $this->addSql('DROP TABLE mensualidad');
    }
}
