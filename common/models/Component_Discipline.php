<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "Component_Discipline".
 *
 * @property integer $id
 * @property integer $discipline_id
 * @property integer $component_nmkd_id
 */
class Component_Discipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Component_Discipline';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'component_nmkd_id'], 'required'],
            [['discipline_id', 'component_nmkd_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'discipline_id' => 'Discipline ID',
            'component_nmkd_id' => 'Component Nmkd ID',
        ];
    }
}
