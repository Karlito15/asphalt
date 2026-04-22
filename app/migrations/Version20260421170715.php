<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260421170715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statistical_garage (name VARCHAR(64) NOT NULL, value JSON DEFAULT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, id INT UNSIGNED AUTO_INCREMENT NOT NULL, UNIQUE INDEX UNIQ_6CD578815E237E06 (name), UNIQUE INDEX UNIQ_6CD57881989D9B62 (slug), INDEX statistical_garage_idx (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE statistical_import (name VARCHAR(64) NOT NULL, value JSON DEFAULT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, id INT UNSIGNED AUTO_INCREMENT NOT NULL, UNIQUE INDEX UNIQ_6EBDD7975E237E06 (name), UNIQUE INDEX UNIQ_6EBDD797989D9B62 (slug), INDEX statistical_import_idx (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('CREATE TABLE statistical_race (name VARCHAR(64) NOT NULL, value JSON DEFAULT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, id INT UNSIGNED AUTO_INCREMENT NOT NULL, UNIQUE INDEX UNIQ_6D08E8CB5E237E06 (name), UNIQUE INDEX UNIQ_6D08E8CB989D9B62 (slug), INDEX statistical_race_idx (slug), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX type_c852aad36a430fcec932ec00484f9df6_idx TO type_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX object_id_c852aad36a430fcec932ec00484f9df6_idx TO object_id_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX discriminator_c852aad36a430fcec932ec00484f9df6_idx TO discriminator_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX transaction_hash_c852aad36a430fcec932ec00484f9df6_idx TO transaction_hash_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX blame_id_c852aad36a430fcec932ec00484f9df6_idx TO blame_id_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX created_at_c852aad36a430fcec932ec00484f9df6_idx TO created_at_7a788946f261937d6df6c417f5681106_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX type_cd2687632715eee31fe71cac17c433cb_idx TO type_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX object_id_cd2687632715eee31fe71cac17c433cb_idx TO object_id_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX discriminator_cd2687632715eee31fe71cac17c433cb_idx TO discriminator_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX transaction_hash_cd2687632715eee31fe71cac17c433cb_idx TO transaction_hash_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX blame_id_cd2687632715eee31fe71cac17c433cb_idx TO blame_id_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX created_at_cd2687632715eee31fe71cac17c433cb_idx TO created_at_e173c286a39fe4fb53e62d45345dd66e_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX type_05dc1686ae8f1de9b78d6b06817d8066_idx TO type_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX object_id_05dc1686ae8f1de9b78d6b06817d8066_idx TO object_id_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX discriminator_05dc1686ae8f1de9b78d6b06817d8066_idx TO discriminator_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX transaction_hash_05dc1686ae8f1de9b78d6b06817d8066_idx TO transaction_hash_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX blame_id_05dc1686ae8f1de9b78d6b06817d8066_idx TO blame_id_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX created_at_05dc1686ae8f1de9b78d6b06817d8066_idx TO created_at_408436d8a6b2150f1db9ca80cc4fba1f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX type_0a3c788e84102451599e7c4d640f5817_idx TO type_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX object_id_0a3c788e84102451599e7c4d640f5817_idx TO object_id_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX discriminator_0a3c788e84102451599e7c4d640f5817_idx TO discriminator_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX transaction_hash_0a3c788e84102451599e7c4d640f5817_idx TO transaction_hash_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX blame_id_0a3c788e84102451599e7c4d640f5817_idx TO blame_id_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX created_at_0a3c788e84102451599e7c4d640f5817_idx TO created_at_482a7042bdfe16e5fe8cb5640c508129_idx');
        $this->addSql('ALTER TABLE garage_stat_actual CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX type_dc23d6baa2b271f9f7c7b8e56565441f_idx TO type_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX object_id_dc23d6baa2b271f9f7c7b8e56565441f_idx TO object_id_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX discriminator_dc23d6baa2b271f9f7c7b8e56565441f_idx TO discriminator_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX transaction_hash_dc23d6baa2b271f9f7c7b8e56565441f_idx TO transaction_hash_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX blame_id_dc23d6baa2b271f9f7c7b8e56565441f_idx TO blame_id_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX created_at_dc23d6baa2b271f9f7c7b8e56565441f_idx TO created_at_76c8285059c58d3867e74f1d8de6e8f3_idx');
        $this->addSql('ALTER TABLE garage_stat_max CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX type_8f308c87ffa3a840f566b1bdefad1be2_idx TO type_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX object_id_8f308c87ffa3a840f566b1bdefad1be2_idx TO object_id_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX discriminator_8f308c87ffa3a840f566b1bdefad1be2_idx TO discriminator_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX transaction_hash_8f308c87ffa3a840f566b1bdefad1be2_idx TO transaction_hash_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX blame_id_8f308c87ffa3a840f566b1bdefad1be2_idx TO blame_id_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX created_at_8f308c87ffa3a840f566b1bdefad1be2_idx TO created_at_382a978d5fbb58ae9128d91de8127f71_idx');
        $this->addSql('ALTER TABLE garage_stat_min CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX type_8e894a7e0e44d8afe1972420673f0530_idx TO type_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX object_id_8e894a7e0e44d8afe1972420673f0530_idx TO object_id_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX discriminator_8e894a7e0e44d8afe1972420673f0530_idx TO discriminator_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX transaction_hash_8e894a7e0e44d8afe1972420673f0530_idx TO transaction_hash_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX blame_id_8e894a7e0e44d8afe1972420673f0530_idx TO blame_id_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX created_at_8e894a7e0e44d8afe1972420673f0530_idx TO created_at_90abda25ae7f4e22718dca9c2cd87fab_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX type_a185ae0b55f2f4972df30353590d93f7_idx TO type_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX object_id_a185ae0b55f2f4972df30353590d93f7_idx TO object_id_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX discriminator_a185ae0b55f2f4972df30353590d93f7_idx TO discriminator_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX transaction_hash_a185ae0b55f2f4972df30353590d93f7_idx TO transaction_hash_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX blame_id_a185ae0b55f2f4972df30353590d93f7_idx TO blame_id_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX created_at_a185ae0b55f2f4972df30353590d93f7_idx TO created_at_2ea1b9b77da04225d466b3b6c2811cbf_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX type_1a809f888992b6545a6b500edf404a93_idx TO type_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX object_id_1a809f888992b6545a6b500edf404a93_idx TO object_id_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX discriminator_1a809f888992b6545a6b500edf404a93_idx TO discriminator_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX transaction_hash_1a809f888992b6545a6b500edf404a93_idx TO transaction_hash_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX blame_id_1a809f888992b6545a6b500edf404a93_idx TO blame_id_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX created_at_1a809f888992b6545a6b500edf404a93_idx TO created_at_b2f084e0c412d51b5422063f28de304d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX type_137775d3022178df20d52f74beefc6e1_idx TO type_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX object_id_137775d3022178df20d52f74beefc6e1_idx TO object_id_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX discriminator_137775d3022178df20d52f74beefc6e1_idx TO discriminator_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX transaction_hash_137775d3022178df20d52f74beefc6e1_idx TO transaction_hash_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX blame_id_137775d3022178df20d52f74beefc6e1_idx TO blame_id_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX created_at_137775d3022178df20d52f74beefc6e1_idx TO created_at_c751cc1855a40557b1fa02a2a2c7bd9c_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX type_9e639264d3f3a9ed637b55c8a1aa5475_idx TO type_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX object_id_9e639264d3f3a9ed637b55c8a1aa5475_idx TO object_id_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX discriminator_9e639264d3f3a9ed637b55c8a1aa5475_idx TO discriminator_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX transaction_hash_9e639264d3f3a9ed637b55c8a1aa5475_idx TO transaction_hash_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX blame_id_9e639264d3f3a9ed637b55c8a1aa5475_idx TO blame_id_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX created_at_9e639264d3f3a9ed637b55c8a1aa5475_idx TO created_at_8661565d5a36a7a9d2eb33caead7b1b5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX type_69606c68c57952a38cffd46cc6289b46_idx TO type_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX object_id_69606c68c57952a38cffd46cc6289b46_idx TO object_id_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX discriminator_69606c68c57952a38cffd46cc6289b46_idx TO discriminator_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX transaction_hash_69606c68c57952a38cffd46cc6289b46_idx TO transaction_hash_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX blame_id_69606c68c57952a38cffd46cc6289b46_idx TO blame_id_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX created_at_69606c68c57952a38cffd46cc6289b46_idx TO created_at_4af3e9cb0cff345241b7802561370e45_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX type_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO type_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX object_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO object_id_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX discriminator_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO discriminator_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX transaction_hash_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO transaction_hash_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX blame_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO blame_id_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX created_at_358af7fbc536ff0dd8dfddd55fb8cc79_idx TO created_at_dd056ac6c0a9410b685d860d9826fd1d_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX type_1bb0461c835f18982e7af68ad711f4a5_idx TO type_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX object_id_1bb0461c835f18982e7af68ad711f4a5_idx TO object_id_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX discriminator_1bb0461c835f18982e7af68ad711f4a5_idx TO discriminator_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX transaction_hash_1bb0461c835f18982e7af68ad711f4a5_idx TO transaction_hash_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX blame_id_1bb0461c835f18982e7af68ad711f4a5_idx TO blame_id_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX created_at_1bb0461c835f18982e7af68ad711f4a5_idx TO created_at_3a7de0c1654ec186567ba9ef4ed54c89_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX type_599490067ab236f026ac419e5fb02788_idx TO type_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX object_id_599490067ab236f026ac419e5fb02788_idx TO object_id_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX discriminator_599490067ab236f026ac419e5fb02788_idx TO discriminator_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX transaction_hash_599490067ab236f026ac419e5fb02788_idx TO transaction_hash_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX blame_id_599490067ab236f026ac419e5fb02788_idx TO blame_id_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX created_at_599490067ab236f026ac419e5fb02788_idx TO created_at_95abc8ae1da0ea559782b15730ba8955_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX type_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO type_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX object_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO object_id_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX discriminator_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO discriminator_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX transaction_hash_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO transaction_hash_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX blame_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO blame_id_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX created_at_b961c2d0ead1bf389a63316f3b7ad5e2_idx TO created_at_ec0599b158734dcc6805d68292e93c14_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX type_8e9bcdf38cadaad205babcb84ddd33a2_idx TO type_9c928d5985877c3e341ac12aec47ab77_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX object_id_8e9bcdf38cadaad205babcb84ddd33a2_idx TO object_id_9c928d5985877c3e341ac12aec47ab77_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX discriminator_8e9bcdf38cadaad205babcb84ddd33a2_idx TO discriminator_9c928d5985877c3e341ac12aec47ab77_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX transaction_hash_8e9bcdf38cadaad205babcb84ddd33a2_idx TO transaction_hash_9c928d5985877c3e341ac12aec47ab77_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX blame_id_8e9bcdf38cadaad205babcb84ddd33a2_idx TO blame_id_9c928d5985877c3e341ac12aec47ab77_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX created_at_8e9bcdf38cadaad205babcb84ddd33a2_idx TO created_at_9c928d5985877c3e341ac12aec47ab77_idx');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE statistical_garage');
        $this->addSql('DROP TABLE statistical_import');
        $this->addSql('DROP TABLE statistical_race');
        $this->addSql('ALTER TABLE garage_stat_actual CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE garage_stat_max CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE garage_stat_min CHANGE speed speed DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE acceleration acceleration DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE handling handling DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE nitro nitro DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL, CHANGE average average DOUBLE PRECISION UNSIGNED DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX blame_id_7a788946f261937d6df6c417f5681106_idx TO blame_id_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX object_id_7a788946f261937d6df6c417f5681106_idx TO object_id_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX created_at_7a788946f261937d6df6c417f5681106_idx TO created_at_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX discriminator_7a788946f261937d6df6c417f5681106_idx TO discriminator_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX transaction_hash_7a788946f261937d6df6c417f5681106_idx TO transaction_hash_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_app_audit RENAME INDEX type_7a788946f261937d6df6c417f5681106_idx TO type_c852aad36a430fcec932ec00484f9df6_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX blame_id_e173c286a39fe4fb53e62d45345dd66e_idx TO blame_id_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX object_id_e173c286a39fe4fb53e62d45345dd66e_idx TO object_id_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX created_at_e173c286a39fe4fb53e62d45345dd66e_idx TO created_at_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX discriminator_e173c286a39fe4fb53e62d45345dd66e_idx TO discriminator_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX transaction_hash_e173c286a39fe4fb53e62d45345dd66e_idx TO transaction_hash_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_blueprint_audit RENAME INDEX type_e173c286a39fe4fb53e62d45345dd66e_idx TO type_cd2687632715eee31fe71cac17c433cb_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX transaction_hash_408436d8a6b2150f1db9ca80cc4fba1f_idx TO transaction_hash_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX type_408436d8a6b2150f1db9ca80cc4fba1f_idx TO type_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX blame_id_408436d8a6b2150f1db9ca80cc4fba1f_idx TO blame_id_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX object_id_408436d8a6b2150f1db9ca80cc4fba1f_idx TO object_id_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX created_at_408436d8a6b2150f1db9ca80cc4fba1f_idx TO created_at_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_gauntlet_audit RENAME INDEX discriminator_408436d8a6b2150f1db9ca80cc4fba1f_idx TO discriminator_05dc1686ae8f1de9b78d6b06817d8066_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX transaction_hash_482a7042bdfe16e5fe8cb5640c508129_idx TO transaction_hash_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX type_482a7042bdfe16e5fe8cb5640c508129_idx TO type_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX blame_id_482a7042bdfe16e5fe8cb5640c508129_idx TO blame_id_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX object_id_482a7042bdfe16e5fe8cb5640c508129_idx TO object_id_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX created_at_482a7042bdfe16e5fe8cb5640c508129_idx TO created_at_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_rank_audit RENAME INDEX discriminator_482a7042bdfe16e5fe8cb5640c508129_idx TO discriminator_0a3c788e84102451599e7c4d640f5817_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX created_at_2ea1b9b77da04225d466b3b6c2811cbf_idx TO created_at_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX discriminator_2ea1b9b77da04225d466b3b6c2811cbf_idx TO discriminator_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX transaction_hash_2ea1b9b77da04225d466b3b6c2811cbf_idx TO transaction_hash_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX type_2ea1b9b77da04225d466b3b6c2811cbf_idx TO type_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX blame_id_2ea1b9b77da04225d466b3b6c2811cbf_idx TO blame_id_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_audit RENAME INDEX object_id_2ea1b9b77da04225d466b3b6c2811cbf_idx TO object_id_a185ae0b55f2f4972df30353590d93f7_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX object_id_b2f084e0c412d51b5422063f28de304d_idx TO object_id_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX created_at_b2f084e0c412d51b5422063f28de304d_idx TO created_at_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX discriminator_b2f084e0c412d51b5422063f28de304d_idx TO discriminator_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX transaction_hash_b2f084e0c412d51b5422063f28de304d_idx TO transaction_hash_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX type_b2f084e0c412d51b5422063f28de304d_idx TO type_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_status_control_audit RENAME INDEX blame_id_b2f084e0c412d51b5422063f28de304d_idx TO blame_id_1a809f888992b6545a6b500edf404a93_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX blame_id_76c8285059c58d3867e74f1d8de6e8f3_idx TO blame_id_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX object_id_76c8285059c58d3867e74f1d8de6e8f3_idx TO object_id_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX created_at_76c8285059c58d3867e74f1d8de6e8f3_idx TO created_at_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX discriminator_76c8285059c58d3867e74f1d8de6e8f3_idx TO discriminator_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX transaction_hash_76c8285059c58d3867e74f1d8de6e8f3_idx TO transaction_hash_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_actual_audit RENAME INDEX type_76c8285059c58d3867e74f1d8de6e8f3_idx TO type_dc23d6baa2b271f9f7c7b8e56565441f_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX transaction_hash_382a978d5fbb58ae9128d91de8127f71_idx TO transaction_hash_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX type_382a978d5fbb58ae9128d91de8127f71_idx TO type_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX blame_id_382a978d5fbb58ae9128d91de8127f71_idx TO blame_id_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX object_id_382a978d5fbb58ae9128d91de8127f71_idx TO object_id_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX created_at_382a978d5fbb58ae9128d91de8127f71_idx TO created_at_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_max_audit RENAME INDEX discriminator_382a978d5fbb58ae9128d91de8127f71_idx TO discriminator_8f308c87ffa3a840f566b1bdefad1be2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX transaction_hash_90abda25ae7f4e22718dca9c2cd87fab_idx TO transaction_hash_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX type_90abda25ae7f4e22718dca9c2cd87fab_idx TO type_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX blame_id_90abda25ae7f4e22718dca9c2cd87fab_idx TO blame_id_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX object_id_90abda25ae7f4e22718dca9c2cd87fab_idx TO object_id_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX created_at_90abda25ae7f4e22718dca9c2cd87fab_idx TO created_at_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_stat_min_audit RENAME INDEX discriminator_90abda25ae7f4e22718dca9c2cd87fab_idx TO discriminator_8e894a7e0e44d8afe1972420673f0530_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX created_at_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO created_at_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX discriminator_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO discriminator_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX transaction_hash_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO transaction_hash_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX type_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO type_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX blame_id_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO blame_id_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_garage_upgrade_audit RENAME INDEX object_id_c751cc1855a40557b1fa02a2a2c7bd9c_idx TO object_id_137775d3022178df20d52f74beefc6e1_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX created_at_8661565d5a36a7a9d2eb33caead7b1b5_idx TO created_at_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX discriminator_8661565d5a36a7a9d2eb33caead7b1b5_idx TO discriminator_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX transaction_hash_8661565d5a36a7a9d2eb33caead7b1b5_idx TO transaction_hash_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX type_8661565d5a36a7a9d2eb33caead7b1b5_idx TO type_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX blame_id_8661565d5a36a7a9d2eb33caead7b1b5_idx TO blame_id_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_inventory_app_audit RENAME INDEX object_id_8661565d5a36a7a9d2eb33caead7b1b5_idx TO object_id_9e639264d3f3a9ed637b55c8a1aa5475_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX blame_id_4af3e9cb0cff345241b7802561370e45_idx TO blame_id_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX object_id_4af3e9cb0cff345241b7802561370e45_idx TO object_id_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX created_at_4af3e9cb0cff345241b7802561370e45_idx TO created_at_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX discriminator_4af3e9cb0cff345241b7802561370e45_idx TO discriminator_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX transaction_hash_4af3e9cb0cff345241b7802561370e45_idx TO transaction_hash_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_blueprint_audit RENAME INDEX type_4af3e9cb0cff345241b7802561370e45_idx TO type_69606c68c57952a38cffd46cc6289b46_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX type_dd056ac6c0a9410b685d860d9826fd1d_idx TO type_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX blame_id_dd056ac6c0a9410b685d860d9826fd1d_idx TO blame_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX object_id_dd056ac6c0a9410b685d860d9826fd1d_idx TO object_id_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX created_at_dd056ac6c0a9410b685d860d9826fd1d_idx TO created_at_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX discriminator_dd056ac6c0a9410b685d860d9826fd1d_idx TO discriminator_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_brand_audit RENAME INDEX transaction_hash_dd056ac6c0a9410b685d860d9826fd1d_idx TO transaction_hash_358af7fbc536ff0dd8dfddd55fb8cc79_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX transaction_hash_3a7de0c1654ec186567ba9ef4ed54c89_idx TO transaction_hash_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX type_3a7de0c1654ec186567ba9ef4ed54c89_idx TO type_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX blame_id_3a7de0c1654ec186567ba9ef4ed54c89_idx TO blame_id_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX object_id_3a7de0c1654ec186567ba9ef4ed54c89_idx TO object_id_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX created_at_3a7de0c1654ec186567ba9ef4ed54c89_idx TO created_at_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_class_audit RENAME INDEX discriminator_3a7de0c1654ec186567ba9ef4ed54c89_idx TO discriminator_1bb0461c835f18982e7af68ad711f4a5_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX discriminator_95abc8ae1da0ea559782b15730ba8955_idx TO discriminator_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX transaction_hash_95abc8ae1da0ea559782b15730ba8955_idx TO transaction_hash_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX type_95abc8ae1da0ea559782b15730ba8955_idx TO type_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX blame_id_95abc8ae1da0ea559782b15730ba8955_idx TO blame_id_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX object_id_95abc8ae1da0ea559782b15730ba8955_idx TO object_id_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_level_audit RENAME INDEX created_at_95abc8ae1da0ea559782b15730ba8955_idx TO created_at_599490067ab236f026ac419e5fb02788_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX created_at_ec0599b158734dcc6805d68292e93c14_idx TO created_at_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX discriminator_ec0599b158734dcc6805d68292e93c14_idx TO discriminator_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX transaction_hash_ec0599b158734dcc6805d68292e93c14_idx TO transaction_hash_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX type_ec0599b158734dcc6805d68292e93c14_idx TO type_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX blame_id_ec0599b158734dcc6805d68292e93c14_idx TO blame_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_tag_audit RENAME INDEX object_id_ec0599b158734dcc6805d68292e93c14_idx TO object_id_b961c2d0ead1bf389a63316f3b7ad5e2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX blame_id_9c928d5985877c3e341ac12aec47ab77_idx TO blame_id_8e9bcdf38cadaad205babcb84ddd33a2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX object_id_9c928d5985877c3e341ac12aec47ab77_idx TO object_id_8e9bcdf38cadaad205babcb84ddd33a2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX created_at_9c928d5985877c3e341ac12aec47ab77_idx TO created_at_8e9bcdf38cadaad205babcb84ddd33a2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX discriminator_9c928d5985877c3e341ac12aec47ab77_idx TO discriminator_8e9bcdf38cadaad205babcb84ddd33a2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX transaction_hash_9c928d5985877c3e341ac12aec47ab77_idx TO transaction_hash_8e9bcdf38cadaad205babcb84ddd33a2_idx');
        $this->addSql('ALTER TABLE zzz_audit_log_setting_unit_price_audit RENAME INDEX type_9c928d5985877c3e341ac12aec47ab77_idx TO type_8e9bcdf38cadaad205babcb84ddd33a2_idx');
    }
}
