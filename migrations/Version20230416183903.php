<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416183903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE unidades_pago DROP CONSTRAINT fk_be00c5073477c7e0');
        $this->addSql('DROP INDEX idx_be00c5073477c7e0');
        $this->addSql('ALTER TABLE unidades_pago RENAME COLUMN servicio_id_id TO servicio_id');
        $this->addSql('ALTER TABLE unidades_pago ADD CONSTRAINT FK_BE00C50771CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BE00C50771CAA3E7 ON unidades_pago (servicio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE unidades_pago DROP CONSTRAINT FK_BE00C50771CAA3E7');
        $this->addSql('DROP INDEX IDX_BE00C50771CAA3E7');
        $this->addSql('ALTER TABLE unidades_pago RENAME COLUMN servicio_id TO servicio_id_id');
        $this->addSql('ALTER TABLE unidades_pago ADD CONSTRAINT fk_be00c5073477c7e0 FOREIGN KEY (servicio_id_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_be00c5073477c7e0 ON unidades_pago (servicio_id_id)');
    }
}
