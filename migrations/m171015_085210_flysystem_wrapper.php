<?php

use yii\db\Migration;

/**
 * Class m171015_085210_filemanager
 * php yii migrate/up --migrationPath=@education/runtime/tmp-extensions/yii2-file-manager/migrations
 */
class m171015_085210_flysystem_wrapper extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%file}}', [
            'id' => $this->primaryKey(),
            'file_name' => $this->string(255)->notNull(),
            'path' => $this->string(255)->notNull()->unique(),
            'size' => $this->integer()->notNull(),
            'mime_type' => $this->string(25)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_user_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'updated_user_id' => $this->bigInteger(),
            'deleted_at' => $this->timestamp(),
            'deleted_user_id' => $this->bigInteger(),
        ], $tableOptions);

        $this->addForeignKey('6721_created_user_id_file_fkey', '{{%file}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('6721_updated_user_id_file_fkey', '{{%file}}', 'updated_user_id', '{{%user}}', 'id');
        $this->addForeignKey('6721_deleted_user_id_file_fkey', '{{%file}}', 'deleted_user_id', '{{%user}}', 'id');

        $this->createTable('{{%file_metadata}}', [
            'id' => $this->primaryKey(),
            'file_id' => $this->integer()->notNull(),
            'metadata' => $this->string(255)->notNull(),
            'value' => $this->string(255)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'created_user_id' => $this->bigInteger()->notNull(),
            'updated_at' => $this->timestamp(),
            'updated_user_id' => $this->bigInteger(),
            'deleted_at' => $this->timestamp(),
            'deleted_user_id' => $this->bigInteger(),
        ], $tableOptions);


        $this->addForeignKey('6721_created_user_id_file_metadata_fkey', '{{%file_metadata}}', 'created_user_id', '{{%user}}', 'id');
        $this->addForeignKey('6721_updated_user_id_file_metadata_fkey', '{{%file_metadata}}', 'updated_user_id', '{{%user}}', 'id');
        $this->addForeignKey('6721_deleted_user_id_file_metadata_fkey', '{{%file_metadata}}', 'deleted_user_id', '{{%user}}', 'id');

        $this->addForeignKey('fk_file_metadata', '{{%file_metadata}}', 'file_id', '{{%file}}', 'id');
    }

    public function safeDown()
    {
        $this->dropTable('{{%file_metadata}}');
        $this->dropTable('{{%file}}');
    }
}
