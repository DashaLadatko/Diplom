<?php

namespace common\models;

use common\components\traits\attachmentSoft;
use Yii;
use yii\db\ActiveRecord;
use common\components\extended\extActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "workshop".
 *
 * @property integer $id
 * @property integer $topic_id
 * @property string $name
 * @property string $description
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Mark[] $marks
 * @property Topic $topic
 */
class Workshop extends extActiveRecord
{
    use attachmentSoft;

    const type_practical = 'practical';
    const type_seminar = 'seminar';
    const type_laboratory = 'laboratory';
    const type_lecture = 'lecture';

    public $files;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'workshop';
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
            [['topic_id', 'name', 'description', 'type'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            [['topic_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['description', 'type'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'string', 'max' => 255],
            [['files'], 'file', 'maxFiles' => 10],
            [['topic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Topic::className(), 'targetAttribute' => ['topic_id' => 'id']],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        Attachment::upload($this);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'topic_id' => 'Тема',
            'name' => 'Назва',
            'description' => 'Опис',
            'type' => 'Тип',
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
    public function getMarks()
    {
        return $this->hasMany(Mark::className(), ['workshop_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTopic()
    {
        return $this->hasOne(Topic::className(), ['id' => 'topic_id']);
    }
}
