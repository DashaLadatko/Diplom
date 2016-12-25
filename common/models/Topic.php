<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\extended\extActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "topic".
 *
 * @property integer $id
 * @property string $name
 * @property integer $time_of_passage
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property TopicCourse[] $topicCourses
 * @property Workshop[] $workshops
 */
class Topic extends extActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'topic';
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
            [['time_of_passage'], 'filter', 'filter' => 'strtotime'],
            [['name', 'time_of_passage'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => 'ID',
            'name' => 'Назва',
            'time_of_passage' => 'Термін проходження',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopicCourses()
    {
        return $this->hasMany(TopicCourse::className(), ['topic_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkshops()
    {
        return $this->hasMany(Workshop::className(), ['topic_id' => 'id']);
    }
}
