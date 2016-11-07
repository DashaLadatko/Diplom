<?php

namespace common\models;

use common\components\mail\macros;
use Yii;
use yii\behaviors;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "queue".
 *
 * @property integer $quotaSecond
 * @property integer $quotaDay
 *
 * @property \yii\db\ActiveQuery $query
 * @property macros $macros
 *
 * @property integer $id
 * @property string $subject
 * @property string $from_name
 * @property string $from_email
 * @property string $to_email
 * @property string $content
 * @property integer $send_time
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Queue extends \yii\db\ActiveRecord
{
    // TODO: dirty version moved to the component.

    const STATUS_FAIL = 0;
    const STATUS_WAIT = 1;
    const STATUS_SENDING = 2;
    const STATUS_SEND = 3;

    public $quotaSecond = 1;
    public $quotaDay = 200;

    protected $query;
    protected $macros;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'queue';
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
            ['status', 'default', 'value' => self::STATUS_WAIT],

            [['subject', 'from_name', 'from_email', 'to_email', 'status'], 'required'],
            [['content'], 'string'],
            [['send_time', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['subject', 'from_name', 'from_email', 'to_email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'from_name' => 'From Name',
            'from_email' => 'From Email',
            'to_email' => 'To Email',
            'content' => 'Content',
            'send_time' => 'Send Time',
            'status' => 'Status',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * @return array|bool
     */
    public static function startSend()
    {
        return (new Queue())->setQuery(self::find()->where(['status' => self::STATUS_WAIT]))->sendQueue();
    }

    /**
     * @param ActiveQuery $query
     * @return $this
     */
    public function setQuery(ActiveQuery $query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get content from html template {value} for replace in content.
     *
     * @param array $data
     * @return string
     */
    public function replace(array $data)
    {
        // Protect from new initialization and load handlers
        if (!$this->macros) {
            $this->macros = new macros();

            // Register handler on AFTER_LOAD or BEFORE_REPLACE or AFTER_REPLACE...
            // An example of registration handler
            $this->macros->registerEvent(macros::AFTER_LOAD, function ($content) {
                // Doing something with content..
                return $content;
            });

            $this->macros->load($this->content); // load mail content
        }

        // Clear the old array of parameters
        $this->macros->clear();
        foreach ($data as $key => $value) {
            // Adding new parameters
            $this->macros->add($key, $value);
        }
        return $this->macros->replace();
    }


//    public function renderPhpFile($_file_, $_params_ = [])
//    {
//        ob_start();
//        ob_implicit_flush(false);
//        extract($_params_, EXTR_OVERWRITE);
//        require($_file_);
//
//        return ob_get_clean();
//    }

    /**
     * @return array|bool
     */
    public function sendQueue()
    {
        // Is cane send check limit on this day and check limit count sending
        if ($this->isLimitDepleted()) {

            $reportsCount = $this->query->count();
            $limit = ceil($reportsCount / $this->quotaSecond);

            for ($i = 0; $i < $limit; $i++) {

                /** @var Queue[] $queues */
                $queues = $this->query->offset($i * $this->quotaSecond)->limit($this->quotaSecond)->all();

                foreach ($queues as $queue) {
                    // TODO: Do dynamic loading of template or load html and get text content!!!
                    $bool = Yii::$app->mailer->compose(['html' => 'campaign-html', 'text' => 'campaign-text'], ['content' => $queue->content])
                        ->setFrom([$queue->from_name => $queue->from_email])
                        ->setSubject($queue->subject)
                        ->setTo($queue->to_email)
                        ->send();

                    $queue->status = $bool ? Queue::STATUS_SEND : Queue::STATUS_FAIL;
                    $queue->send_time = time();
                    $queue->save(false);
                }
                sleep(1);
            }

            $this->query = null;

            return true;
        }
        return ['error' => Yii::t('app', 'Sending limit is now over a letter will be sent tomorrow.')];
    }

    /**
     * @return bool
     */
    public function isLimitDepleted()
    {
        $sentTodayCount = Queue::find()->where(['status' => Queue::STATUS_SEND])
            ->where(['between', 'send_time', strtotime('midnight', time()), strtotime('+1 day', strtotime('midnight', time()))])
            ->count();

        $dayLimit = $sentTodayCount < $this->quotaDay;

        $canSentCount = ($this->query->count() + $sentTodayCount) < $this->quotaDay;

        return $dayLimit && $canSentCount;
    }
}
