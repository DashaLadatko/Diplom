<?php

namespace common\models;

use common\components\traits\attachmentSoft;
use Yii;
use yii\db\ActiveRecord;
use common\components\extended\extActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "mark".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $workshop_id
 * @property string $text
 * @property integer $evaluation
 * @property string $type
 * @property integer $status
 * @property integer $role
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Workshop $workshop
 * @property User $user
 */
class Mark extends extActiveRecord
{
    use attachmentSoft;

    const TYPE_ACCEPT = 0;
    const TYPE_NO_ACCEPT = 1;

    public $files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mark';
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at'
                ],
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by'
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['user_id', 'default', 'value' => Yii::$app->user->id],
            ['evaluation', 'default', 'value' => 0],
            ['type', 'default', 'value' => self::TYPE_NO_ACCEPT],


            [['files'], 'file', 'maxFiles' => 10],

            [['user_id', 'workshop_id', 'evaluation', 'type', 'status'], 'required'],
            [['user_id', 'workshop_id', 'evaluation', 'status', 'type', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['text'], 'string', 'max' => 255],
            [['workshop_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workshop::className(), 'targetAttribute' => ['workshop_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'workshop_id' => 'Workshop ID',
            'text' => 'Text',
            'evaluation' => 'Evaluation',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkshop()
    {
        return $this->hasOne(Workshop::className(), ['id' => 'workshop_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
