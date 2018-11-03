<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180923031243 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE variante (id INT AUTO_INCREMENT NOT NULL, variante_tipo_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_474CE6B0F9A084D5 (variante_tipo_id), INDEX IDX_474CE6B07645698E (producto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variante_tipo (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B0F9A084D5 FOREIGN KEY (variante_tipo_id) REFERENCES variante_tipo (id)');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B07645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE producto ADD variante_tipo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615F9A084D5 FOREIGN KEY (variante_tipo_id) REFERENCES variante_tipo (id)');
        $this->addSql('CREATE INDEX IDX_A7BB0615F9A084D5 ON producto (variante_tipo_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615F9A084D5');
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B0F9A084D5');
        $this->addSql('DROP TABLE variante');
        $this->addSql('DROP TABLE variante_tipo');
        $this->addSql('DROP INDEX IDX_A7BB0615F9A084D5 ON producto');
        $this->addSql('ALTER TABLE producto DROP variante_tipo_id');
    }
}
