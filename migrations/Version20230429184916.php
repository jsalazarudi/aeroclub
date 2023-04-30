<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429184916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vuelo ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E375DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E3759AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B608E375DA04E6A9 ON vuelo (socio_id)');
        $this->addSql('CREATE INDEX IDX_B608E3759AAD4A8D ON vuelo (piloto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E375DA04E6A9');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E3759AAD4A8D');
        $this->addSql('DROP INDEX IDX_B608E375DA04E6A9');
        $this->addSql('DROP INDEX IDX_B608E3759AAD4A8D');
        $this->addSql('ALTER TABLE vuelo DROP socio_id');
        $this->addSql('ALTER TABLE vuelo DROP piloto_id');
    }
}
