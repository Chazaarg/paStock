<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181226064150 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE venta_detalle ADD variante_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DCD45162B6 FOREIGN KEY (variante_id) REFERENCES variante (id)');
        $this->addSql('CREATE INDEX IDX_82DFB1DCD45162B6 ON venta_detalle (variante_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DCD45162B6');
        $this->addSql('DROP INDEX IDX_82DFB1DCD45162B6 ON venta_detalle');
        $this->addSql('ALTER TABLE venta_detalle DROP variante_id');
    }
}
