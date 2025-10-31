<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251030230402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Garage & Setting Tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garage_app (id INT AUTO_INCREMENT NOT NULL, stars SMALLINT UNSIGNED DEFAULT 3 NOT NULL, game_update SMALLINT UNSIGNED DEFAULT 0 NOT NULL, car_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL, stat_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL, level SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, model VARCHAR(128) NOT NULL, slug VARCHAR(255) NOT NULL, setting_blueprint_id INT DEFAULT NULL, setting_brand_id INT DEFAULT NULL, setting_class_id INT DEFAULT NULL, setting_level_id INT DEFAULT NULL, setting_unit_price_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B97F42D2989D9B62 (slug), INDEX IDX_B97F42D25869B9F3 (setting_blueprint_id), INDEX IDX_B97F42D2EA7CE8F2 (setting_brand_id), INDEX IDX_B97F42D2448933EA (setting_class_id), INDEX IDX_B97F42D2F138735D (setting_level_id), INDEX IDX_B97F42D24A5104AF (setting_unit_price_id), INDEX garage_app_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_blueprint (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, star1 VARCHAR(8) DEFAULT NULL, star2 SMALLINT UNSIGNED DEFAULT NULL, star3 SMALLINT UNSIGNED DEFAULT NULL, star4 SMALLINT UNSIGNED DEFAULT NULL, star5 SMALLINT UNSIGNED DEFAULT NULL, star6 SMALLINT UNSIGNED DEFAULT NULL, total SMALLINT UNSIGNED DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FEB8406FC4FFF555 (garage_id), INDEX garage_blueprint_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_gauntlet (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed SMALLINT UNSIGNED DEFAULT 9, acceleration SMALLINT UNSIGNED DEFAULT 9, handling SMALLINT UNSIGNED DEFAULT 9, nitro SMALLINT UNSIGNED DEFAULT 9, calculate_mark SMALLINT UNSIGNED DEFAULT 9, temp_mark SMALLINT UNSIGNED DEFAULT 9, final_mark SMALLINT UNSIGNED DEFAULT 9, division SMALLINT UNSIGNED DEFAULT 9, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_F5DB9824C4FFF555 (garage_id), INDEX garage_gauntlet_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_rank (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, star0 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star1 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star2 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star3 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star4 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star5 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star6 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_EB0F950EC4FFF555 (garage_id), INDEX garage_rank_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_stat_actual (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3FDFA9D8C4FFF555 (garage_id), INDEX garage_stat_actual_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_stat_max (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_91F01015C4FFF555 (garage_id), INDEX garage_stat_max_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_stat_min (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_ADFD2F4CC4FFF555 (garage_id), INDEX garage_stat_min_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_status (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, unblock TINYINT(1) DEFAULT 0 NOT NULL, to_unblock TINYINT(1) DEFAULT 0 NOT NULL, gold TINYINT(1) DEFAULT 0 NOT NULL, to_gold TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_level TINYINT(1) DEFAULT 0 NOT NULL, to_upgrade_level TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star1 TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star2 TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star3 TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star4 TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star5 TINYINT(1) DEFAULT 0 NOT NULL, full_blueprint_star6 TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_speed TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_speed TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_acceleration TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_acceleration TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_handling TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_handling TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_nitro TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_nitro TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_common TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_common TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_rare TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_rare TINYINT(1) DEFAULT 0 NOT NULL, full_upgrade_epic TINYINT(1) DEFAULT 0 NOT NULL, to_install_upgrade_epic TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_E83E21CCC4FFF555 (garage_id), INDEX garage_status_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_upgrade (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed SMALLINT UNSIGNED DEFAULT 0 NOT NULL, acceleration SMALLINT UNSIGNED DEFAULT 0 NOT NULL, handling SMALLINT UNSIGNED DEFAULT 0 NOT NULL, nitro SMALLINT UNSIGNED DEFAULT 0 NOT NULL, common SMALLINT UNSIGNED DEFAULT 0 NOT NULL, rare SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3126988AC4FFF555 (garage_id), INDEX garage_upgrade_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_blueprint (id INT AUTO_INCREMENT NOT NULL, star1 VARCHAR(3) NOT NULL, star2 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star3 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star4 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star5 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star6 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, total SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_7B83705C989D9B62 (slug), INDEX setting_blueprint_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_55FA0A395E237E06 (name), UNIQUE INDEX UNIQ_55FA0A39989D9B62 (slug), INDEX setting_brand_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_class (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(8) NOT NULL, value VARCHAR(8) NOT NULL, class_order SMALLINT UNSIGNED DEFAULT 1 NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, median SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(32) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_A4E3EAFE989D9B62 (slug), INDEX setting_class_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_level (id INT AUTO_INCREMENT NOT NULL, level SMALLINT UNSIGNED DEFAULT 10 NOT NULL, common SMALLINT UNSIGNED DEFAULT 0 NOT NULL, rare SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D3423F72989D9B62 (slug), INDEX setting_level_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_tag (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(64) NOT NULL, cars_number SMALLINT UNSIGNED DEFAULT 0 NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D6B8FABD989D9B62 (slug), INDEX setting_tag_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_tag_garage_app (setting_tag_id INT NOT NULL, garage_app_id INT NOT NULL, INDEX IDX_7A8B8060802E9A2C (setting_tag_id), INDEX IDX_7A8B8060EAB965FD (garage_app_id), PRIMARY KEY(setting_tag_id, garage_app_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE setting_unit_price (id INT AUTO_INCREMENT NOT NULL, level01 INT UNSIGNED DEFAULT 0 NOT NULL, level02 INT UNSIGNED DEFAULT 0 NOT NULL, level03 INT UNSIGNED DEFAULT 0 NOT NULL, level04 INT UNSIGNED DEFAULT 0 NOT NULL, level05 INT UNSIGNED DEFAULT 0 NOT NULL, level06 INT UNSIGNED DEFAULT 0 NOT NULL, level07 INT UNSIGNED DEFAULT 0 NOT NULL, level08 INT UNSIGNED DEFAULT 0 NOT NULL, level09 INT UNSIGNED DEFAULT 0 NOT NULL, level10 INT UNSIGNED DEFAULT 0 NOT NULL, level11 INT UNSIGNED DEFAULT 0, level12 INT UNSIGNED DEFAULT 0, level13 INT UNSIGNED DEFAULT 0, common INT UNSIGNED DEFAULT 0 NOT NULL, rare INT UNSIGNED DEFAULT 0 NOT NULL, epic INT UNSIGNED DEFAULT 0, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_87AB43F2989D9B62 (slug), INDEX setting_unit_price_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D25869B9F3 FOREIGN KEY (setting_blueprint_id) REFERENCES setting_blueprint (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2EA7CE8F2 FOREIGN KEY (setting_brand_id) REFERENCES setting_brand (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2448933EA FOREIGN KEY (setting_class_id) REFERENCES setting_class (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2F138735D FOREIGN KEY (setting_level_id) REFERENCES setting_level (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D24A5104AF FOREIGN KEY (setting_unit_price_id) REFERENCES setting_unit_price (id)');
        $this->addSql('ALTER TABLE garage_blueprint ADD CONSTRAINT FK_FEB8406FC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_gauntlet ADD CONSTRAINT FK_F5DB9824C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_rank ADD CONSTRAINT FK_EB0F950EC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_stat_actual ADD CONSTRAINT FK_3FDFA9D8C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_stat_max ADD CONSTRAINT FK_91F01015C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_stat_min ADD CONSTRAINT FK_ADFD2F4CC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_status ADD CONSTRAINT FK_E83E21CCC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_upgrade ADD CONSTRAINT FK_3126988AC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE setting_tag_garage_app ADD CONSTRAINT FK_7A8B8060802E9A2C FOREIGN KEY (setting_tag_id) REFERENCES setting_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE setting_tag_garage_app ADD CONSTRAINT FK_7A8B8060EAB965FD FOREIGN KEY (garage_app_id) REFERENCES garage_app (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D25869B9F3');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2EA7CE8F2');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2448933EA');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2F138735D');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D24A5104AF');
        $this->addSql('ALTER TABLE garage_blueprint DROP FOREIGN KEY FK_FEB8406FC4FFF555');
        $this->addSql('ALTER TABLE garage_gauntlet DROP FOREIGN KEY FK_F5DB9824C4FFF555');
        $this->addSql('ALTER TABLE garage_rank DROP FOREIGN KEY FK_EB0F950EC4FFF555');
        $this->addSql('ALTER TABLE garage_stat_actual DROP FOREIGN KEY FK_3FDFA9D8C4FFF555');
        $this->addSql('ALTER TABLE garage_stat_max DROP FOREIGN KEY FK_91F01015C4FFF555');
        $this->addSql('ALTER TABLE garage_stat_min DROP FOREIGN KEY FK_ADFD2F4CC4FFF555');
        $this->addSql('ALTER TABLE garage_status DROP FOREIGN KEY FK_E83E21CCC4FFF555');
        $this->addSql('ALTER TABLE garage_upgrade DROP FOREIGN KEY FK_3126988AC4FFF555');
        $this->addSql('ALTER TABLE setting_tag_garage_app DROP FOREIGN KEY FK_7A8B8060802E9A2C');
        $this->addSql('ALTER TABLE setting_tag_garage_app DROP FOREIGN KEY FK_7A8B8060EAB965FD');
        $this->addSql('DROP TABLE garage_app');
        $this->addSql('DROP TABLE garage_blueprint');
        $this->addSql('DROP TABLE garage_gauntlet');
        $this->addSql('DROP TABLE garage_rank');
        $this->addSql('DROP TABLE garage_stat_actual');
        $this->addSql('DROP TABLE garage_stat_max');
        $this->addSql('DROP TABLE garage_stat_min');
        $this->addSql('DROP TABLE garage_status');
        $this->addSql('DROP TABLE garage_upgrade');
        $this->addSql('DROP TABLE setting_blueprint');
        $this->addSql('DROP TABLE setting_brand');
        $this->addSql('DROP TABLE setting_class');
        $this->addSql('DROP TABLE setting_level');
        $this->addSql('DROP TABLE setting_tag');
        $this->addSql('DROP TABLE setting_tag_garage_app');
        $this->addSql('DROP TABLE setting_unit_price');
    }
}
