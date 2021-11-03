<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%application}}`.
 */
class m211102_035154_create_application_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%application}}', [
            'id' => $this->primaryKey(),
            'clientId' => $this->integer()->notNull(),
            'term' => $this->integer()->notNull(),
            'amount' => ' numeric(10,2) not null',
            'currency' => $this->string()->notNull(),

            'active' => $this->boolean()->defaultValue(true)->notNull(),
            'created_by' => $this->integer()->defaultValue(1)->notNull(),
            'created_time' => ' timestamp with time zone not null default now()',
            'modified_by' => $this->integer(),
            'modified_time' => ' timestamp with time zone'
        ]);

        // creates index for column `clientId`
        $this->createIndex(
            'idx-application-clientId',
            'application',
            'clientId'
        );

        // add foreign key for table `client`
        $this->addForeignKey(
            'fk-application-clientId',
            'application',
            'clientId',
            'client',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%application}}');
    }
}
