<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181224205619 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categoria (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_4E10122DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cliente (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, direccion VARCHAR(255) DEFAULT NULL, localidad VARCHAR(255) DEFAULT NULL, telefono VARCHAR(255) DEFAULT NULL, dni VARCHAR(255) DEFAULT NULL, INDEX IDX_F41C9B25A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marca (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, origen VARCHAR(255) DEFAULT NULL, pagina VARCHAR(255) DEFAULT NULL, INDEX IDX_70A0113A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE producto (id INT AUTO_INCREMENT NOT NULL, marca_id INT DEFAULT NULL, categoria_id INT DEFAULT NULL, sub_categoria_id INT DEFAULT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, precio DOUBLE PRECISION DEFAULT NULL, codigo_de_barras VARCHAR(255) DEFAULT NULL, precio_compra DOUBLE PRECISION DEFAULT NULL, precio_real DOUBLE PRECISION DEFAULT NULL, cantidad INT DEFAULT NULL, descripcion VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_A7BB061581EF0041 (marca_id), INDEX IDX_A7BB06153397707A (categoria_id), INDEX IDX_A7BB061524C5374C (sub_categoria_id), INDEX IDX_A7BB0615A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sub_categoria (id INT AUTO_INCREMENT NOT NULL, categoria_id INT DEFAULT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_5C1D54933397707A (categoria_id), INDEX IDX_5C1D5493A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variante_tipo (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_863D6CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vendedor (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) DEFAULT NULL, apellido VARCHAR(255) DEFAULT NULL, apodo VARCHAR(255) DEFAULT NULL, INDEX IDX_9797982EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venta (id INT AUTO_INCREMENT NOT NULL, cliente_id INT NOT NULL, vendedor_id INT NOT NULL, forma_de_pago_id INT NOT NULL, user_id INT NOT NULL, total INT NOT NULL, descuento INT NOT NULL, INDEX IDX_8FE7EE55DE734E51 (cliente_id), INDEX IDX_8FE7EE558361A8B8 (vendedor_id), INDEX IDX_8FE7EE5536DB3070 (forma_de_pago_id), INDEX IDX_8FE7EE55A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forma_de_pago (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, INDEX IDX_F6F58E20A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, email VARCHAR(180) NOT NULL, google_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE variante (id INT AUTO_INCREMENT NOT NULL, variante_tipo_id INT DEFAULT NULL, producto_id INT DEFAULT NULL, user_id INT NOT NULL, nombre VARCHAR(255) NOT NULL, cantidad INT NOT NULL, precio INT NOT NULL, codigo_de_barras VARCHAR(255) DEFAULT NULL, INDEX IDX_474CE6B0F9A084D5 (variante_tipo_id), INDEX IDX_474CE6B07645698E (producto_id), INDEX IDX_474CE6B0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE venta_detalle (id INT AUTO_INCREMENT NOT NULL, venta_id INT NOT NULL, producto_id INT NOT NULL, user_id INT NOT NULL, cantidad INT NOT NULL, INDEX IDX_82DFB1DCF2A5805D (venta_id), INDEX IDX_82DFB1DC7645698E (producto_id), INDEX IDX_82DFB1DCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categoria ADD CONSTRAINT FK_4E10122DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cliente ADD CONSTRAINT FK_F41C9B25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE marca ADD CONSTRAINT FK_70A0113A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061581EF0041 FOREIGN KEY (marca_id) REFERENCES marca (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB06153397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB061524C5374C FOREIGN KEY (sub_categoria_id) REFERENCES sub_categoria (id)');
        $this->addSql('ALTER TABLE producto ADD CONSTRAINT FK_A7BB0615A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE sub_categoria ADD CONSTRAINT FK_5C1D54933397707A FOREIGN KEY (categoria_id) REFERENCES categoria (id)');
        $this->addSql('ALTER TABLE sub_categoria ADD CONSTRAINT FK_5C1D5493A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE variante_tipo ADD CONSTRAINT FK_863D6CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vendedor ADD CONSTRAINT FK_9797982EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55DE734E51 FOREIGN KEY (cliente_id) REFERENCES cliente (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE558361A8B8 FOREIGN KEY (vendedor_id) REFERENCES vendedor (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE5536DB3070 FOREIGN KEY (forma_de_pago_id) REFERENCES forma_de_pago (id)');
        $this->addSql('ALTER TABLE venta ADD CONSTRAINT FK_8FE7EE55A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forma_de_pago ADD CONSTRAINT FK_F6F58E20A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B0F9A084D5 FOREIGN KEY (variante_tipo_id) REFERENCES variante_tipo (id)');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B07645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE variante ADD CONSTRAINT FK_474CE6B0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DCF2A5805D FOREIGN KEY (venta_id) REFERENCES venta (id)');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DC7645698E FOREIGN KEY (producto_id) REFERENCES producto (id)');
        $this->addSql('ALTER TABLE venta_detalle ADD CONSTRAINT FK_82DFB1DCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB06153397707A');
        $this->addSql('ALTER TABLE sub_categoria DROP FOREIGN KEY FK_5C1D54933397707A');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE55DE734E51');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061581EF0041');
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B07645698E');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DC7645698E');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB061524C5374C');
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B0F9A084D5');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE558361A8B8');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DCF2A5805D');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE5536DB3070');
        $this->addSql('ALTER TABLE categoria DROP FOREIGN KEY FK_4E10122DA76ED395');
        $this->addSql('ALTER TABLE cliente DROP FOREIGN KEY FK_F41C9B25A76ED395');
        $this->addSql('ALTER TABLE marca DROP FOREIGN KEY FK_70A0113A76ED395');
        $this->addSql('ALTER TABLE producto DROP FOREIGN KEY FK_A7BB0615A76ED395');
        $this->addSql('ALTER TABLE sub_categoria DROP FOREIGN KEY FK_5C1D5493A76ED395');
        $this->addSql('ALTER TABLE variante_tipo DROP FOREIGN KEY FK_863D6CAA76ED395');
        $this->addSql('ALTER TABLE vendedor DROP FOREIGN KEY FK_9797982EA76ED395');
        $this->addSql('ALTER TABLE venta DROP FOREIGN KEY FK_8FE7EE55A76ED395');
        $this->addSql('ALTER TABLE forma_de_pago DROP FOREIGN KEY FK_F6F58E20A76ED395');
        $this->addSql('ALTER TABLE variante DROP FOREIGN KEY FK_474CE6B0A76ED395');
        $this->addSql('ALTER TABLE venta_detalle DROP FOREIGN KEY FK_82DFB1DCA76ED395');
        $this->addSql('DROP TABLE categoria');
        $this->addSql('DROP TABLE cliente');
        $this->addSql('DROP TABLE marca');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE sub_categoria');
        $this->addSql('DROP TABLE variante_tipo');
        $this->addSql('DROP TABLE vendedor');
        $this->addSql('DROP TABLE venta');
        $this->addSql('DROP TABLE forma_de_pago');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE variante');
        $this->addSql('DROP TABLE venta_detalle');
    }
}
