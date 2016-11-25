<?php
namespace common\models;

use common\components\traits\attachmentSoft;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

use common\components\extended\extUser;
use common\models\Attachment;

/**
 * User model
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 *
 * @property Attachment $image
 */
class User extends extUser
{
    use attachmentSoft;

    const FIELD_ROLE = 'role';

    public static $roles = [
        0 => 'Адмін',
        1 => 'Викладач',
        2 => 'Студент',
    ];

    public $password;

    public static function tableName()
    {
        return 'user';
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

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_IN_ACTIVE]],

            [['email'], 'required'],
            [['email', 'password_reset_token'], 'unique'],

            ['password', 'string', 'min' => 6],
            [['auth_key'], 'string', 'max' => 32],
            [['status', 'role', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['last_name', 'first_name','second_name', 'password_hash', 'password_reset_token', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'first_name' => 'Ім\'я',
            'last_name' => 'Прізвище',
            'second_name' => 'По-батькові',
            'auth_key' => 'Пароль',
            'password_hash' => 'Пароль',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Статус',
            'role' => 'Роль',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        if (Attachment::uploadBase64('imageFile', $this) && $model = $this->getAttachment()) {
            $model->delete();
        }

        parent::afterSave($insert, $changedAttributes);
    }


    public static function auth(IdentityInterface $user)
    {
        return ArrayHelper::toArray($user, ['common\models\User' => [
            'email',
            'status',
            'role'
        ]]);
    }

    # Help

    /**
     * @param array $arrayRoles
     * @return bool
     */
    public static function isRole(array $arrayRoles)
    {
        return in_array(self::$roles[Yii::$app->user->identity->role], $arrayRoles, false);
    }

    /**
     * @param null $role
     * @return mixed
     */
    public static function roleName($role = null)
    {
        return self::$roles[isset($role) ? $role : Yii::$app->user->identity->role];
    }

    /**
     * @return array
     */
    public static function allRole()
    {
        return self::$roles;
    }

    # Getter

    public function getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
