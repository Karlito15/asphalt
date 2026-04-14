<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260408163746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Mission Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission_app (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            week SMALLINT UNSIGNED DEFAULT 1 NOT NULL,
            region VARCHAR(64) DEFAULT NULL,
            track VARCHAR(64) DEFAULT NULL,
            class VARCHAR(16) DEFAULT NULL,
            brand VARCHAR(64) DEFAULT NULL,
            description VARCHAR(32) DEFAULT NULL,
            success SMALLINT UNSIGNED DEFAULT 0 NOT NULL,
            target SMALLINT UNSIGNED DEFAULT 1 NOT NULL,
            task_id INT UNSIGNED NOT NULL,
            type_id INT UNSIGNED NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            INDEX IDX_520BE7B68DB60186 (task_id),
            INDEX IDX_520BE7B6C54C8C93 (type_id),
            INDEX mission_app_idx (id),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE mission_task (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            value VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_7B3C772A989D9B62 (slug),
            UNIQUE INDEX UNIQ_7B3C772A1D775834 (value),
            INDEX mission_task_idx (slug),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('CREATE TABLE mission_type (
            id INT UNSIGNED AUTO_INCREMENT NOT NULL,
            value VARCHAR(64) NOT NULL,
            slug VARCHAR(64) NOT NULL,
            created_at DATETIME NOT NULL,
            updated_at DATETIME NOT NULL,
            deleted_at DATETIME DEFAULT NULL,
            UNIQUE INDEX UNIQ_A59CFB26989D9B62 (slug),
            UNIQUE INDEX UNIQ_A59CFB261D775834 (value),
            INDEX mission_type_idx (slug),
            PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8'
        );
        $this->addSql('ALTER TABLE mission_app ADD CONSTRAINT FK_520BE7B68DB60186 FOREIGN KEY (task_id) REFERENCES mission_task (id)');
        $this->addSql('ALTER TABLE mission_app ADD CONSTRAINT FK_520BE7B6C54C8C93 FOREIGN KEY (type_id) REFERENCES mission_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission_app DROP FOREIGN KEY FK_520BE7B68DB60186');
        $this->addSql('ALTER TABLE mission_app DROP FOREIGN KEY FK_520BE7B6C54C8C93');
        $this->addSql('DROP TABLE mission_app');
        $this->addSql('DROP TABLE mission_task');
        $this->addSql('DROP TABLE mission_type');
    }
}
