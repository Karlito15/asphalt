<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Races Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE race_app (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              race_order SMALLINT UNSIGNED DEFAULT 0,
              finished TINYINT DEFAULT 0 NOT NULL,
              mode_id INT UNSIGNED NOT NULL,
              season_id INT UNSIGNED NOT NULL,
              time_id INT UNSIGNED NOT NULL,
              track_id INT UNSIGNED NOT NULL,
              slug VARCHAR(255) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_DC653D35989D9B62 (slug),
              INDEX IDX_DC653D3577E5854A (mode_id),
              INDEX IDX_DC653D354EC001D1 (season_id),
              INDEX IDX_DC653D355EEADD3B (time_id),
              INDEX IDX_DC653D355ED23C43 (track_id),
              INDEX race_app_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE race_mode (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              name VARCHAR(32) NOT NULL,
              slug VARCHAR(32) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_CAB757E45E237E06 (name),
              UNIQUE INDEX UNIQ_CAB757E4989D9B62 (slug),
              INDEX race_mode_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE race_region (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              name VARCHAR(64) NOT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_6534EFA55E237E06 (name),
              UNIQUE INDEX UNIQ_6534EFA5989D9B62 (slug),
              INDEX race_region_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE race_season (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              chapter SMALLINT UNSIGNED DEFAULT 1 NOT NULL,
              name VARCHAR(64) NOT NULL,
              slug VARCHAR(128) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_9AB2457A5E237E06 (name),
              UNIQUE INDEX UNIQ_9AB2457A989D9B62 (slug),
              INDEX race_season_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE race_time (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              name SMALLINT UNSIGNED NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_32E9880A5E237E06 (name),
              INDEX race_time_idx (name),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE race_track (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              name_english VARCHAR(64) NOT NULL,
              name_french VARCHAR(64) DEFAULT NULL,
              region_id INT UNSIGNED DEFAULT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_30DDD9B724E847BE (name_english),
              UNIQUE INDEX UNIQ_30DDD9B7989D9B62 (slug),
              INDEX IDX_30DDD9B798260155 (region_id),
              INDEX race_track_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              race_app
            ADD
              CONSTRAINT FK_DC653D3577E5854A FOREIGN KEY (mode_id) REFERENCES race_mode (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              race_app
            ADD
              CONSTRAINT FK_DC653D354EC001D1 FOREIGN KEY (season_id) REFERENCES race_season (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              race_app
            ADD
              CONSTRAINT FK_DC653D355EEADD3B FOREIGN KEY (time_id) REFERENCES race_time (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              race_app
            ADD
              CONSTRAINT FK_DC653D355ED23C43 FOREIGN KEY (track_id) REFERENCES race_track (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              race_track
            ADD
              CONSTRAINT FK_30DDD9B798260155 FOREIGN KEY (region_id) REFERENCES race_region (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE race_app DROP FOREIGN KEY FK_DC653D3577E5854A');
        $this->addSql('ALTER TABLE race_app DROP FOREIGN KEY FK_DC653D354EC001D1');
        $this->addSql('ALTER TABLE race_app DROP FOREIGN KEY FK_DC653D355EEADD3B');
        $this->addSql('ALTER TABLE race_app DROP FOREIGN KEY FK_DC653D355ED23C43');
        $this->addSql('ALTER TABLE race_track DROP FOREIGN KEY FK_30DDD9B798260155');
        $this->addSql('DROP TABLE race_app');
        $this->addSql('DROP TABLE race_mode');
        $this->addSql('DROP TABLE race_region');
        $this->addSql('DROP TABLE race_season');
        $this->addSql('DROP TABLE race_time');
        $this->addSql('DROP TABLE race_track');
    }
}
