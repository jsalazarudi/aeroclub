<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423210610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT fk_b608e3751fb75a3b');
        $this->addSql('DROP INDEX idx_b608e3751fb75a3b');
        $this->addSql('ALTER TABLE vuelo DROP cuenta_corriente_id');
        $this->addSql('ALTER TABLE vuelo DROP unidades_gastadas');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vuelo ADD cuenta_corriente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD unidades_gastadas DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT fk_b608e3751fb75a3b FOREIGN KEY (cuenta_corriente_id) REFERENCES cuenta_corriente (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b608e3751fb75a3b ON vuelo (cuenta_corriente_id)');
    }
}
