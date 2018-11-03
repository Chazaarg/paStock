<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180923015147 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marca (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, origen VARCHAR(255) DEFAULT NULL, pagina VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, marca_id INT DEFAULT NULL, categoria_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, precio DOUBLE PRECISION NOT NULL, codigo_de_barras VARCHAR(255) DEFAULT NULL, precio_compra DOUBLE PRECISION DEFAULT NULL, precio_real DOUBLE PRECISION DEFAULT NULL, cantidad INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A7BB061581EF0041 (marca_id), INDEX IDX_A7BB06153397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_categoria (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_5C1D54933397707A (categoria_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061581EF0041 FOREIGN KEY (marca_id) REFERENCES marca (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE sub_categoria ADD CONSTRAINT FK_5C1D54933397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('ALTER TABLE sub_categoria DROP FOREIGN KEY FK_5C1D54933397707A');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061581EF0041');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE marca');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE sub_categoria');
    }
}
