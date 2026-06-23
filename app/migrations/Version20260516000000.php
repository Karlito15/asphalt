<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260516000000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Table : Statistical';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE statistical_garage (
              id INT AUTO_INCREMENT NOT NULL,
              name VARCHAR(64) NOT NULL,
              value JSON DEFAULT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_6CD578815E237E06 (name),
              UNIQUE INDEX UNIQ_6CD57881989D9B62 (slug),
              INDEX statistical_garage_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE statistical_race (
              id INT AUTO_INCREMENT NOT NULL,
              name VARCHAR(64) NOT NULL,
              value JSON DEFAULT NULL,
              slug VARCHAR(64) NOT NULL,
              created_at DATETIME NOT NULL,
              updated_at DATETIME NOT NULL,
              deleted_at DATETIME DEFAULT NULL,
              UNIQUE INDEX UNIQ_6D08E8CB5E237E06 (name),
              UNIQUE INDEX UNIQ_6D08E8CB989D9B62 (slug),
              INDEX statistical_race_idx (slug),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4 ENGINE = InnoDB
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE statistical_garage');
        $this->addSql('DROP TABLE statistical_race');
    }
}
