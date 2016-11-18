<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "File_Nmkd".
 *
 * @property integer $id
 * @property integer $discipline_id
 * @property integer $component_nmkd_id
 * @property string $name
 * @property integer $user_id
 * @property string $signature
 * @property integer $protocol_chair
 * @property integer $protocol_fuculty
 * @property integer $protocol_university
 * @property string $comment
 * @property integer $total
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 */
class File_Nmkd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'File_Nmkd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'component_nmkd_id', 'name', 'user_id', 'signature'], 'required'],
            [['discipline_id', 'component_nmkd_id', 'user_id', 'protocol_chair', 'protocol_fuculty', 'protocol_university', 'total', 'created_by', 'updated_by'], 'integer'],
            [['signature'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'comment'], 'string', 'max' => 255],
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
            'name' => 'Name',
            'user_id' => 'User ID',
            'signature' => 'Signature',
            'protocol_chair' => 'Protocol Chair',
            'protocol_fuculty' => 'Protocol Fuculty',
            'protocol_university' => 'Protocol University',
            'comment' => 'Comment',
            'total' => 'Total',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
}
