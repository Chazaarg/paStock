<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180923161845 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615F9A084D5');
        $this->addSql('DROP INDEX IDX_A7BB0615F9A084D5 ON producto');
        $this->addSql('ALTER TABLE producto DROP variante_tipo_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto ADD variante_tipo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615F9A084D5 FOREIGN KEY (variante_tipo_id) REFERENCES variante_tipo (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615F9A084D5 ON producto (variante_tipo_id)');
    }
}
