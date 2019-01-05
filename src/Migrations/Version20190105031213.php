<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190105031213 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cliente_historico (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, INDEX IDX_9AA7BAAEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto_historico (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, marca VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, codigo_de_barras VARCHAR(255) DEFAULT NULL, categoria VARCHAR(255) DEFAULT NULL, subcategoria VARCHAR(255) DEFAULT NULL, INDEX IDX_7B3B8040A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendedor_historico (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, apellido VARCHAR(255) NOT NULL, apodo VARCHAR(255) DEFAULT NULL, INDEX IDX_EFC5B268A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cliente_historico ADD CONSTRAINT FK_9AA7BAAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE producto_historico ADD CONSTRAINT FK_7B3B8040A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vendedor_historico ADD CONSTRAINT FK_EFC5B268A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE venta ADD cliente_historico_id INT NOT NULL, ADD vendedor_historico_id INT NOT NULL');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55E33FC5B9 FOREIGN KEY (cliente_historico_id) REFERENCES cliente_historico (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE551D78A542 FOREIGN KEY (vendedor_historico_id) REFERENCES vendedor_historico (id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE55E33FC5B9 ON venta (cliente_historico_id)');
        $this->addSql('CREATE INDEX IDX_8FE7EE551D78A542 ON venta (vendedor_historico_id)');
        $this->addSql('ALTER TABLE venta_detalle ADD producto_historico_id INT NOT NULL');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DC9C5339E4 FOREIGN KEY (producto_historico_id) REFERENCES producto_historico (id)');
        $this->addSql('CREATE INDEX IDX_82DFB1DC9C5339E4 ON venta_detalle (producto_historico_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE55E33FC5B9');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DC9C5339E4');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE551D78A542');
        $this->addSql('DROP TABLE cliente_historico');
        $this->addSql('DROP TABLE producto_historico');
        $this->addSql('DROP TABLE vendedor_historico');
        $this->addSql('ALTER TABLE user CHANGE roles roles VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('DROP INDEX IDX_8FE7EE55E33FC5B9 ON venta');
        $this->addSql('DROP INDEX IDX_8FE7EE551D78A542 ON venta');
        $this->addSql('ALTER TABLE venta DROP cliente_historico_id, DROP vendedor_historico_id');
        $this->addSql('DROP INDEX IDX_82DFB1DC9C5339E4 ON venta_detalle');
        $this->addSql('ALTER TABLE venta_detalle DROP producto_historico_id');
    }
}
