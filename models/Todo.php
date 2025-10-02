<?php

namespace app\models;

use yii\db\ActiveRecord;

class Todo extends ActiveRecord
{
    public static function tableName()
    {
        return 'todo';
    }

    public function rules()
    {
        return [
            [['name', 'category_id'], 'required'],
            ['category_id', 'integer'],
            ['timestamp', 'safe'],
            ['name', 'string', 'max' => 255],
            ['name', 'trim'],
            ['category_id', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'timestamp' => 'Timestamp',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}