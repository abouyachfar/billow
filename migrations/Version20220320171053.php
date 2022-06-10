<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320171053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_options_params_pack (pack_options_params_id INT NOT NULL, pack_id INT NOT NULL, INDEX IDX_14F04C5F4A7B0A4A (pack_options_params_id), INDEX IDX_14F04C5F1919B217 (pack_id), PRIMARY KEY(pack_options_params_id, pack_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pack_options_params_pack_options (pack_options_params_id INT NOT NULL, pack_options_id INT NOT NULL, INDEX IDX_2B22CDC64A7B0A4A (pack_options_params_id), INDEX IDX_2B22CDC618B38DE7 (pack_options_id), PRIMARY KEY(pack_options_params_id, pack_options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_options_params_pack ADD CONSTRAINT FK_14F04C5F4A7B0A4A FOREIGN KEY (pack_options_params_id) REFERENCES pack_options_params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_options_params_pack ADD CONSTRAINT FK_14F04C5F1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_options_params_pack_options ADD CONSTRAINT FK_2B22CDC64A7B0A4A FOREIGN KEY (pack_options_params_id) REFERENCES pack_options_params (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_options_params_pack_options ADD CONSTRAINT FK_2B22CDC618B38DE7 FOREIGN KEY (pack_options_id) REFERENCES pack_options (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_options_params DROP FOREIGN KEY FK_22C06B2C1919B217');
        $this->addSql('ALTER TABLE pack_options_params DROP FOREIGN KEY FK_22C06B2CCD5AB2D9');
        $this->addSql('DROP INDEX UNIQ_22C06B2CCD5AB2D9 ON pack_options_params');
        $this->addSql('DROP INDEX UNIQ_22C06B2C1919B217 ON pack_options_params');
        $this->addSql('ALTER TABLE pack_options_params DROP pack_id, DROP pack_option_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pack_options_params_pack');
        $this->addSql('DROP TABLE pack_options_params_pack_options');
        $this->addSql('ALTER TABLE pack_options_params ADD pack_id INT NOT NULL, ADD pack_option_id INT NOT NULL');
        $this->addSql('ALTER TABLE pack_options_params ADD CONSTRAINT FK_22C06B2C1919B217 FOREIGN KEY (pack_id) REFERENCES pack (id)');
        $this->addSql('ALTER TABLE pack_options_params ADD CONSTRAINT FK_22C06B2CCD5AB2D9 FOREIGN KEY (pack_option_id) REFERENCES pack_options (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22C06B2CCD5AB2D9 ON pack_options_params (pack_option_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_22C06B2C1919B217 ON pack_options_params (pack_id)');
    }
}
