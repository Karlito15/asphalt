<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410164800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_actual
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_max
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_min
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_actual
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_max
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE
              garage_stat_min
            CHANGE
              speed speed DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              handling handling DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL,
            CHANGE
              average average DOUBLE PRECISION UNSIGNED DEFAULT '0' NOT NULL
        SQL);
    }
}
