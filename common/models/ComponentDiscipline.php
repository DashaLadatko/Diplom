<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "component_discipline".
 *
 * @property integer $id
 * @property integer $discipline_id
 * @property integer $component_nmkd_id
 */
class ComponentDiscipline extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'component_discipline';
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
