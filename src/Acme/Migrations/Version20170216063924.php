<?php

namespace Acme\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170216063924 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE article (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COMMENT \'标题\', tags VARCHAR(1024) NOT NULL COMMENT \'标签\', content LONGTEXT NOT NULL COMMENT \'内容\', create_at DATETIME NOT NULL COMMENT \'创建时间\', update_at DATETIME NOT NULL COMMENT \'更新时间\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT UNSIGNED AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL COMMENT \'电子邮箱\', password VARCHAR(255) NOT NULL COMMENT \'密码\', create_at DATETIME NOT NULL COMMENT \'创建时间\', update_at DATETIME NOT NULL COMMENT \'更新时间\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goods (id INT UNSIGNED AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL COMMENT \'商品标题\', stock INT UNSIGNED NOT NULL COMMENT \'库存\', content LONGTEXT NOT NULL COMMENT \'商品详情\', create_at DATETIME NOT NULL COMMENT \'创建时间\', update_at DATETIME NOT NULL COMMENT \'更新时间\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE goods');
    }
}
