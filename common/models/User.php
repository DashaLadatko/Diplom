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
 * * @property string $second_name
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
 * @property GroupUser $group
 * @property Message $senderMessage
 * @property Message $receiverMessage
 */
class User extends extUser
{
    use attachmentSoft;

    public $department_id;
    public $group_id;

    const FIELD_ROLE = 'role';

    const ROLE_ADMIN = 0;
    const ROLE_STAFF = 1;
    const ROLE_STUDENT = 2;
    const ROLE_ADMINNMKD = 3;
    const ROLE_CHIEF = 4;

    public static $roles = [
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_STAFF => 'Staff',
        self::ROLE_STUDENT => 'Student',
        self::ROLE_ADMINNMKD => 'Adminnmkd',
        self::ROLE_CHIEF => 'Chief',
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
            [['status', 'role', 'created_at', 'created_by', 'updated_at', 'updated_by', 'department_id','group_id'], 'integer'],
            [['last_name', 'first_name', 'second_name', 'password_hash', 'password_reset_token', 'email', 'password'], 'string', 'max' => 255],

//            [['password', 'new_password', 'confirm_new_password'], 'required', 'on' => 'change_password'],
//            [['password', 'new_password', 'confirm_password'], 'string', 'min'=>6, 'max'=>32],
//            [['password', 'confirm_password', 'new_password', 'faculty','group'],'safe'],

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
            'department_id' => 'Кафедра',
            'group_id' => 'Група',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }
    public function getGroup()
    {
        return $this->hasOne(GroupUser::className(), ['user_id' => 'id']);
    }

    public function getSenderMessage()
    {
        return $this->hasOne(Message::className(), ['to_user_id' => 'id']);
    }

    public function getReceiverMessage()
    {
        return $this->hasOne(Message::className(), ['from_user_id' => 'id']);
    }


    public function afterSave($insert, $changedAttributes)
    {
        if (Attachment::uploadBase64('imageFile', $this) && $model = $this->getAttachment()) {
            $model->delete();
        }

        if ($this->role == User::ROLE_STUDENT) {

            if ($m = GroupUser::find()->where(['user_id' => $this->id])->one()) {
                $m->delete();
            }

            (new GroupUser(['group_id' => (int) $this->group_id, 'user_id' => $this->id]))->save(false);
        }

        if ($this->isNewRecord) {
            $this->generateAuthKey();
            $this->generatePasswordResetToken();
            $this->setPassword($this->password);
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
        return $this->last_name . ' ' . $this->first_name . ' ' . $this->second_name;
    }

}
