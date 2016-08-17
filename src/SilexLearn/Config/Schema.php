<?php
namespace SilexLearn\Config;

use Doctrine\DBAL\Schema\Schema as DoctrineSchema;

class Schema
{
    static public function get()
    {
        $schema = new DoctrineSchema();

        $post = $schema->createTable('post');
        $post->addColumn('id', 'integer', array('unsigned' => true, 'autoincrement' => true));
        $post->addColumn('title', 'string', array('length' => 32));
        $post->addColumn('body', 'text');
        $post->addColumn('create_at', 'datetime');
        $post->addColumn('update_at', 'datetime');
        $post->setPrimaryKey(array('id'));

        return $schema;
    }
}