<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506170417 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT fk_1435d52d6a4566d7');
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT fk_1435d52d7549b40e');
        $this->addSql('DROP INDEX idx_1435d52d7549b40e');
        $this->addSql('DROP INDEX idx_1435d52d6a4566d7');
        $this->addSql('ALTER TABLE alumno ADD aprobado_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_instructor_id');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_tesorero_id');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52D927C8F01 FOREIGN KEY (aprobado_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1435D52D927C8F01 ON alumno (aprobado_id)');
        $this->addSql('ALTER TABLE curso DROP CONSTRAINT FK_CA3B40ECFC28E5EE');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT FK_CA3B40ECFC28E5EE FOREIGN KEY (alumno_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT fk_4aeec2d088ce059d');
        $this->addSql('DROP INDEX idx_4aeec2d088ce059d');
        $this->addSql('ALTER TABLE movimiento_stock ADD realizado_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_stock DROP tesorero_id');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT FK_4AEEC2D0C4B63C70 FOREIGN KEY (realizado_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4AEEC2D0C4B63C70 ON movimiento_stock (realizado_id)');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT fk_188d2e3b9aad4a8d');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT fk_188d2e3bda04e6a9');
        $this->addSql('DROP INDEX idx_188d2e3bda04e6a9');
        $this->addSql('DROP INDEX idx_188d2e3b9aad4a8d');
        $this->addSql('ALTER TABLE reserva ADD usuario_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva DROP piloto_id');
        $this->addSql('ALTER TABLE reserva DROP socio_id');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_188D2E3BDB38439E ON reserva (usuario_id)');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee55da04e6a9');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee559aad4a8d');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT fk_8fe7ee5588ce059d');
        $this->addSql('DROP INDEX idx_8fe7ee5588ce059d');
        $this->addSql('DROP INDEX idx_8fe7ee559aad4a8d');
        $this->addSql('DROP INDEX idx_8fe7ee55da04e6a9');
        $this->addSql('ALTER TABLE venta ADD aprobada_id INT NOT NULL');
        $this->addSql('ALTER TABLE venta ADD realizada_id INT NOT NULL');
        $this->addSql('ALTER TABLE venta DROP socio_id');
        $this->addSql('ALTER TABLE venta DROP piloto_id');
        $this->addSql('ALTER TABLE venta DROP tesorero_id');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE5572A3F832 FOREIGN KEY (aprobada_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE5524694B43 FOREIGN KEY (realizada_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8FE7EE5572A3F832 ON venta (aprobada_id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE5524694B43 ON venta (realizada_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT FK_1435D52D927C8F01');
        $this->addSql('DROP INDEX IDX_1435D52D927C8F01');
        $this->addSql('ALTER TABLE alumno ADD habilitado_por_tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno RENAME COLUMN aprobado_id TO habilitado_por_instructor_id');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT fk_1435d52d6a4566d7 FOREIGN KEY (habilitado_por_instructor_id) REFERENCES instructor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT fk_1435d52d7549b40e FOREIGN KEY (habilitado_por_tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1435d52d7549b40e ON alumno (habilitado_por_tesorero_id)');
        $this->addSql('CREATE INDEX idx_1435d52d6a4566d7 ON alumno (habilitado_por_instructor_id)');
        $this->addSql('ALTER TABLE curso DROP CONSTRAINT fk_ca3b40ecfc28e5ee');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT fk_ca3b40ecfc28e5ee FOREIGN KEY (alumno_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT FK_4AEEC2D0C4B63C70');
        $this->addSql('DROP INDEX IDX_4AEEC2D0C4B63C70');
        $this->addSql('ALTER TABLE movimiento_stock ADD tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE movimiento_stock DROP realizado_id');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT fk_4aeec2d088ce059d FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4aeec2d088ce059d ON movimiento_stock (tesorero_id)');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE5572A3F832');
        $this->addSql('ALTER TABLE venta DROP CONSTRAINT FK_8FE7EE5524694B43');
        $this->addSql('DROP INDEX IDX_8FE7EE5572A3F832');
        $this->addSql('DROP INDEX IDX_8FE7EE5524694B43');
        $this->addSql('ALTER TABLE venta ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta ADD tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta DROP aprobada_id');
        $this->addSql('ALTER TABLE venta DROP realizada_id');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee55da04e6a9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee559aad4a8d FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT fk_8fe7ee5588ce059d FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8fe7ee5588ce059d ON venta (tesorero_id)');
        $this->addSql('CREATE INDEX idx_8fe7ee559aad4a8d ON venta (piloto_id)');
        $this->addSql('CREATE INDEX idx_8fe7ee55da04e6a9 ON venta (socio_id)');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3BDB38439E');
        $this->addSql('DROP INDEX IDX_188D2E3BDB38439E');
        $this->addSql('ALTER TABLE reserva ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva DROP usuario_id');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT fk_188d2e3b9aad4a8d FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT fk_188d2e3bda04e6a9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_188d2e3bda04e6a9 ON reserva (socio_id)');
        $this->addSql('CREATE INDEX idx_188d2e3b9aad4a8d ON reserva (piloto_id)');
    }
}
