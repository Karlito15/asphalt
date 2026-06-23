<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260514000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Table : Settings';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_blueprint (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              star1 VARCHAR(3) NOT NULL,
              star2 SMALLINT UNSIGNED NOT NULL,
              star3 SMALLINT UNSIGNED NOT NULL,
              star4 SMALLINT UNSIGNED DEFAULT NULL,
              star5 SMALLINT UNSIGNED DEFAULT NULL,
              star6 SMALLINT UNSIGNED DEFAULT NULL,
              total SMALLINT UNSIGNED DEFAULT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_7B83705C989D9B62 (slug),
              INDEX setting_blueprint_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_brand (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              name VARCHAR(64) NOT NULL,
              cars_number SMALLINT UNSIGNED NOT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_55FA0A395E237E06 (name),
              UNIQUE INDEX UNIQ_55FA0A39989D9B62 (slug),
              INDEX setting_brand_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_class (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              label VARCHAR(8) NOT NULL,
              value VARCHAR(8) NOT NULL,
              class_order SMALLINT UNSIGNED NOT NULL,
              cars_number SMALLINT UNSIGNED NOT NULL,
              median SMALLINT UNSIGNED NOT NULL,
              slug VARCHAR(32) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_A4E3EAFE1D775834 (value),
              UNIQUE INDEX UNIQ_A4E3EAFE989D9B62 (slug),
              INDEX setting_class_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_level (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              level SMALLINT UNSIGNED NOT NULL,
              common SMALLINT UNSIGNED NOT NULL,
              rare SMALLINT UNSIGNED NOT NULL,
              epic SMALLINT UNSIGNED NOT NULL,
              slug VARCHAR(128) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_D3423F72989D9B62 (slug),
              INDEX setting_level_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_tag (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              value VARCHAR(64) NOT NULL,
              cars_number SMALLINT UNSIGNED NOT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_D6B8FABD1D775834 (value),
              UNIQUE INDEX UNIQ_D6B8FABD989D9B62 (slug),
              INDEX setting_tag_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE setting_unit_price (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              level01 INT UNSIGNED NOT NULL,
              level02 INT UNSIGNED NOT NULL,
              level03 INT UNSIGNED NOT NULL,
              level04 INT UNSIGNED NOT NULL,
              level05 INT UNSIGNED NOT NULL,
              level06 INT UNSIGNED NOT NULL,
              level07 INT UNSIGNED NOT NULL,
              level08 INT UNSIGNED NOT NULL,
              level09 INT UNSIGNED NOT NULL,
              level10 INT UNSIGNED NOT NULL,
              level11 INT UNSIGNED DEFAULT NULL,
              level12 INT UNSIGNED DEFAULT NULL,
              level13 INT UNSIGNED DEFAULT NULL,
              common INT UNSIGNED NOT NULL,
              rare INT UNSIGNED NOT NULL,
              epic INT UNSIGNED DEFAULT NULL,
              slug VARCHAR(128) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_87AB43F2989D9B62 (slug),
              INDEX setting_unit_price_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
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
    }
}
