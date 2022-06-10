<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324134448 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alert_property_type (alert_id INT NOT NULL, property_type_id INT NOT NULL, INDEX IDX_23D4219C93035F72 (alert_id), INDEX IDX_23D4219C9C81C6EB (property_type_id), PRIMARY KEY(alert_id, property_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alert_property_type ADD CONSTRAINT FK_23D4219C93035F72 FOREIGN KEY (alert_id) REFERENCES alert (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alert_property_type ADD CONSTRAINT FK_23D4219C9C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C19C81C6EB');
        $this->addSql('DROP INDEX IDX_17FD46C19C81C6EB ON alert');
        $this->addSql('ALTER TABLE alert DROP property_type_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE alert_property_type');
        $this->addSql('ALTER TABLE alert ADD property_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C19C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('CREATE INDEX IDX_17FD46C19C81C6EB ON alert (property_type_id)');
    }
}
