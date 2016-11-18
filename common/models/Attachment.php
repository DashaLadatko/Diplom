<?php

namespace common\models;

use common\components\traits\attachmentSoft;
use common\components\traits\uploaderSoft;
use Yii;

use yii\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use common\components\extended\extActiveRecord;

/**
 * This is the model class for table "attachment".
 *
 * @property integer $id
 * @property string $name
 * @property string $real_name
 * @property integer $obj_id
 * @property string $obj_type
 * @property string $type
 * @property string $path
 * @property string $ext
 * @property integer $show
 * @property string $thumbnail_path
 * @property string $baseName
 * @property string $zipName
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property string $base
 * @property string $url
 * @property string $defaultIconUrl
 *
 * @property string $miniature
 * @property string $urlThumbnailPath
 * @property string $filePath
 */
class Attachment extends extActiveRecord
{
    use uploaderSoft;

    const SHOW_TRUE = 1;
    const SHOW_FALSE = 0;

    public static function tableName()
    {
        return 'attachment';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated_at'
                ]
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by'
            ]
        ];
    }

    public function rules()
    {
        return [
            [['obj_id', 'obj_type', 'type'], 'required'],
            [['obj_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'show'], 'integer'],
            [['obj_type', 'type', 'thumbnail_path'], 'string'],
            [['name', 'real_name', 'path'], 'string', 'max' => 255],
            [['ext'], 'string', 'max' => 10],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'old_name' => 'Old Name',
            'obj_id' => 'Obj ID',
            'obj_type' => 'Obj Type',
            'type' => 'Type',
            'path' => 'Path',
            'ext' => 'Ext',
            'show' => 'Show',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    public static function saveAttachment(array $attributes)
    {
        $attachment = new self();
        $attachment->load($attributes);

        return $attachment->save() ? $attachment : false;
    }
}
