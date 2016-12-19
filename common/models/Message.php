<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\extended\extActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $to_user_id
 * @property integer $from_user_id
 * @property string $text
 * @property integer $read_or_not
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property User $fromUser
 * @property User $toUser
 */
class Message extends extActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
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
            [['to_user_id', 'from_user_id', 'text', 'read_or_not'], 'required'],
            [['to_user_id', 'from_user_id', 'read_or_not', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['text'], 'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['from_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['from_user_id' => 'id']],
            [['to_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['to_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'to_user_id' => 'Кому',
            'from_user_id' => 'Від кого',
            'text' => 'Повідомлення',
            'read_or_not' => 'Прочитано',
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
    public function getFromUser()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getToUser()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    public static function dialogButton($model)
    {
        $modelM = self::find()->where(['from_user_id' => $model->id, 'read_or_not' => 1])->all();
        foreach($modelM as $value){
            $value->read_or_not = 0;
            $value->save();
        }
    }

    public function MessageForChat($id = null){
        $query = self::find()
            ->where(['status' => self::STATUS_ACTIVE]);
        if($id){
            $query->andOnCondition('(from_user_id ='. $id.' AND to_user_id ='. Yii::$app->user->id.
                ') OR (from_user_id = ' . Yii::$app->user->id.' AND to_user_id = ' . $id .")");
        }else {
            $query->andWhere(['or',
                ['from_user_id' => Yii::$app->user->id],
                ['to_user_id' => Yii::$app->user->id]
            ]);
        }
          return $query->all();
    }
}

