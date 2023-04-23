<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230423152008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT fk_b608e375771b9d4d');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT fk_b608e375bfa13376');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT fk_b608e3752d5d35a3');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT fk_b608e37567b66cf3');
        $this->addSql('DROP INDEX idx_b608e37567b66cf3');
        $this->addSql('DROP INDEX idx_b608e3752d5d35a3');
        $this->addSql('DROP INDEX idx_b608e375bfa13376');
        $this->addSql('DROP INDEX idx_b608e375771b9d4d');
        $this->addSql('ALTER TABLE vuelo ADD curso_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD socio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD piloto_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo DROP curso_id_id');
        $this->addSql('ALTER TABLE vuelo DROP socio_id_id');
        $this->addSql('ALTER TABLE vuelo DROP piloto_id_id');
        $this->addSql('ALTER TABLE vuelo RENAME COLUMN avion_id_id TO avion_id');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E37587CB4A1F FOREIGN KEY (curso_id) REFERENCES curso (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E375DA04E6A9 FOREIGN KEY (socio_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E3759AAD4A8D FOREIGN KEY (piloto_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT FK_B608E37580BBB841 FOREIGN KEY (avion_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B608E37587CB4A1F ON vuelo (curso_id)');
        $this->addSql('CREATE INDEX IDX_B608E375DA04E6A9 ON vuelo (socio_id)');
        $this->addSql('CREATE INDEX IDX_B608E3759AAD4A8D ON vuelo (piloto_id)');
        $this->addSql('CREATE INDEX IDX_B608E37580BBB841 ON vuelo (avion_id)');
        $this->addSql('ALTER TABLE vuelo_motor DROP CONSTRAINT fk_719763ecc580f9fb');
        $this->addSql('DROP INDEX uniq_719763ecc580f9fb');
        $this->addSql('ALTER TABLE vuelo_motor RENAME COLUMN vuelo_id_id TO vuelo_id');
        $this->addSql('ALTER TABLE vuelo_motor ADD CONSTRAINT FK_719763EC4FF34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_719763EC4FF34720 ON vuelo_motor (vuelo_id)');
        $this->addSql('ALTER TABLE vuelo_planeador DROP CONSTRAINT fk_812e14ebc580f9fb');
        $this->addSql('DROP INDEX uniq_812e14ebc580f9fb');
        $this->addSql('ALTER TABLE vuelo_planeador RENAME COLUMN vuelo_id_id TO vuelo_id');
        $this->addSql('ALTER TABLE vuelo_planeador ADD CONSTRAINT FK_812E14EB4FF34720 FOREIGN KEY (vuelo_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_812E14EB4FF34720 ON vuelo_planeador (vuelo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E37587CB4A1F');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E375DA04E6A9');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E3759AAD4A8D');
        $this->addSql('ALTER TABLE vuelo DROP CONSTRAINT FK_B608E37580BBB841');
        $this->addSql('DROP INDEX IDX_B608E37587CB4A1F');
        $this->addSql('DROP INDEX IDX_B608E375DA04E6A9');
        $this->addSql('DROP INDEX IDX_B608E3759AAD4A8D');
        $this->addSql('DROP INDEX IDX_B608E37580BBB841');
        $this->addSql('ALTER TABLE vuelo ADD curso_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD socio_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo ADD piloto_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vuelo DROP curso_id');
        $this->addSql('ALTER TABLE vuelo DROP socio_id');
        $this->addSql('ALTER TABLE vuelo DROP piloto_id');
        $this->addSql('ALTER TABLE vuelo RENAME COLUMN avion_id TO avion_id_id');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT fk_b608e375771b9d4d FOREIGN KEY (curso_id_id) REFERENCES curso (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT fk_b608e375bfa13376 FOREIGN KEY (socio_id_id) REFERENCES socio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT fk_b608e3752d5d35a3 FOREIGN KEY (piloto_id_id) REFERENCES piloto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vuelo ADD CONSTRAINT fk_b608e37567b66cf3 FOREIGN KEY (avion_id_id) REFERENCES avion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_b608e37567b66cf3 ON vuelo (avion_id_id)');
        $this->addSql('CREATE INDEX idx_b608e3752d5d35a3 ON vuelo (piloto_id_id)');
        $this->addSql('CREATE INDEX idx_b608e375bfa13376 ON vuelo (socio_id_id)');
        $this->addSql('CREATE INDEX idx_b608e375771b9d4d ON vuelo (curso_id_id)');
        $this->addSql('ALTER TABLE vuelo_motor DROP CONSTRAINT FK_719763EC4FF34720');
        $this->addSql('DROP INDEX UNIQ_719763EC4FF34720');
        $this->addSql('ALTER TABLE vuelo_motor RENAME COLUMN vuelo_id TO vuelo_id_id');
        $this->addSql('ALTER TABLE vuelo_motor ADD CONSTRAINT fk_719763ecc580f9fb FOREIGN KEY (vuelo_id_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_719763ecc580f9fb ON vuelo_motor (vuelo_id_id)');
        $this->addSql('ALTER TABLE vuelo_planeador DROP CONSTRAINT FK_812E14EB4FF34720');
        $this->addSql('DROP INDEX UNIQ_812E14EB4FF34720');
        $this->addSql('ALTER TABLE vuelo_planeador RENAME COLUMN vuelo_id TO vuelo_id_id');
        $this->addSql('ALTER TABLE vuelo_planeador ADD CONSTRAINT fk_812e14ebc580f9fb FOREIGN KEY (vuelo_id_id) REFERENCES vuelo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_812e14ebc580f9fb ON vuelo_planeador (vuelo_id_id)');
    }
}
