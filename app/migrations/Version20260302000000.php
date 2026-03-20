<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260302000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Inventory Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE inventory_app (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              category VARCHAR(16) NOT NULL,
              label VARCHAR(32) NOT NULL,
              filter VARCHAR(32) DEFAULT '---' NOT NULL,
              position SMALLINT DEFAULT NULL,
              active TINYINT NOT NULL,
              value INT UNSIGNED DEFAULT 0 NOT NULL,
              slug VARCHAR(128) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_B0041FAB989D9B62 (slug),
              INDEX inventory_app_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE inventory_app');
    }
}
