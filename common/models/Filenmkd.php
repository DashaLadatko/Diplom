<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "file_nmkd".
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
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property User $user
 * @property ComponentNmkd $componentNmkd
 * @property Discipline $discipline
 */
class Filenmkd extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file_nmkd';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['discipline_id', 'component_nmkd_id', 'name', 'user_id', 'signature'], 'required'],
            [['discipline_id', 'component_nmkd_id', 'user_id', 'protocol_chair', 'protocol_fuculty', 'protocol_university', 'total', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['signature'], 'string'],
            [['name', 'comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['component_nmkd_id'], 'exist', 'skipOnError' => true, 'targetClass' => ComponentNmkd::className(), 'targetAttribute' => ['component_nmkd_id' => 'id']],
            [['discipline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Discipline::className(), 'targetAttribute' => ['discipline_id' => 'id']],
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComponentNmkd()
    {
        return $this->hasOne(ComponentNmkd::className(), ['id' => 'component_nmkd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }
}
