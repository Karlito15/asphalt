<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250711163642 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Garages Tables';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garage_app (id INT AUTO_INCREMENT NOT NULL, setting_blueprint_id INT DEFAULT NULL, setting_brand_id INT DEFAULT NULL, setting_class_id INT DEFAULT NULL, setting_level_id INT DEFAULT NULL, setting_unit_price_id INT DEFAULT NULL, stars SMALLINT UNSIGNED DEFAULT 3 NOT NULL, game_update SMALLINT UNSIGNED DEFAULT 0 NOT NULL, car_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL, stat_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL, level SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, model VARCHAR(128) NOT NULL, unlocked TINYINT(1) DEFAULT 0 NOT NULL, gold TINYINT(1) DEFAULT 0 NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B97F42D2989D9B62 (slug), INDEX IDX_B97F42D25869B9F3 (setting_blueprint_id), INDEX IDX_B97F42D2EA7CE8F2 (setting_brand_id), INDEX IDX_B97F42D2448933EA (setting_class_id), INDEX IDX_B97F42D2F138735D (setting_level_id), INDEX IDX_B97F42D24A5104AF (setting_unit_price_id), INDEX garage_app_idx (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_app_setting_tag (garage_app_id INT NOT NULL, setting_tag_id INT NOT NULL, INDEX IDX_5523EBCDEAB965FD (garage_app_id), INDEX IDX_5523EBCD802E9A2C (setting_tag_id), PRIMARY KEY(garage_app_id, setting_tag_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_blueprint (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, star1 VARCHAR(8) DEFAULT NULL, star2 SMALLINT UNSIGNED DEFAULT NULL, star3 SMALLINT UNSIGNED DEFAULT NULL, star4 SMALLINT UNSIGNED DEFAULT NULL, star5 SMALLINT UNSIGNED DEFAULT NULL, star6 SMALLINT UNSIGNED DEFAULT NULL, total SMALLINT UNSIGNED DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_FEB8406FC4FFF555 (garage_id), INDEX garage_blueprint_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_rank (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, star0 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star1 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star2 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star3 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star4 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star5 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, star6 SMALLINT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_EB0F950EC4FFF555 (garage_id), INDEX garage_rank_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_stat_max (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, handly DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_91F01015C4FFF555 (garage_id), INDEX garage_stat_max_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_stat_min (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, handly DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_ADFD2F4CC4FFF555 (garage_id), INDEX garage_stat_min_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE garage_upgrade (id INT AUTO_INCREMENT NOT NULL, garage_id INT DEFAULT NULL, speed SMALLINT UNSIGNED DEFAULT 0 NOT NULL, acceleration SMALLINT UNSIGNED DEFAULT 0 NOT NULL, handly SMALLINT UNSIGNED DEFAULT 0 NOT NULL, nitro SMALLINT UNSIGNED DEFAULT 0 NOT NULL, common SMALLINT UNSIGNED DEFAULT 0 NOT NULL, rare SMALLINT UNSIGNED DEFAULT 0 NOT NULL, epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_3126988AC4FFF555 (garage_id), INDEX garage_upgrade_idx (id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D25869B9F3 FOREIGN KEY (setting_blueprint_id) REFERENCES setting_blueprint (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2EA7CE8F2 FOREIGN KEY (setting_brand_id) REFERENCES setting_brand (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2448933EA FOREIGN KEY (setting_class_id) REFERENCES setting_class (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D2F138735D FOREIGN KEY (setting_level_id) REFERENCES setting_level (id)');
        $this->addSql('ALTER TABLE garage_app ADD CONSTRAINT FK_B97F42D24A5104AF FOREIGN KEY (setting_unit_price_id) REFERENCES setting_unit_price (id)');
        $this->addSql('ALTER TABLE garage_app_setting_tag ADD CONSTRAINT FK_5523EBCDEAB965FD FOREIGN KEY (garage_app_id) REFERENCES garage_app (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_app_setting_tag ADD CONSTRAINT FK_5523EBCD802E9A2C FOREIGN KEY (setting_tag_id) REFERENCES setting_tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage_blueprint ADD CONSTRAINT FK_FEB8406FC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_rank ADD CONSTRAINT FK_EB0F950EC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_stat_max ADD CONSTRAINT FK_91F01015C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_stat_min ADD CONSTRAINT FK_ADFD2F4CC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
        $this->addSql('ALTER TABLE garage_upgrade ADD CONSTRAINT FK_3126988AC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D25869B9F3');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2EA7CE8F2');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2448933EA');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D2F138735D');
        $this->addSql('ALTER TABLE garage_app DROP FOREIGN KEY FK_B97F42D24A5104AF');
        $this->addSql('ALTER TABLE garage_app_setting_tag DROP FOREIGN KEY FK_5523EBCDEAB965FD');
        $this->addSql('ALTER TABLE garage_app_setting_tag DROP FOREIGN KEY FK_5523EBCD802E9A2C');
        $this->addSql('ALTER TABLE garage_blueprint DROP FOREIGN KEY FK_FEB8406FC4FFF555');
        $this->addSql('ALTER TABLE garage_rank DROP FOREIGN KEY FK_EB0F950EC4FFF555');
        $this->addSql('ALTER TABLE garage_stat_max DROP FOREIGN KEY FK_91F01015C4FFF555');
        $this->addSql('ALTER TABLE garage_stat_min DROP FOREIGN KEY FK_ADFD2F4CC4FFF555');
        $this->addSql('ALTER TABLE garage_upgrade DROP FOREIGN KEY FK_3126988AC4FFF555');
        $this->addSql('DROP TABLE garage_app');
        $this->addSql('DROP TABLE garage_app_setting_tag');
        $this->addSql('DROP TABLE garage_blueprint');
        $this->addSql('DROP TABLE garage_rank');
        $this->addSql('DROP TABLE garage_stat_max');
        $this->addSql('DROP TABLE garage_stat_min');
        $this->addSql('DROP TABLE garage_upgrade');
    }
}
