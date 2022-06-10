<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320161109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_options (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_options_params (id INT AUTO_INCREMENT NOT NULL, pack_id INT NOT NULL, pack_option_id INT DEFAULT NULL, activ TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_22C06B2C1919B217 (pack_id), UNIQUE INDEX UNIQ_22C06B2CCD5AB2D9 (pack_option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_options_params ADD CONSTRAINT FK_22C06B2C1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_options_params ADD CONSTRAINT FK_22C06B2CCD5AB2D9 FOREIGN KEY (pack_option_id) REFERENCES pack_options (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pack_options_params DROP FOREIGN KEY FK_22C06B2C1919B217');
        $this->addSql('ALTER TABLE pack_options_params DROP FOREIGN KEY FK_22C06B2CCD5AB2D9');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_options');
        $this->addSql('DROP TABLE pack_options_params');
    }
}
