<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%todo}}`.
 * Main todos table with foreign key to categories
 */
class m20241201_120100_create_todo_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%todo}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'category_id' => $this->integer()->notNull(),
            'timestamp' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        // Add foreign key constraint
        $this->addForeignKey(
            'fk-todo-category_id',
            '{{%todo}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-todo-category_id', '{{%todo}}');
        $this->dropTable('{{%todo}}');
    }
}

