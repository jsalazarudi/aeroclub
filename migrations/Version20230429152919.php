<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429152919 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto_vuelo DROP CONSTRAINT fk_f62feb1f3f63963d');
        $this->addSql('ALTER TABLE producto_vuelo DROP CONSTRAINT fk_f62feb1fc580f9fb');
        $this->addSql('DROP INDEX idx_f62feb1fc580f9fb');
        $this->addSql('DROP INDEX idx_f62feb1f3f63963d');
        $this->addSql('ALTER TABLE producto_vuelo ADD producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_vuelo ADD vuelo_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_vuelo DROP producto_id_id');
        $this->addSql('ALTER TABLE producto_vuelo DROP vuelo_id_id');
        $this->addSql('ALTER TABLE producto_vuelo ADD CONSTRAINT FK_F62FEB1F7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producto_vuelo ADD CONSTRAINT FK_F62FEB1F4FF34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F62FEB1F7645698E ON producto_vuelo (producto_id)');
        $this->addSql('CREATE INDEX IDX_F62FEB1F4FF34720 ON producto_vuelo (vuelo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE producto_vuelo DROP CONSTRAINT FK_F62FEB1F7645698E');
        $this->addSql('ALTER TABLE producto_vuelo DROP CONSTRAINT FK_F62FEB1F4FF34720');
        $this->addSql('DROP INDEX IDX_F62FEB1F7645698E');
        $this->addSql('DROP INDEX IDX_F62FEB1F4FF34720');
        $this->addSql('ALTER TABLE producto_vuelo ADD producto_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_vuelo ADD vuelo_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_vuelo DROP producto_id');
        $this->addSql('ALTER TABLE producto_vuelo DROP vuelo_id');
        $this->addSql('ALTER TABLE producto_vuelo ADD CONSTRAINT fk_f62feb1f3f63963d FOREIGN KEY (producto_id_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producto_vuelo ADD CONSTRAINT fk_f62feb1fc580f9fb FOREIGN KEY (vuelo_id_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f62feb1fc580f9fb ON producto_vuelo (vuelo_id_id)');
        $this->addSql('CREATE INDEX idx_f62feb1f3f63963d ON producto_vuelo (producto_id_id)');
    }
}
