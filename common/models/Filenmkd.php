<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use common\components\extended\extActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

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
    public function rules()
    {
        return [
            [['discipline_id', 'component_nmkd_id', 'user_id', 'signature'], 'required'],
            [['discipline_id', 'component_nmkd_id', 'user_id', 'protocol_chair', 'protocol_fuculty', 'protocol_university', 'total', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['signature'], 'string'],
            [['name', 'comment'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['component_nmkd_id'], 'exist', 'skipOnError' => true, 'targetClass' => Componentnmkd::className(), 'targetAttribute' => ['component_nmkd_id' => 'id']],
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
            'component_nmkd_id' => 'Компонент НМКД',
            'name' => 'Назва файлу',
            'user_id' => 'User ID',
            'signature' => 'Статус',
            'protocol_chair' => 'Протокол кафедри',
            'protocol_fuculty' => 'Протокол факультету',
            'protocol_university' => 'Протокол університету',
            'comment' => 'Коментар',
            'total' => 'Остаточно затверджено',
            'created_at' => 'Дата створення',
            'updated_at' => 'Дата редагування',
            'created_by' => 'Створено',
            'updated_by' => 'Відредаговано',
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
    public function getComponentnmkd()
    {
        return $this->hasOne(Componentnmkd::className(), ['id' => 'component_nmkd_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDiscipline()
    {
        return $this->hasOne(Discipline::className(), ['id' => 'discipline_id']);
    }

    public function getDisciplineName()
    {
        return $this->discipline->name;
    }
    public function getFullName()
    {
        return $this->user->fullname;
    }
    public function getComponentnmkdName()
    {
        return $this->componentnmkd->name;
    }
}
