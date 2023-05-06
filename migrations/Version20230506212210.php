<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506212210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee5572a3f832');
        $this->addSql('DROP INDEX idx_8fe7ee5572a3f832');
        $this->addSql('ALTER TABLE venta DROP aprobada_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE venta ADD aprobada_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee5572a3f832 FOREIGN KEY (aprobada_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8fe7ee5572a3f832 ON venta (aprobada_id)');
    }
}
