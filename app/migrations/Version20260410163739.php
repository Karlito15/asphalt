<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260410163739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Auditor Bundle Table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_inventory_app_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_9e639264d3f3a9ed637b55c8a1aa5475_idx (type),
              INDEX object_id_9e639264d3f3a9ed637b55c8a1aa5475_idx (object_id),
              INDEX discriminator_9e639264d3f3a9ed637b55c8a1aa5475_idx (discriminator),
              INDEX transaction_hash_9e639264d3f3a9ed637b55c8a1aa5475_idx (transaction_hash),
              INDEX blame_id_9e639264d3f3a9ed637b55c8a1aa5475_idx (blame_id),
              INDEX created_at_9e639264d3f3a9ed637b55c8a1aa5475_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_blueprint_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_69606c68c57952a38cffd46cc6289b46_idx (type),
              INDEX object_id_69606c68c57952a38cffd46cc6289b46_idx (object_id),
              INDEX discriminator_69606c68c57952a38cffd46cc6289b46_idx (discriminator),
              INDEX transaction_hash_69606c68c57952a38cffd46cc6289b46_idx (transaction_hash),
              INDEX blame_id_69606c68c57952a38cffd46cc6289b46_idx (blame_id),
              INDEX created_at_69606c68c57952a38cffd46cc6289b46_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_brand_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_358af7fbc536ff0dd8dfddd55fb8cc79_idx (type),
              INDEX object_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx (object_id),
              INDEX discriminator_358af7fbc536ff0dd8dfddd55fb8cc79_idx (discriminator),
              INDEX transaction_hash_358af7fbc536ff0dd8dfddd55fb8cc79_idx (transaction_hash),
              INDEX blame_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx (blame_id),
              INDEX created_at_358af7fbc536ff0dd8dfddd55fb8cc79_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_class_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_1bb0461c835f18982e7af68ad711f4a5_idx (type),
              INDEX object_id_1bb0461c835f18982e7af68ad711f4a5_idx (object_id),
              INDEX discriminator_1bb0461c835f18982e7af68ad711f4a5_idx (discriminator),
              INDEX transaction_hash_1bb0461c835f18982e7af68ad711f4a5_idx (transaction_hash),
              INDEX blame_id_1bb0461c835f18982e7af68ad711f4a5_idx (blame_id),
              INDEX created_at_1bb0461c835f18982e7af68ad711f4a5_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_level_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_599490067ab236f026ac419e5fb02788_idx (type),
              INDEX object_id_599490067ab236f026ac419e5fb02788_idx (object_id),
              INDEX discriminator_599490067ab236f026ac419e5fb02788_idx (discriminator),
              INDEX transaction_hash_599490067ab236f026ac419e5fb02788_idx (transaction_hash),
              INDEX blame_id_599490067ab236f026ac419e5fb02788_idx (blame_id),
              INDEX created_at_599490067ab236f026ac419e5fb02788_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_tag_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_b961c2d0ead1bf389a63316f3b7ad5e2_idx (type),
              INDEX object_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx (object_id),
              INDEX discriminator_b961c2d0ead1bf389a63316f3b7ad5e2_idx (discriminator),
              INDEX transaction_hash_b961c2d0ead1bf389a63316f3b7ad5e2_idx (transaction_hash),
              INDEX blame_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx (blame_id),
              INDEX created_at_b961c2d0ead1bf389a63316f3b7ad5e2_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_setting_unit_price_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_8e9bcdf38cadaad205babcb84ddd33a2_idx (type),
              INDEX object_id_8e9bcdf38cadaad205babcb84ddd33a2_idx (object_id),
              INDEX discriminator_8e9bcdf38cadaad205babcb84ddd33a2_idx (discriminator),
              INDEX transaction_hash_8e9bcdf38cadaad205babcb84ddd33a2_idx (transaction_hash),
              INDEX blame_id_8e9bcdf38cadaad205babcb84ddd33a2_idx (blame_id),
              INDEX created_at_8e9bcdf38cadaad205babcb84ddd33a2_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_app_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_c852aad36a430fcec932ec00484f9df6_idx (type),
              INDEX object_id_c852aad36a430fcec932ec00484f9df6_idx (object_id),
              INDEX discriminator_c852aad36a430fcec932ec00484f9df6_idx (discriminator),
              INDEX transaction_hash_c852aad36a430fcec932ec00484f9df6_idx (transaction_hash),
              INDEX blame_id_c852aad36a430fcec932ec00484f9df6_idx (blame_id),
              INDEX created_at_c852aad36a430fcec932ec00484f9df6_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_blueprint_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_cd2687632715eee31fe71cac17c433cb_idx (type),
              INDEX object_id_cd2687632715eee31fe71cac17c433cb_idx (object_id),
              INDEX discriminator_cd2687632715eee31fe71cac17c433cb_idx (discriminator),
              INDEX transaction_hash_cd2687632715eee31fe71cac17c433cb_idx (transaction_hash),
              INDEX blame_id_cd2687632715eee31fe71cac17c433cb_idx (blame_id),
              INDEX created_at_cd2687632715eee31fe71cac17c433cb_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_gauntlet_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_05dc1686ae8f1de9b78d6b06817d8066_idx (type),
              INDEX object_id_05dc1686ae8f1de9b78d6b06817d8066_idx (object_id),
              INDEX discriminator_05dc1686ae8f1de9b78d6b06817d8066_idx (discriminator),
              INDEX transaction_hash_05dc1686ae8f1de9b78d6b06817d8066_idx (transaction_hash),
              INDEX blame_id_05dc1686ae8f1de9b78d6b06817d8066_idx (blame_id),
              INDEX created_at_05dc1686ae8f1de9b78d6b06817d8066_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_rank_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_0a3c788e84102451599e7c4d640f5817_idx (type),
              INDEX object_id_0a3c788e84102451599e7c4d640f5817_idx (object_id),
              INDEX discriminator_0a3c788e84102451599e7c4d640f5817_idx (discriminator),
              INDEX transaction_hash_0a3c788e84102451599e7c4d640f5817_idx (transaction_hash),
              INDEX blame_id_0a3c788e84102451599e7c4d640f5817_idx (blame_id),
              INDEX created_at_0a3c788e84102451599e7c4d640f5817_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_stat_actual_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_dc23d6baa2b271f9f7c7b8e56565441f_idx (type),
              INDEX object_id_dc23d6baa2b271f9f7c7b8e56565441f_idx (object_id),
              INDEX discriminator_dc23d6baa2b271f9f7c7b8e56565441f_idx (discriminator),
              INDEX transaction_hash_dc23d6baa2b271f9f7c7b8e56565441f_idx (transaction_hash),
              INDEX blame_id_dc23d6baa2b271f9f7c7b8e56565441f_idx (blame_id),
              INDEX created_at_dc23d6baa2b271f9f7c7b8e56565441f_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_stat_max_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_8f308c87ffa3a840f566b1bdefad1be2_idx (type),
              INDEX object_id_8f308c87ffa3a840f566b1bdefad1be2_idx (object_id),
              INDEX discriminator_8f308c87ffa3a840f566b1bdefad1be2_idx (discriminator),
              INDEX transaction_hash_8f308c87ffa3a840f566b1bdefad1be2_idx (transaction_hash),
              INDEX blame_id_8f308c87ffa3a840f566b1bdefad1be2_idx (blame_id),
              INDEX created_at_8f308c87ffa3a840f566b1bdefad1be2_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_stat_min_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_8e894a7e0e44d8afe1972420673f0530_idx (type),
              INDEX object_id_8e894a7e0e44d8afe1972420673f0530_idx (object_id),
              INDEX discriminator_8e894a7e0e44d8afe1972420673f0530_idx (discriminator),
              INDEX transaction_hash_8e894a7e0e44d8afe1972420673f0530_idx (transaction_hash),
              INDEX blame_id_8e894a7e0e44d8afe1972420673f0530_idx (blame_id),
              INDEX created_at_8e894a7e0e44d8afe1972420673f0530_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_status_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_a185ae0b55f2f4972df30353590d93f7_idx (type),
              INDEX object_id_a185ae0b55f2f4972df30353590d93f7_idx (object_id),
              INDEX discriminator_a185ae0b55f2f4972df30353590d93f7_idx (discriminator),
              INDEX transaction_hash_a185ae0b55f2f4972df30353590d93f7_idx (transaction_hash),
              INDEX blame_id_a185ae0b55f2f4972df30353590d93f7_idx (blame_id),
              INDEX created_at_a185ae0b55f2f4972df30353590d93f7_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_status_control_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_1a809f888992b6545a6b500edf404a93_idx (type),
              INDEX object_id_1a809f888992b6545a6b500edf404a93_idx (object_id),
              INDEX discriminator_1a809f888992b6545a6b500edf404a93_idx (discriminator),
              INDEX transaction_hash_1a809f888992b6545a6b500edf404a93_idx (transaction_hash),
              INDEX blame_id_1a809f888992b6545a6b500edf404a93_idx (blame_id),
              INDEX created_at_1a809f888992b6545a6b500edf404a93_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE zzz_audit_log_garage_upgrade_audit (
              id INT UNSIGNED AUTO_INCREMENT NOT NULL,
              type VARCHAR(10) NOT NULL,
              object_id VARCHAR(255) NOT NULL,
              discriminator VARCHAR(255) DEFAULT NULL,
              transaction_hash VARCHAR(40) DEFAULT NULL,
              diffs JSON DEFAULT NULL,
              extra_data JSON DEFAULT NULL,
              blame_id VARCHAR(255) DEFAULT NULL,
              blame_user VARCHAR(255) DEFAULT NULL,
              blame_user_fqdn VARCHAR(255) DEFAULT NULL,
              blame_user_firewall VARCHAR(100) DEFAULT NULL,
              ip VARCHAR(45) DEFAULT NULL,
              created_at DATETIME NOT NULL,
              INDEX type_137775d3022178df20d52f74beefc6e1_idx (type),
              INDEX object_id_137775d3022178df20d52f74beefc6e1_idx (object_id),
              INDEX discriminator_137775d3022178df20d52f74beefc6e1_idx (discriminator),
              INDEX transaction_hash_137775d3022178df20d52f74beefc6e1_idx (transaction_hash),
              INDEX blame_id_137775d3022178df20d52f74beefc6e1_idx (blame_id),
              INDEX created_at_137775d3022178df20d52f74beefc6e1_idx (created_at),
              PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE zzz_audit_log_garage_app_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_blueprint_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_gauntlet_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_rank_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_stat_actual_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_stat_max_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_stat_min_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_status_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_status_control_audit');
        $this->addSql('DROP TABLE zzz_audit_log_garage_upgrade_audit');
        $this->addSql('DROP TABLE zzz_audit_log_inventory_app_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_blueprint_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_brand_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_class_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_level_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_tag_audit');
        $this->addSql('DROP TABLE zzz_audit_log_setting_unit_price_audit');
    }
}
