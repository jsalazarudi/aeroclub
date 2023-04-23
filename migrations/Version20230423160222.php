<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423160222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_corriente ADD vuelo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD reserva_hangar_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD unidades_gastadas INT NOT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A74FF34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT FK_36ABB0A7245C76E4 FOREIGN KEY (reserva_hangar_id) REFERENCES reserva_hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_36ABB0A74FF34720 ON cuenta_corriente (vuelo_id)');
        $this->addSql('CREATE INDEX IDX_36ABB0A7245C76E4 ON cuenta_corriente (reserva_hangar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A74FF34720');
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT FK_36ABB0A7245C76E4');
        $this->addSql('DROP INDEX IDX_36ABB0A74FF34720');
        $this->addSql('DROP INDEX IDX_36ABB0A7245C76E4');
        $this->addSql('ALTER TABLE cuenta_corriente DROP vuelo_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP reserva_hangar_id');
        $this->addSql('ALTER TABLE cuenta_corriente DROP unidades_gastadas');
    }
}
