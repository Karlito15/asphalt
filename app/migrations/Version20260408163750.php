<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408163750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Garages Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE garage_app (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            model VARCHAR(128) NOT NULL,
            stars SMALLINT UNSIGNED DEFAULT 3 NOT NULL,
            game_update SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            car_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL,
            stat_order SMALLINT UNSIGNED DEFAULT 99 NOT NULL,
            level SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            evo SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            slug VARCHAR(255) NOT NULL,
            setting_blueprint_id INT UNSIGNED DEFAULT NULL,
            setting_brand_id INT UNSIGNED DEFAULT NULL,
            setting_class_id INT UNSIGNED DEFAULT NULL,
            setting_level_id INT UNSIGNED DEFAULT NULL,
            setting_unit_price_id INT UNSIGNED DEFAULT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_B97F42D2989D9B62 (slug),
            INDEX IDX_B97F42D25869B9F3 (setting_blueprint_id),
            INDEX IDX_B97F42D2EA7CE8F2 (setting_brand_id),
            INDEX IDX_B97F42D2448933EA (setting_class_id),
            INDEX IDX_B97F42D2F138735D (setting_level_id),
            INDEX IDX_B97F42D24A5104AF (setting_unit_price_id),
            INDEX garage_app_idx (slug),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_blueprint (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            star1 VARCHAR(3) DEFAULT NULL,
            star2 SMALLINT UNSIGNED DEFAULT 0,
            star3 SMALLINT UNSIGNED DEFAULT 0,
            star4 SMALLINT UNSIGNED DEFAULT 0,
            star5 SMALLINT UNSIGNED DEFAULT 0,
            star6 SMALLINT UNSIGNED DEFAULT 0,
            total SMALLINT UNSIGNED DEFAULT 0,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_FEB8406FC4FFF555 (garage_id),
            INDEX garage_blueprint_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_gauntlet (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            division SMALLINT UNSIGNED DEFAULT 9,
            speed SMALLINT UNSIGNED DEFAULT 9,
            acceleration SMALLINT UNSIGNED DEFAULT 9,
            handling SMALLINT UNSIGNED DEFAULT 9,
            nitro SMALLINT UNSIGNED DEFAULT 9,
            mark SMALLINT UNSIGNED DEFAULT 9,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_F5DB9824C4FFF555 (garage_id),
            INDEX garage_gauntlet_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_rank (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            star0 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star1 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star2 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star3 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star4 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star5 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            star6 SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_EB0F950EC4FFF555 (garage_id),
            INDEX garage_rank_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_stat_actual (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_3FDFA9D8C4FFF555 (garage_id),
            INDEX garage_stat_actual_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_stat_max (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_91F01015C4FFF555 (garage_id),
            INDEX garage_stat_max_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_stat_min (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_ADFD2F4CC4FFF555 (garage_id),
            INDEX garage_stat_min_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_status (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            unblock TINYINT DEFAULT 0 NOT NULL,
            gold TINYINT DEFAULT 0 NOT NULL,
            to_upgrade TINYINT DEFAULT 0 NOT NULL,
            evo TINYINT DEFAULT 0 NOT NULL,
            event_class TINYINT DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_E83E21CCC4FFF555 (garage_id),
            INDEX garage_status_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_status_control (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            to_install_speed TINYINT DEFAULT 0 NOT NULL,
            full_speed TINYINT DEFAULT 0 NOT NULL,
            to_install_acceleration TINYINT DEFAULT 0 NOT NULL,
            full_acceleration TINYINT DEFAULT 0 NOT NULL,
            to_install_handling TINYINT DEFAULT 0 NOT NULL,
            full_handling TINYINT DEFAULT 0 NOT NULL,
            to_install_nitro TINYINT DEFAULT 0 NOT NULL,
            full_nitro TINYINT DEFAULT 0 NOT NULL,
            to_install_common TINYINT DEFAULT 0 NOT NULL,
            full_common TINYINT DEFAULT 0 NOT NULL,
            to_install_rare TINYINT DEFAULT 0 NOT NULL,
            full_rare TINYINT DEFAULT 0 NOT NULL,
            to_install_epic TINYINT DEFAULT 0 NOT NULL,
            full_epic TINYINT DEFAULT 0 NOT NULL,
            full_star1 TINYINT DEFAULT 0 NOT NULL,
            full_star2 TINYINT DEFAULT 0 NOT NULL,
            full_star3 TINYINT DEFAULT 0 NOT NULL,
            full_star4 TINYINT DEFAULT 0 NOT NULL,
            full_star5 TINYINT DEFAULT 0 NOT NULL,
            full_star6 TINYINT DEFAULT 0 NOT NULL,
            full_blueprint TINYINT DEFAULT 0 NOT NULL,
            to_install_upgrade TINYINT DEFAULT 0 NOT NULL,
            full_upgrade TINYINT DEFAULT 0 NOT NULL,
            to_install_import TINYINT DEFAULT 0 NOT NULL,
            full_import TINYINT DEFAULT 0 NOT NULL,
            to_gold TINYINT DEFAULT 0 NOT NULL,
            full_evo TINYINT DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_FB8447A5C4FFF555 (garage_id),
            INDEX garage_status_control_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE garage_upgrade (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            garage_id INT UNSIGNED DEFAULT NULL,
            speed SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            acceleration SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            handling SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            nitro SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            common SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            rare SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            epic SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_3126988AC4FFF555 (garage_id),
            INDEX garage_upgrade_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
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
        $this->addSql('ALTER TABLE garage_status_control ADD CONSTRAINT FK_FB8447A5C4FFF555 FOREIGN KEY (garage_id) REFERENCES garage_app (id)');
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
        $this->addSql('ALTER TABLE garage_blueprint DROP FOREIGN KEY FK_FEB8406FC4FFF555');
        $this->addSql('ALTER TABLE garage_gauntlet DROP FOREIGN KEY FK_F5DB9824C4FFF555');
        $this->addSql('ALTER TABLE garage_rank DROP FOREIGN KEY FK_EB0F950EC4FFF555');
        $this->addSql('ALTER TABLE garage_stat_actual DROP FOREIGN KEY FK_3FDFA9D8C4FFF555');
        $this->addSql('ALTER TABLE garage_stat_max DROP FOREIGN KEY FK_91F01015C4FFF555');
        $this->addSql('ALTER TABLE garage_stat_min DROP FOREIGN KEY FK_ADFD2F4CC4FFF555');
        $this->addSql('ALTER TABLE garage_status DROP FOREIGN KEY FK_E83E21CCC4FFF555');
        $this->addSql('ALTER TABLE garage_status_control DROP FOREIGN KEY FK_FB8447A5C4FFF555');
        $this->addSql('ALTER TABLE garage_upgrade DROP FOREIGN KEY FK_3126988AC4FFF555');
        $this->addSql('DROP TABLE garage_app');
        $this->addSql('DROP TABLE garage_blueprint');
        $this->addSql('DROP TABLE garage_gauntlet');
        $this->addSql('DROP TABLE garage_rank');
        $this->addSql('DROP TABLE garage_stat_actual');
        $this->addSql('DROP TABLE garage_stat_max');
        $this->addSql('DROP TABLE garage_stat_min');
        $this->addSql('DROP TABLE garage_status');
        $this->addSql('DROP TABLE garage_status_control');
        $this->addSql('DROP TABLE garage_upgrade');
    }
}
