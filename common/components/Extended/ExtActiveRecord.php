<?php

namespace common\components\extended;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

use common\components\traits\soft;
use common\components\traits\errors;
use common\components\traits\softDeletes;

/**
 * Class extActiveRecord
 * @package common\components\extended
 */
class extActiveRecord extends ActiveRecord
{
    use soft, softDeletes, errors;

    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 0;

    const FIELD_STATUS = 'status';
    const STATUS_ACTIVE_LABEL = 'активный';
    const STATUS_IN_ACTIVE_LABEL = 'архивный';

    /**
     * @param bool $isActive
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function getActive($isActive = true)
    {
        $query = self::find();

        if ($isActive) {
            $query = $query->where([self::FIELD_STATUS => self::STATUS_ACTIVE]);
        }

        return $query;
    }

    /**
     * @param integer $id
     * @param bool $isActive
     * @return array|null|ActiveRecord
     */
    public static function getById($id, $isActive = true)
    {
        $query = self::find()->where(['id' => $id]);

        if ($isActive) {
            $query = $query->andWhere([self::FIELD_STATUS => self::STATUS_ACTIVE]);
        }

        return $query->one();
    }
}

