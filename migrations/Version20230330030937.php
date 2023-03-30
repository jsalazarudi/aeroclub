<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330030937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alumno ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instructor ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE piloto ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE socio ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tesorero ADD password VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE piloto DROP password');
        $this->addSql('ALTER TABLE alumno DROP password');
        $this->addSql('ALTER TABLE instructor DROP password');
        $this->addSql('ALTER TABLE tesorero DROP password');
        $this->addSql('ALTER TABLE socio DROP password');
    }
}
