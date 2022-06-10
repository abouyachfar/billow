<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330001313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE if exists pack_pack_options');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_pack_options (pack_id INT NOT NULL, pack_options_id INT NOT NULL, INDEX IDX_1487F6571919B217 (pack_id), INDEX IDX_1487F65718B38DE7 (pack_options_id), PRIMARY KEY(pack_id, pack_options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE pack_pack_options ADD CONSTRAINT FK_1487F65718B38DE7 FOREIGN KEY (pack_options_id) REFERENCES pack_options (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_pack_options ADD CONSTRAINT FK_1487F6571919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE city ADD alert_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B023493035F72 FOREIGN KEY (alert_id) REFERENCES alert (id)');
        $this->addSql('CREATE INDEX IDX_2D5B023493035F72 ON city (alert_id)');
        $this->addSql('ALTER TABLE pack_options DROP FOREIGN KEY FK_EB7C6AFA1919B217');
        $this->addSql('DROP INDEX IDX_EB7C6AFA1919B217 ON pack_options');
        $this->addSql('ALTER TABLE pack_options DROP pack_id');
    }
}
