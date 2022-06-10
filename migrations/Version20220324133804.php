<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324133804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alert ADD property_type_id INT DEFAULT NULL, DROP city, DROP property_type');
        $this->addSql('ALTER TABLE alert ADD CONSTRAINT FK_17FD46C19C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('CREATE INDEX IDX_17FD46C19C81C6EB ON alert (property_type_id)');
        $this->addSql('ALTER TABLE city ADD alert_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023493035F72 FOREIGN KEY (alert_id) REFERENCES alert (id)');
        $this->addSql('CREATE INDEX IDX_2D5B023493035F72 ON city (alert_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alert DROP FOREIGN KEY FK_17FD46C19C81C6EB');
        $this->addSql('DROP INDEX IDX_17FD46C19C81C6EB ON alert');
        $this->addSql('ALTER TABLE alert ADD property_type INT DEFAULT NULL, CHANGE property_type_id city INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B023493035F72');
        $this->addSql('DROP INDEX IDX_2D5B023493035F72 ON city');
        $this->addSql('ALTER TABLE city DROP alert_id');
    }
}
