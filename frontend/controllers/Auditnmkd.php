<?php
/**
 * Created by PhpStorm.
 * User: timka
 * Date: 19.12.2016
 * Time: 19:49
 */

namespace frontend\controllers;
use yii\web\Controller;
use common\models\User;

class AuditnmkdController extends Controller
{
    public function actionIndex() {
        echo "cron service runnning";
    }

    public function actionMail() {
        $rows =  Yii::$app->db->createCommand('SELECT user_id, file_nmkd.name FROM `file_nmkd` '
            .'WHERE DATEDIFF(NOW(),FROM_UNIXTIME( created_at))>365 AND total=1 limit 1') // 365! create -> update
        ->queryAll();
        foreach ($rows as $row) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(User::findOne($row['user_id'])->email)
                ->setTextBody(' Шановний(а) ' . User::findOne($row['user_id'])->getFullName()
                    . '. Файл' . $row['name'] . ' не було оновлено на протязі року. Зверніть увагу. Адміністратор.')
                ->setSubject('Оновлення файлу')
                ->send();
        }
        $sends =  Yii::$app->db->createCommand('SELECT user_id FROM `file_nmkd` '
            .'WHERE signature=\'не завантажено\' AND DATEDIFF(NOW(),FROM_UNIXTIME( created_at))>10 ')->queryAll();
        foreach ($sends as $row) {
            Yii::$app->mailer->compose()
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setTo(User::findOne($row['user_id'])->email)
                ->setTextBody(' Шановний(а) ' . User::findOne($row['user_id'])->getFullName()
                    . '. Ви не завантажили файл НМКД. Минуло 10 днів. Зверніть увагу. Адміністратор.')
                ->setSubject('Завантажити файл')
                ->send();
        }
    }
}