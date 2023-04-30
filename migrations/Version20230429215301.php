<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429215301 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto_venta ADD lista_precio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto_venta ADD CONSTRAINT FK_CFC0E63F2CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CFC0E63F2CFB04B0 ON producto_venta (lista_precio_id)');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee552cfb04b0');
        $this->addSql('DROP INDEX idx_8fe7ee552cfb04b0');
        $this->addSql('ALTER TABLE venta DROP lista_precio_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE venta ADD lista_precio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee552cfb04b0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8fe7ee552cfb04b0 ON venta (lista_precio_id)');
        $this->addSql('ALTER TABLE producto_venta DROP CONSTRAINT FK_CFC0E63F2CFB04B0');
        $this->addSql('DROP INDEX IDX_CFC0E63F2CFB04B0');
        $this->addSql('ALTER TABLE producto_venta DROP lista_precio_id');
    }
}
