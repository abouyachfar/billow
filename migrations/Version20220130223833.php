<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220130223833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_option (id INT AUTO_INCREMENT NOT NULL, price_pack_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_7D36B590723F7A4B (price_pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, title VARCHAR(500) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price_pack (id INT AUTO_INCREMENT NOT NULL, price_category_id INT NOT NULL, label VARCHAR(255) NOT NULL, price NUMERIC(10, 0) NOT NULL, months INT NOT NULL, INDEX IDX_EA8CAC99159FD1F4 (price_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_option ADD CONSTRAINT FK_7D36B590723F7A4B FOREIGN KEY (price_pack_id) REFERENCES price_pack (id)');
        $this->addSql('ALTER TABLE price_pack ADD CONSTRAINT FK_EA8CAC99159FD1F4 FOREIGN KEY (price_category_id) REFERENCES price_category (id)');
        $this->addSql('ALTER TABLE property ADD property_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDE9C81C6EB ON property (property_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE price_pack DROP FOREIGN KEY FK_EA8CAC99159FD1F4');
        $this->addSql('ALTER TABLE pack_option DROP FOREIGN KEY FK_7D36B590723F7A4B');
        $this->addSql('DROP TABLE pack_option');
        $this->addSql('DROP TABLE price_category');
        $this->addSql('DROP TABLE price_pack');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9C81C6EB');
        $this->addSql('DROP INDEX IDX_8BF21CDE9C81C6EB ON property');
        $this->addSql('ALTER TABLE property DROP property_type_id');
    }
}
