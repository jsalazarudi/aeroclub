<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429204936 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE producto_venta DROP CONSTRAINT fk_cfc0e63f3f63963d');
        $this->addSql('ALTER TABLE producto_venta DROP CONSTRAINT fk_cfc0e63f9f1ab70d');
        $this->addSql('DROP INDEX idx_cfc0e63f9f1ab70d');
        $this->addSql('DROP INDEX idx_cfc0e63f3f63963d');
        $this->addSql('ALTER TABLE producto_venta ADD producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_venta ADD venta_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_venta DROP producto_id_id');
        $this->addSql('ALTER TABLE producto_venta DROP venta_id_id');
        $this->addSql('ALTER TABLE producto_venta ADD CONSTRAINT FK_CFC0E63F7645698E FOREIGN KEY (producto_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producto_venta ADD CONSTRAINT FK_CFC0E63FF2A5805D FOREIGN KEY (venta_id) REFERENCES venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CFC0E63F7645698E ON producto_venta (producto_id)');
        $this->addSql('CREATE INDEX IDX_CFC0E63FF2A5805D ON producto_venta (venta_id)');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee55bfa13376');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee552d5d35a3');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee559221f5e9');
        $this->addSql('DROP INDEX idx_8fe7ee559221f5e9');
        $this->addSql('DROP INDEX idx_8fe7ee552d5d35a3');
        $this->addSql('DROP INDEX idx_8fe7ee55bfa13376');
        $this->addSql('ALTER TABLE venta ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta DROP socio_id_id');
        $this->addSql('ALTER TABLE venta DROP piloto_id_id');
        $this->addSql('ALTER TABLE venta DROP tesorero_id_id');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE559AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE5588CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8FE7EE55DA04E6A9 ON venta (socio_id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE559AAD4A8D ON venta (piloto_id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE5588CE059D ON venta (tesorero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE producto_venta DROP CONSTRAINT FK_CFC0E63F7645698E');
        $this->addSql('ALTER TABLE producto_venta DROP CONSTRAINT FK_CFC0E63FF2A5805D');
        $this->addSql('DROP INDEX IDX_CFC0E63F7645698E');
        $this->addSql('DROP INDEX IDX_CFC0E63FF2A5805D');
        $this->addSql('ALTER TABLE producto_venta ADD producto_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_venta ADD venta_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE producto_venta DROP producto_id');
        $this->addSql('ALTER TABLE producto_venta DROP venta_id');
        $this->addSql('ALTER TABLE producto_venta ADD CONSTRAINT fk_cfc0e63f3f63963d FOREIGN KEY (producto_id_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE producto_venta ADD CONSTRAINT fk_cfc0e63f9f1ab70d FOREIGN KEY (venta_id_id) REFERENCES venta (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_cfc0e63f9f1ab70d ON producto_venta (venta_id_id)');
        $this->addSql('CREATE INDEX idx_cfc0e63f3f63963d ON producto_venta (producto_id_id)');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE55DA04E6A9');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE559AAD4A8D');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE5588CE059D');
        $this->addSql('DROP INDEX IDX_8FE7EE55DA04E6A9');
        $this->addSql('DROP INDEX IDX_8FE7EE559AAD4A8D');
        $this->addSql('DROP INDEX IDX_8FE7EE5588CE059D');
        $this->addSql('ALTER TABLE venta ADD socio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD piloto_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD tesorero_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta DROP socio_id');
        $this->addSql('ALTER TABLE venta DROP piloto_id');
        $this->addSql('ALTER TABLE venta DROP tesorero_id');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee55bfa13376 FOREIGN KEY (socio_id_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee552d5d35a3 FOREIGN KEY (piloto_id_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee559221f5e9 FOREIGN KEY (tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8fe7ee559221f5e9 ON venta (tesorero_id_id)');
        $this->addSql('CREATE INDEX idx_8fe7ee552d5d35a3 ON venta (piloto_id_id)');
        $this->addSql('CREATE INDEX idx_8fe7ee55bfa13376 ON venta (socio_id_id)');
    }
}
