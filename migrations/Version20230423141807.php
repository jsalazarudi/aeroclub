<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423141807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT fk_1435d52ddb969fd1');
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT fk_1435d52de3767ac7');
        $this->addSql('DROP INDEX idx_1435d52de3767ac7');
        $this->addSql('DROP INDEX idx_1435d52ddb969fd1');
        $this->addSql('ALTER TABLE alumno ADD habilitado_por_instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno ADD habilitado_por_tesorero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_instructor_id_id');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_tesorero_id_id');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52D6A4566D7 FOREIGN KEY (habilitado_por_instructor_id) REFERENCES instructor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT FK_1435D52D7549B40E FOREIGN KEY (habilitado_por_tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1435D52D6A4566D7 ON alumno (habilitado_por_instructor_id)');
        $this->addSql('CREATE INDEX IDX_1435D52D7549B40E ON alumno (habilitado_por_tesorero_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT FK_1435D52D6A4566D7');
        $this->addSql('ALTER TABLE alumno DROP CONSTRAINT FK_1435D52D7549B40E');
        $this->addSql('DROP INDEX IDX_1435D52D6A4566D7');
        $this->addSql('DROP INDEX IDX_1435D52D7549B40E');
        $this->addSql('ALTER TABLE alumno ADD habilitado_por_instructor_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno ADD habilitado_por_tesorero_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_instructor_id');
        $this->addSql('ALTER TABLE alumno DROP habilitado_por_tesorero_id');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT fk_1435d52ddb969fd1 FOREIGN KEY (habilitado_por_instructor_id_id) REFERENCES instructor (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE alumno ADD CONSTRAINT fk_1435d52de3767ac7 FOREIGN KEY (habilitado_por_tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1435d52de3767ac7 ON alumno (habilitado_por_tesorero_id_id)');
        $this->addSql('CREATE INDEX idx_1435d52ddb969fd1 ON alumno (habilitado_por_instructor_id_id)');
    }
}
