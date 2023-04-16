<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416215159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT fk_a392ba6374855384');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT fk_a392ba633477c7e0');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT fk_a392ba633f63963d');
        $this->addSql('DROP INDEX idx_a392ba633f63963d');
        $this->addSql('DROP INDEX idx_a392ba633477c7e0');
        $this->addSql('DROP INDEX idx_a392ba6374855384');
        $this->addSql('ALTER TABLE lista_precio ADD historial_lista_precio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD servicio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD producto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio DROP historial_lista_precio_id_id');
        $this->addSql('ALTER TABLE lista_precio DROP servicio_id_id');
        $this->addSql('ALTER TABLE lista_precio DROP producto_id_id');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT FK_A392BA634EDAF362 FOREIGN KEY (historial_lista_precio_id) REFERENCES historial_lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT FK_A392BA6371CAA3E7 FOREIGN KEY (servicio_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT FK_A392BA637645698E FOREIGN KEY (producto_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A392BA634EDAF362 ON lista_precio (historial_lista_precio_id)');
        $this->addSql('CREATE INDEX IDX_A392BA6371CAA3E7 ON lista_precio (servicio_id)');
        $this->addSql('CREATE INDEX IDX_A392BA637645698E ON lista_precio (producto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT FK_A392BA634EDAF362');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT FK_A392BA6371CAA3E7');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT FK_A392BA637645698E');
        $this->addSql('DROP INDEX IDX_A392BA634EDAF362');
        $this->addSql('DROP INDEX IDX_A392BA6371CAA3E7');
        $this->addSql('DROP INDEX IDX_A392BA637645698E');
        $this->addSql('ALTER TABLE lista_precio ADD historial_lista_precio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD servicio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD producto_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio DROP historial_lista_precio_id');
        $this->addSql('ALTER TABLE lista_precio DROP servicio_id');
        $this->addSql('ALTER TABLE lista_precio DROP producto_id');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT fk_a392ba6374855384 FOREIGN KEY (historial_lista_precio_id_id) REFERENCES historial_lista_precio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT fk_a392ba633477c7e0 FOREIGN KEY (servicio_id_id) REFERENCES servicio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT fk_a392ba633f63963d FOREIGN KEY (producto_id_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a392ba633f63963d ON lista_precio (producto_id_id)');
        $this->addSql('CREATE INDEX idx_a392ba633477c7e0 ON lista_precio (servicio_id_id)');
        $this->addSql('CREATE INDEX idx_a392ba6374855384 ON lista_precio (historial_lista_precio_id_id)');
    }
}
