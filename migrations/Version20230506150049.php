<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506150049 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a7209588ce059d');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a72095da04e6a9');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a720959aad4a8d');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT fk_96a72095fc28e5ee');
        $this->addSql('DROP INDEX idx_96a72095fc28e5ee');
        $this->addSql('DROP INDEX idx_96a720959aad4a8d');
        $this->addSql('DROP INDEX idx_96a72095da04e6a9');
        $this->addSql('DROP INDEX idx_96a7209588ce059d');
        $this->addSql('ALTER TABLE abono ADD paga_id INT NOT NULL');
        $this->addSql('ALTER TABLE abono ADD aprueba_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono DROP tesorero_id');
        $this->addSql('ALTER TABLE abono DROP socio_id');
        $this->addSql('ALTER TABLE abono DROP piloto_id');
        $this->addSql('ALTER TABLE abono DROP alumno_id');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A720958324F4B3 FOREIGN KEY (paga_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT FK_96A72095DC789B0C FOREIGN KEY (aprueba_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_96A720958324F4B3 ON abono (paga_id)');
        $this->addSql('CREATE INDEX IDX_96A72095DC789B0C ON abono (aprueba_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A720958324F4B3');
        $this->addSql('ALTER TABLE abono DROP CONSTRAINT FK_96A72095DC789B0C');
        $this->addSql('DROP INDEX IDX_96A720958324F4B3');
        $this->addSql('DROP INDEX IDX_96A72095DC789B0C');
        $this->addSql('ALTER TABLE abono ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono ADD alumno_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abono DROP paga_id');
        $this->addSql('ALTER TABLE abono RENAME COLUMN aprueba_id TO tesorero_id');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a7209588ce059d FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a72095da04e6a9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a720959aad4a8d FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE abono ADD CONSTRAINT fk_96a72095fc28e5ee FOREIGN KEY (alumno_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_96a72095fc28e5ee ON abono (alumno_id)');
        $this->addSql('CREATE INDEX idx_96a720959aad4a8d ON abono (piloto_id)');
        $this->addSql('CREATE INDEX idx_96a72095da04e6a9 ON abono (socio_id)');
        $this->addSql('CREATE INDEX idx_96a7209588ce059d ON abono (tesorero_id)');
    }
}
