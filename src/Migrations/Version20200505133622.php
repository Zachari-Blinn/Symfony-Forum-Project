<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505133622 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE forum_id forum_id INT DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE topic_id topic_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE author author VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE conversation_user CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE has_read_topic CHANGE user_id user_id INT DEFAULT NULL, CHANGE topic_id topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participates CHANGE user_id user_id INT DEFAULT NULL, CHANGE party_id party_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partnership CHANGE website website VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE party CHANGE status_id status_id INT DEFAULT NULL, CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE expire_at expire_at DATETIME DEFAULT NULL, CHANGE price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE private_message CHANGE conversation_user_id conversation_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic CHANGE category_id category_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) DEFAULT NULL, CHANGE slug slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD slug VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL, CHANGE gender gender TINYINT(1) DEFAULT NULL, CHANGE birthday birthday DATE DEFAULT NULL, CHANGE localization localization VARCHAR(255) DEFAULT NULL, CHANGE image_filename image_filename VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE category CHANGE forum_id forum_id INT DEFAULT NULL, CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment CHANGE topic_id topic_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE author author VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE conversation_user CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forum CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE has_read_topic CHANGE user_id user_id INT DEFAULT NULL, CHANGE topic_id topic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participates CHANGE user_id user_id INT DEFAULT NULL, CHANGE party_id party_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partnership CHANGE website website VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE party CHANGE status_id status_id INT DEFAULT NULL, CHANGE title title VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE expire_at expire_at DATETIME DEFAULT \'NULL\', CHANGE price price DOUBLE PRECISION DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE private_message CHANGE conversation_user_id conversation_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reset_password_request CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topic CHANGE category_id category_id INT DEFAULT NULL, CHANGE user_id user_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE slug slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP created_at, DROP slug, CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE gender gender TINYINT(1) DEFAULT \'NULL\', CHANGE birthday birthday DATE DEFAULT \'NULL\', CHANGE localization localization VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE image_filename image_filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
