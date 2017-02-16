<?php
namespace Acme\Provider;

use Doctrine\DBAL\Migrations\Provider\SchemaProviderInterface;
use Doctrine\DBAL\Schema\Schema;

class CustomSchemaProvider implements SchemaProviderInterface
{
    /**
     * Create the schema to which the database should be migrated.
     *
     * @return  \Doctrine\DBAL\Schema\Schema
     */
    public function createSchema()
    {
        $schema = new Schema();
        $this->createArticleTable($schema);
        $this->createUserTable($schema);
        $this->createGoodsTable($schema);
        return $schema;
    }

    private function createUserTable(Schema $schema)
    {
        $table = $schema->createTable('user');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
        $table->addColumn('email', 'string', array('length' => 255, 'comment' => '电子邮箱'));
        $table->addColumn('password', 'string', array('length' => 255, 'comment' => '密码'));
        $table->addColumn('create_at', 'datetime', array('comment' => '创建时间'));
        $table->addColumn('update_at', 'datetime', array('comment' => '更新时间'));
        $table->setPrimaryKey(array('id'));
    }

    private function createArticleTable(Schema $schema)
    {
        $table = $schema->createTable('article');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
        $table->addColumn('title', 'string', array('length' => 255, 'comment' => '标题'));
        $table->addColumn('tags', 'string', array('length' => 1024, 'comment' => '标签'));
        $table->addColumn('content', 'text', array('comment' => '内容'));
        $table->addColumn('create_at', 'datetime', array('comment' => '创建时间'));
        $table->addColumn('update_at', 'datetime', array('comment' => '更新时间'));
        $table->setPrimaryKey(array('id'));
    }

    private function createGoodsTable(Schema $schema)
    {
        $table = $schema->createTable('goods');
        $table->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
        $table->addColumn('title', 'string', array('length' => 255, 'comment' => '商品标题'));
        $table->addColumn('stock', 'integer', array('unsigned' => true, 'comment' => '库存'));
        $table->addColumn('content', 'text', array('comment' => '商品详情'));
        $table->addColumn('create_at', 'datetime', array('comment' => '创建时间'));
        $table->addColumn('update_at', 'datetime', array('comment' => '更新时间'));
        $table->setPrimaryKey(array('id'));
    }

}