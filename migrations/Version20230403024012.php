<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403024012 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE curso DROP CONSTRAINT fk_ca3b40ecd3819735');
        $this->addSql('DROP INDEX uniq_ca3b40ecd3819735');
        $this->addSql('ALTER TABLE curso RENAME COLUMN alumno_id_id TO alumno_id');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT FK_CA3B40ECFC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CA3B40ECFC28E5EE ON curso (alumno_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE curso DROP CONSTRAINT FK_CA3B40ECFC28E5EE');
        $this->addSql('DROP INDEX IDX_CA3B40ECFC28E5EE');
        $this->addSql('ALTER TABLE curso RENAME COLUMN alumno_id TO alumno_id_id');
        $this->addSql('ALTER TABLE curso ADD CONSTRAINT fk_ca3b40ecd3819735 FOREIGN KEY (alumno_id_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_ca3b40ecd3819735 ON curso (alumno_id_id)');
    }
}
