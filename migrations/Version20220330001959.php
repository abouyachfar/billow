<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330001959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, price NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_options (id INT AUTO_INCREMENT NOT NULL, pack_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, activ TINYINT(1) NOT NULL, INDEX IDX_EB7C6AFA1919B217 (pack_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_options ADD CONSTRAINT FK_EB7C6AFA1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pack_options DROP FOREIGN KEY FK_EB7C6AFA1919B217');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6491919B217');
        $this->addSql('DROP TABLE pack');
        $this->addSql('DROP TABLE pack_options');
    }
}
