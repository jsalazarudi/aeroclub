<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423202029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cuenta_corriente DROP CONSTRAINT fk_36abb0a74ff34720');
        $this->addSql('DROP INDEX idx_36abb0a74ff34720');
        $this->addSql('ALTER TABLE cuenta_corriente DROP vuelo_id');
        $this->addSql('ALTER TABLE vuelo ADD cuenta_corriente_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E3751FB75A3B FOREIGN KEY (cuenta_corriente_id) REFERENCES cuenta_corriente (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B608E3751FB75A3B ON vuelo (cuenta_corriente_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E3751FB75A3B');
        $this->addSql('DROP INDEX IDX_B608E3751FB75A3B');
        $this->addSql('ALTER TABLE vuelo DROP cuenta_corriente_id');
        $this->addSql('ALTER TABLE cuenta_corriente ADD vuelo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cuenta_corriente ADD CONSTRAINT fk_36abb0a74ff34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_36abb0a74ff34720 ON cuenta_corriente (vuelo_id)');
    }
}
