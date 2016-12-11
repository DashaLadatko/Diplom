<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use common\models\Attachment;
use yii\web\UploadedFile;

class AttachmentController extends Controller
{
    public function actionCreate()
    {
        $model = new Attachment();
        if ($model->load(['Attachment' => Yii::$app->request->post()]) && $model->validate()) {
            return $model->uploadImage();
        }
        return false;
    }

    public function actionDelete()
    {
        /**
         * @var $model Attachment
         */
        $model = Attachment::findOne(\Yii::$app->request->post('key'));
        return $model ? $model->delete(false) : false;
    }

    public function actionDownload()
    {
        /**
         * @var $model Attachment
         */
        $model = Attachment::findOne(\Yii::$app->request->get('id'));

        return $model ? $model->download() : false;
    }

    public function actionDownloadAll()
    {
        $model = new Attachment();

        if ($model->load(['Attachment' => Yii::$app->request->get()]) && $model->validate()) {
            $type = $model->type;

            $model->type = $model->type !== Attachment::TYPE_ALL_ATTACHMENT ?: [Attachment::TYPE_DOCUMENT, Attachment::TYPE_UNKNOWN];

            $models = Attachment::findAll(['obj_id' => $model->obj_id, 'type' => $model->type, 'obj_type' => $model->obj_type]);

            return $models ? Attachment::downloadAll($models, $model->zipName, $type) : false;
        }
        return false;
    }

    public function actionView()
    {
        /**
         * @var $model Attachment
         */
        $model = Attachment::findOne(\Yii::$app->request->post('key'));

        if ($model && $model->type !== Attachment::TYPE_UNKNOWN && file_exists($model->filePath)) {

            return Json::encode([
                'open' => $model->type === Attachment::TYPE_IMAGE ? 1 : 0,
                'url' => $model->base . '/' . $model->obj_type . $model->path,
                'name' => $model->realFileName,
            ]);
        }
        return false;
    }


    public function actionPrint($id)
    {
        $model = Attachment::findOne($id);
        return $this->renderPartial('print', [
            'model' => $model,
        ]);
    }

}
