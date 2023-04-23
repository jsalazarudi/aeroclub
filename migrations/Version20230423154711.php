<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423154711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP CONSTRAINT fk_27912d5dc580f9fb');
        $this->addSql('DROP INDEX uniq_27912d5dc580f9fb');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo RENAME COLUMN vuelo_id_id TO vuelo_id');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD CONSTRAINT FK_27912D5D4FF34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_27912D5D4FF34720 ON movimiento_cuenta_vuelo (vuelo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo DROP CONSTRAINT FK_27912D5D4FF34720');
        $this->addSql('DROP INDEX UNIQ_27912D5D4FF34720');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo RENAME COLUMN vuelo_id TO vuelo_id_id');
        $this->addSql('ALTER TABLE movimiento_cuenta_vuelo ADD CONSTRAINT fk_27912d5dc580f9fb FOREIGN KEY (vuelo_id_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_27912d5dc580f9fb ON movimiento_cuenta_vuelo (vuelo_id_id)');
    }
}
