<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220320171918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pack_pack_options (pack_id INT NOT NULL, pack_options_id INT NOT NULL, INDEX IDX_1487F6571919B217 (pack_id), INDEX IDX_1487F65718B38DE7 (pack_options_id), PRIMARY KEY(pack_id, pack_options_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pack_pack_options ADD CONSTRAINT FK_1487F6571919B217 FOREIGN KEY (pack_id) REFERENCES pack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_pack_options ADD CONSTRAINT FK_1487F65718B38DE7 FOREIGN KEY (pack_options_id) REFERENCES pack_options (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pack_options ADD activ TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE pack_pack_options');
        $this->addSql('ALTER TABLE pack_options DROP activ');
    }
}
