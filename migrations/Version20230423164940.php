<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423164940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lista_precio ADD avion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD alumno BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE lista_precio ADD CONSTRAINT FK_A392BA6380BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A392BA6380BBB841 ON lista_precio (avion_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lista_precio DROP CONSTRAINT FK_A392BA6380BBB841');
        $this->addSql('DROP INDEX IDX_A392BA6380BBB841');
        $this->addSql('ALTER TABLE lista_precio DROP avion_id');
        $this->addSql('ALTER TABLE lista_precio DROP alumno');
    }
}
