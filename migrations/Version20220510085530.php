<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220510085530 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, path text NOT NULL, provider_id INT NOT NULL, KEY `provider_id` (`provider_id`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image_tag (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, tag_id INT NOT NULL, KEY `image_id` (`image_id`), KEY `tag_id` (`tag_id`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bookmark (id INT AUTO_INCREMENT NOT NULL, image_id INT NOT NULL, user_id INT NOT NULL, KEY `image_id` (`image_id`), KEY `user_id` (`user_id`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT image_ibfk_1 FOREIGN KEY (provider_id) REFERENCES provider (id)');
        $this->addSql('ALTER TABLE image_tag ADD CONSTRAINT image_tag_ibfk_1 FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE image_tag ADD CONSTRAINT image_tag_ibfk_2 FOREIGN KEY (tag_id) REFERENCES tag (id)');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT bookmark_ibfk_1 FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE bookmark ADD CONSTRAINT bookmark_ibfk_2 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY bookmark_ibfk_2');
        $this->addSql('ALTER TABLE bookmark DROP FOREIGN KEY bookmark_ibfk_1');
        $this->addSql('ALTER TABLE image_tag DROP FOREIGN KEY image_tag_ibfk_2');
        $this->addSql('ALTER TABLE image_tag DROP FOREIGN KEY image_tag_ibfk_1');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY image_ibfk_1');
        $this->addSql('DROP TABLE image_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE bookmark');
        $this->addSql('DROP TABLE user');
    }
}
