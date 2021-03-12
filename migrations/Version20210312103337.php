<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210312103337 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, blog_category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, content_2 LONGTEXT DEFAULT NULL, content_3 LONGTEXT DEFAULT NULL, main_image VARCHAR(255) NOT NULL, second_image VARCHAR(255) DEFAULT NULL, third_image VARCHAR(255) DEFAULT NULL, fourth_image VARCHAR(255) DEFAULT NULL, fifth_image VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_C0155143F675F31B (author_id), INDEX IDX_C0155143CB76011C (blog_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE blog_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, category_icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, booker_id INT NOT NULL, listing_id INT NOT NULL, created_at DATETIME NOT NULL, amount DOUBLE PRECISION NOT NULL, comment LONGTEXT DEFAULT NULL, INDEX IDX_E00CEDDE8B7E4006 (booker_id), INDEX IDX_E00CEDDED4619D1A (listing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, listing_id INT NOT NULL, author_id INT NOT NULL, created_at DATETIME NOT NULL, rating INT NOT NULL, content LONGTEXT NOT NULL, INDEX IDX_9474526CD4619D1A (listing_id), INDEX IDX_9474526CF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE front_page (id INT AUTO_INCREMENT NOT NULL, front_title VARCHAR(255) NOT NULL, front_introduction VARCHAR(255) NOT NULL, front_main_image VARCHAR(255) NOT NULL, front_footer_about LONGTEXT NOT NULL, front_footer_location VARCHAR(255) NOT NULL, front_footer_website VARCHAR(255) DEFAULT NULL, front_footer_contact_1 VARCHAR(255) NOT NULL, front_footer_contact_2 VARCHAR(255) DEFAULT NULL, front_footer_email VARCHAR(255) NOT NULL, front_footer_facebook VARCHAR(255) DEFAULT NULL, front_footer_twitter VARCHAR(255) DEFAULT NULL, front_footer_instagram VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guides (id INT AUTO_INCREMENT NOT NULL, guide_name VARCHAR(255) NOT NULL, guide_picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, listing_category_id INT NOT NULL, title VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, main_image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_CB0048D4F675F31B (author_id), INDEX IDX_CB0048D4455844B0 (listing_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, category_icon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE listing_image (id INT AUTO_INCREMENT NOT NULL, listing_id INT NOT NULL, url VARCHAR(255) NOT NULL, caption VARCHAR(255) DEFAULT NULL, INDEX IDX_33D3DCD3D4619D1A (listing_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, user_phone VARCHAR(255) DEFAULT NULL, registered_at DATETIME DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE blog ADD CONSTRAINT FK_C0155143CB76011C FOREIGN KEY (blog_category_id) REFERENCES blog_category (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE8B7E4006 FOREIGN KEY (booker_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDED4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CD4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE listing ADD CONSTRAINT FK_CB0048D4455844B0 FOREIGN KEY (listing_category_id) REFERENCES listing_category (id)');
        $this->addSql('ALTER TABLE listing_image ADD CONSTRAINT FK_33D3DCD3D4619D1A FOREIGN KEY (listing_id) REFERENCES listing (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143CB76011C');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDED4619D1A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CD4619D1A');
        $this->addSql('ALTER TABLE listing_image DROP FOREIGN KEY FK_33D3DCD3D4619D1A');
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D4455844B0');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE blog DROP FOREIGN KEY FK_C0155143F675F31B');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE8B7E4006');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CF675F31B');
        $this->addSql('ALTER TABLE listing DROP FOREIGN KEY FK_CB0048D4F675F31B');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE blog');
        $this->addSql('DROP TABLE blog_category');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE front_page');
        $this->addSql('DROP TABLE guides');
        $this->addSql('DROP TABLE listing');
        $this->addSql('DROP TABLE listing_category');
        $this->addSql('DROP TABLE listing_image');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE user');
    }
}
