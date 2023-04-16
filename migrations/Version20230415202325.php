<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415202325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT fk_188d2e3b2d5d35a3');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT fk_188d2e3bbfa13376');
        $this->addSql('DROP INDEX idx_188d2e3bbfa13376');
        $this->addSql('DROP INDEX idx_188d2e3b2d5d35a3');
        $this->addSql('ALTER TABLE reserva ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva DROP piloto_id_id');
        $this->addSql('ALTER TABLE reserva DROP socio_id_id');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B9AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_188D2E3B9AAD4A8D ON reserva (piloto_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BDA04E6A9 ON reserva (socio_id)');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT fk_17911c34e83688ee');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT fk_17911c3410f5ff80');
        $this->addSql('DROP INDEX idx_17911c3410f5ff80');
        $this->addSql('DROP INDEX uniq_17911c34e83688ee');
        $this->addSql('ALTER TABLE reserva_hangar ADD reserva_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_hangar ADD hangar_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_hangar DROP reserva_id_id');
        $this->addSql('ALTER TABLE reserva_hangar DROP hangar_id_id');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C34D67139E8 FOREIGN KEY (reserva_id) REFERENCES reserva (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT FK_17911C342FEFB5A5 FOREIGN KEY (hangar_id) REFERENCES hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17911C34D67139E8 ON reserva_hangar (reserva_id)');
        $this->addSql('CREATE INDEX IDX_17911C342FEFB5A5 ON reserva_hangar (hangar_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3B9AAD4A8D');
        $this->addSql('ALTER TABLE reserva DROP CONSTRAINT FK_188D2E3BDA04E6A9');
        $this->addSql('DROP INDEX IDX_188D2E3B9AAD4A8D');
        $this->addSql('DROP INDEX IDX_188D2E3BDA04E6A9');
        $this->addSql('ALTER TABLE reserva ADD piloto_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva ADD socio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reserva DROP piloto_id');
        $this->addSql('ALTER TABLE reserva DROP socio_id');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT fk_188d2e3b2d5d35a3 FOREIGN KEY (piloto_id_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT fk_188d2e3bbfa13376 FOREIGN KEY (socio_id_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_188d2e3bbfa13376 ON reserva (socio_id_id)');
        $this->addSql('CREATE INDEX idx_188d2e3b2d5d35a3 ON reserva (piloto_id_id)');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C34D67139E8');
        $this->addSql('ALTER TABLE reserva_hangar DROP CONSTRAINT FK_17911C342FEFB5A5');
        $this->addSql('DROP INDEX UNIQ_17911C34D67139E8');
        $this->addSql('DROP INDEX IDX_17911C342FEFB5A5');
        $this->addSql('ALTER TABLE reserva_hangar ADD reserva_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_hangar ADD hangar_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva_hangar DROP reserva_id');
        $this->addSql('ALTER TABLE reserva_hangar DROP hangar_id');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT fk_17911c34e83688ee FOREIGN KEY (reserva_id_id) REFERENCES reserva (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reserva_hangar ADD CONSTRAINT fk_17911c3410f5ff80 FOREIGN KEY (hangar_id_id) REFERENCES hangar (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_17911c3410f5ff80 ON reserva_hangar (hangar_id_id)');
        $this->addSql('CREATE UNIQUE INDEX uniq_17911c34e83688ee ON reserva_hangar (reserva_id_id)');
    }
}
