<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407181727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE usuario_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE usuario (id INT NOT NULL, tesorero_id INT DEFAULT NULL, alumno_id INT DEFAULT NULL, dni VARCHAR(50) NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, telefono VARCHAR(255) NOT NULL, domicilio TEXT NOT NULL, ciudad VARCHAR(255) NOT NULL, activo BOOLEAN NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05D88CE059D ON usuario (tesorero_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2265B05DFC28E5EE ON usuario (alumno_id)');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D88CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05DFC28E5EE FOREIGN KEY (alumno_id) REFERENCES alumno (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE usuario_id_seq CASCADE');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT FK_2265B05D88CE059D');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT FK_2265B05DFC28E5EE');
        $this->addSql('DROP TABLE usuario');
    }
}
