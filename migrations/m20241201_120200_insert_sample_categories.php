<?php

use yii\db\Migration;

/**
 * Inserts sample categories into the category table.
 * Adding some default categories for testing
 */
class m20241201_120200_insert_sample_categories extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%category}}', [
            'name' => 'Category A',
        ]);
        
        $this->insert('{{%category}}', [
            'name' => 'Category B',
        ]);
        
        $this->insert('{{%category}}', [
            'name' => 'Category C',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%category}}', ['name' => 'Category A']);
        $this->delete('{{%category}}', ['name' => 'Category B']);
        $this->delete('{{%category}}', ['name' => 'Category C']);
    }
}

