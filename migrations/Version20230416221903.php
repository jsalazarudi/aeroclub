<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416221903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a720959221f5e9');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a72095bfa13376');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a720952d5d35a3');
        $this->addSql('DROP INDEX idx_96a720952d5d35a3');
        $this->addSql('DROP INDEX idx_96a72095bfa13376');
        $this->addSql('DROP INDEX idx_96a720959221f5e9');
        $this->addSql('ALTER TABLE abono ADD tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD alumno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono DROP tesorero_id_id');
        $this->addSql('ALTER TABLE abono DROP socio_id_id');
        $this->addSql('ALTER TABLE abono DROP piloto_id_id');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A7209588CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A72095DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A720959AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A72095FC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_96A7209588CE059D ON abono (tesorero_id)');
        $this->addSql('CREATE INDEX IDX_96A72095DA04E6A9 ON abono (socio_id)');
        $this->addSql('CREATE INDEX IDX_96A720959AAD4A8D ON abono (piloto_id)');
        $this->addSql('CREATE INDEX IDX_96A72095FC28E5EE ON abono (alumno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A7209588CE059D');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A72095DA04E6A9');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A720959AAD4A8D');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A72095FC28E5EE');
        $this->addSql('DROP INDEX IDX_96A7209588CE059D');
        $this->addSql('DROP INDEX IDX_96A72095DA04E6A9');
        $this->addSql('DROP INDEX IDX_96A720959AAD4A8D');
        $this->addSql('DROP INDEX IDX_96A72095FC28E5EE');
        $this->addSql('ALTER TABLE abono ADD tesorero_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD socio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD piloto_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono DROP tesorero_id');
        $this->addSql('ALTER TABLE abono DROP socio_id');
        $this->addSql('ALTER TABLE abono DROP piloto_id');
        $this->addSql('ALTER TABLE abono DROP alumno_id');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a720959221f5e9 FOREIGN KEY (tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a72095bfa13376 FOREIGN KEY (socio_id_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a720952d5d35a3 FOREIGN KEY (piloto_id_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_96a720952d5d35a3 ON abono (piloto_id_id)');
        $this->addSql('CREATE INDEX idx_96a72095bfa13376 ON abono (socio_id_id)');
        $this->addSql('CREATE INDEX idx_96a720959221f5e9 ON abono (tesorero_id_id)');
    }
}
