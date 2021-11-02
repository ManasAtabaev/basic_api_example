<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client}}`.
 */
class m211031_100923_create_client_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client}}', [
            'id' => $this->primaryKey(),
            'firstName' => $this->string(32)->notNull(),
            'lastName' => $this->string(32)->notNull(),
            'email' => $this->string()->notNull()->unique(),
            'phoneNumber' => $this->string()->notNull(),

            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_by' => $this->integer()->defaultValue(1)->notNull(),
            'created_time' => ' timestamp with time zone not null default now()',
            'modified_by' => $this->integer(),
            'modified_time' => ' timestamp with time zone'
        ]);

        // creates index for column `firstName`
        $this->createIndex(
            'idx-client-firstName',
            'client',
            'firstName'
        );

        // creates index for column `lastName`
        $this->createIndex(
            'idx-client-lastName',
            'client',
            'lastName'
        );

        $this->createIndex(
           'idx-unique-client-firstName-lastName',
           'client',
           'firstName, lastName',
           true
       );

        // creates index for column `email`
        $this->createIndex(
            'idx-client-email',
            'client',
            'email'
        );

        // creates index for column `active`
        $this->createIndex(
            'idx-client-active',
            'client',
            'active'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client}}');
    }
}
