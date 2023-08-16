<?php

declare(strict_types=1);

namespace migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230813223906 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, credit INT NOT NULL, firstname VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, confirmation_token LONGTEXT DEFAULT NULL, reset_password_token LONGTEXT DEFAULT NULL, lastname VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE room (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, name_spin_and_go VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, room VARCHAR(255) NOT NULL, buy_in DOUBLE PRECISION NOT NULL, multiplicator INT NOT NULL, place INT NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_232B318CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buy_in (id INT AUTO_INCREMENT NOT NULL, room_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, INDEX IDX_AA2E7A6754177093 (room_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE multiplicator (id INT AUTO_INCREMENT NOT NULL, buy_in_id INT NOT NULL, value INT NOT NULL, INDEX IDX_32CDCF3822DF848C (buy_in_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ranked (id INT AUTO_INCREMENT NOT NULL, multiplicator_id INT NOT NULL, position INT NOT NULL, price INT NOT NULL, INDEX IDX_9E54CDC6E58E04A6 (multiplicator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE buy_in ADD CONSTRAINT FK_AA2E7A6754177093 FOREIGN KEY (room_id) REFERENCES room (id)');
        $this->addSql('ALTER TABLE multiplicator ADD CONSTRAINT FK_32CDCF3822DF848C FOREIGN KEY (buy_in_id) REFERENCES buy_in (id)');
        $this->addSql('ALTER TABLE ranked ADD CONSTRAINT FK_9E54CDC6E58E04A6 FOREIGN KEY (multiplicator_id) REFERENCES multiplicator (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE multiplicator DROP FOREIGN KEY FK_32CDCF3822DF848C');
        $this->addSql('ALTER TABLE ranked DROP FOREIGN KEY FK_9E54CDC6E58E04A6');
        $this->addSql('ALTER TABLE buy_in DROP FOREIGN KEY FK_AA2E7A6754177093');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CA76ED395');
        $this->addSql('DROP TABLE buy_in');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE multiplicator');
        $this->addSql('DROP TABLE ranked');
        $this->addSql('DROP TABLE room');
        $this->addSql('DROP TABLE user');
    }
}
