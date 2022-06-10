<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327130420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alert_city (alert_id INT NOT NULL, city_id INT NOT NULL, INDEX IDX_A2EBD0B093035F72 (alert_id), INDEX IDX_A2EBD0B08BAC62AF (city_id), PRIMARY KEY(alert_id, city_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alert_city ADD CONSTRAINT FK_A2EBD0B093035F72 FOREIGN KEY (alert_id) REFERENCES alert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alert_city ADD CONSTRAINT FK_A2EBD0B08BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE alert_city');
    }
}
