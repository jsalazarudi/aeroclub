<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414031045 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT fk_4aeec2d09221f5e9');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT fk_4aeec2d03f63963d');
        $this->addSql('DROP INDEX idx_4aeec2d03f63963d');
        $this->addSql('DROP INDEX idx_4aeec2d09221f5e9');
        $this->addSql('ALTER TABLE movimiento_stock ADD tesorero_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_stock ADD producto_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_stock DROP tesorero_id_id');
        $this->addSql('ALTER TABLE movimiento_stock DROP producto_id_id');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT FK_4AEEC2D088CE059D FOREIGN KEY (tesorero_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT FK_4AEEC2D07645698E FOREIGN KEY (producto_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4AEEC2D088CE059D ON movimiento_stock (tesorero_id)');
        $this->addSql('CREATE INDEX IDX_4AEEC2D07645698E ON movimiento_stock (producto_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT FK_4AEEC2D088CE059D');
        $this->addSql('ALTER TABLE movimiento_stock DROP CONSTRAINT FK_4AEEC2D07645698E');
        $this->addSql('DROP INDEX IDX_4AEEC2D088CE059D');
        $this->addSql('DROP INDEX IDX_4AEEC2D07645698E');
        $this->addSql('ALTER TABLE movimiento_stock ADD tesorero_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_stock ADD producto_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE movimiento_stock DROP tesorero_id');
        $this->addSql('ALTER TABLE movimiento_stock DROP producto_id');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT fk_4aeec2d09221f5e9 FOREIGN KEY (tesorero_id_id) REFERENCES tesorero (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movimiento_stock ADD CONSTRAINT fk_4aeec2d03f63963d FOREIGN KEY (producto_id_id) REFERENCES producto (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_4aeec2d03f63963d ON movimiento_stock (producto_id_id)');
        $this->addSql('CREATE INDEX idx_4aeec2d09221f5e9 ON movimiento_stock (tesorero_id_id)');
    }
}
