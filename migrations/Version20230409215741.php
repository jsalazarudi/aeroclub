<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230409215741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nota DROP CONSTRAINT fk_c8d03e0d9221f5e9');
        $this->addSql('DROP INDEX idx_c8d03e0d9221f5e9');
        $this->addSql('ALTER TABLE nota RENAME COLUMN tesorero_id_id TO tesorero_id');
        $this->addSql('ALTER TABLE nota ADD CONSTRAINT FK_C8D03E0D88CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C8D03E0D88CE059D ON nota (tesorero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE nota DROP CONSTRAINT FK_C8D03E0D88CE059D');
        $this->addSql('DROP INDEX IDX_C8D03E0D88CE059D');
        $this->addSql('ALTER TABLE nota RENAME COLUMN tesorero_id TO tesorero_id_id');
        $this->addSql('ALTER TABLE nota ADD CONSTRAINT fk_c8d03e0d9221f5e9 FOREIGN KEY (tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_c8d03e0d9221f5e9 ON nota (tesorero_id_id)');
    }
}
