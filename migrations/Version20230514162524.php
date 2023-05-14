<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230514162524 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_stock ADD producto_venta_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT FK_4AEEC2D0DA36F188 FOREIGN KEY (producto_venta_id) REFERENCES producto_venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4AEEC2D0DA36F188 ON movimiento_stock (producto_venta_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT FK_4AEEC2D0DA36F188');
        $this->addSql('DROP INDEX UNIQ_4AEEC2D0DA36F188');
        $this->addSql('ALTER TABLE movimiento_stock DROP producto_venta_id');
    }
}
