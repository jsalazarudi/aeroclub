<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413023122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gasto DROP CONSTRAINT fk_ae43da149221f5e9');
        $this->addSql('DROP INDEX idx_ae43da149221f5e9');
        $this->addSql('ALTER TABLE gasto RENAME COLUMN tesorero_id_id TO tesorero_id');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT FK_AE43DA1488CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_AE43DA1488CE059D ON gasto (tesorero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gasto DROP CONSTRAINT FK_AE43DA1488CE059D');
        $this->addSql('DROP INDEX IDX_AE43DA1488CE059D');
        $this->addSql('ALTER TABLE gasto RENAME COLUMN tesorero_id TO tesorero_id_id');
        $this->addSql('ALTER TABLE gasto ADD CONSTRAINT fk_ae43da149221f5e9 FOREIGN KEY (tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ae43da149221f5e9 ON gasto (tesorero_id_id)');
    }
}
