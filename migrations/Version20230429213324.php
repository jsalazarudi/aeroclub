<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429213324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE venta ADD lista_precio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD abono_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE552CFB04B0 FOREIGN KEY (lista_precio_id) REFERENCES lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE5540AFAD54 FOREIGN KEY (abono_id) REFERENCES abono (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8FE7EE552CFB04B0 ON venta (lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE5540AFAD54 ON venta (abono_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE552CFB04B0');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE5540AFAD54');
        $this->addSql('DROP INDEX IDX_8FE7EE552CFB04B0');
        $this->addSql('DROP INDEX IDX_8FE7EE5540AFAD54');
        $this->addSql('ALTER TABLE venta DROP lista_precio_id');
        $this->addSql('ALTER TABLE venta DROP abono_id');
    }
}
