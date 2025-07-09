<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250709165107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Settings Tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setting_blueprint (id INT AUTO_INCREMENT NOT NULL, star1 VARCHAR(3) NOT NULL, star2 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star3 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star4 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star5 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star6 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, total SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7B83705C989D9B62 (slug), INDEX setting_blueprint_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_55FA0A395E237E06 (name), UNIQUE INDEX UNIQ_55FA0A39989D9B62 (slug), INDEX setting_brand_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_class (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(8) NOT NULL, value VARCHAR(8) NOT NULL, class_order SMALLINT UNSIGNED DEFAULT 1 NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, median SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(32) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A4E3EAFE989D9B62 (slug), INDEX setting_class_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_level (id INT AUTO_INCREMENT NOT NULL, level SMALLINT UNSIGNED DEFAULT 10 NOT NULL, common SMALLINT UNSIGNED DEFAULT 0 NOT NULL, rare SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D3423F72989D9B62 (slug), INDEX setting_level_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_tag (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(64) NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D6B8FABD989D9B62 (slug), INDEX setting_tag_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_unit_price (id INT AUTO_INCREMENT NOT NULL, level01 INT UNSIGNED DEFAULT 0 NOT NULL, level02 INT UNSIGNED DEFAULT 0 NOT NULL, level03 INT UNSIGNED DEFAULT 0 NOT NULL, level04 INT UNSIGNED DEFAULT 0 NOT NULL, level05 INT UNSIGNED DEFAULT 0 NOT NULL, level06 INT UNSIGNED DEFAULT 0 NOT NULL, level07 INT UNSIGNED DEFAULT 0 NOT NULL, level08 INT UNSIGNED DEFAULT 0 NOT NULL, level09 INT UNSIGNED DEFAULT 0 NOT NULL, level10 INT UNSIGNED DEFAULT 0 NOT NULL, level11 INT UNSIGNED DEFAULT 0, level12 INT UNSIGNED DEFAULT 0, level13 INT UNSIGNED DEFAULT 0, common INT UNSIGNED DEFAULT 0 NOT NULL, rare INT UNSIGNED DEFAULT 0 NOT NULL, epic INT UNSIGNED DEFAULT 0, slug VARCHAR(128) NOT NULL, deleted_at DATETIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_87AB43F2989D9B62 (slug), INDEX setting_unit_price_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE setting_blueprint');
        $this->addSql('DROP TABLE setting_brand');
        $this->addSql('DROP TABLE setting_class');
        $this->addSql('DROP TABLE setting_level');
        $this->addSql('DROP TABLE setting_tag');
        $this->addSql('DROP TABLE setting_unit_price');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
