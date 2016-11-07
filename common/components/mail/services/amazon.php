<?php

namespace common\components\mail\services;

use Yii;
use yashop\ses\Mailer;

/**
 * Class amazon
 * @package common\components\amazon
 *
 * Add to composer.json dependence:
 *  "ofat/yii2-yashop-ses": "*",
 *
 * and add to main-local
 *
 * 'mailer' => [
 *   'class' => 'common\components\mail\mailer',
 *   'viewPath' => '@common/mail',
 *
 *   'access_key' => 'key',
 *   'secret_key' => 'key',
 *   'host' => 'email.us-west-2.amazonaws.com',
 *
 *   'quotaSecond' => 1,
 *   'quotaDay' => 200,
 * ],
 *
 */
class amazon extends Mailer
{
    /**
     * @param string $email
     * @return bool|array
     */
    public function verifyEmail($email)
    {
        return $this->getSES()->verifyEmailAddress($email);
    }

    /**
     * @param string $param
     * @return array
     */
    public function verifiedEmailsList($param = 'Addresses')
    {
        /**  @var array $array */
        $array = $this->getSES()->listVerifiedEmailAddresses();

        return array_key_exists($param, $array) ? $array[$param] : [];
    }

}
