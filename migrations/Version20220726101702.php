<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726101702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_detail (id INT AUTO_INCREMENT NOT NULL, products_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_ED896F466C8A81A9 (products_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE customer ADD address VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD customers_id INT NOT NULL, ADD employees_id INT NOT NULL, ADD order_detail_id INT NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP number');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398C3568B40 FOREIGN KEY (customers_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988520A30B FOREIGN KEY (employees_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939864577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE INDEX IDX_F5299398C3568B40 ON `order` (customers_id)');
        $this->addSql('CREATE INDEX IDX_F52993988520A30B ON `order` (employees_id)');
        $this->addSql('CREATE INDEX IDX_F529939864577843 ON `order` (order_detail_id)');
        $this->addSql('ALTER TABLE product_category ADD description LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988520A30B');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939864577843');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE order_detail');
        $this->addSql('ALTER TABLE customer DROP address, DROP city');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398C3568B40');
        $this->addSql('DROP INDEX IDX_F5299398C3568B40 ON `order`');
        $this->addSql('DROP INDEX IDX_F52993988520A30B ON `order`');
        $this->addSql('DROP INDEX IDX_F529939864577843 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD number VARCHAR(255) NOT NULL, DROP customers_id, DROP employees_id, DROP order_detail_id, DROP created_at');
        $this->addSql('ALTER TABLE product_category DROP description');
    }
}
