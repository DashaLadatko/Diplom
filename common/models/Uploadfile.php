<?php
namespace common\models;

use yii\base\Model;
use yii\web\UploadedFile;

class Uploadfile extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false,
                'extensions' => 'doc, docx, xls, xlsx, odt, pdf, txt, pptx', 'checkExtensionByMimeType'=>false]
        ];
    }

    public function upload($user_id)
    {
        $path = '../../frontend/web/uploads/' .$user_id;
        if ($this->validate()) {//продумать создадить - папку с ай ди юзера
            if(!file_exists($path)) {
                mkdir($path, 0775, true);
            }
            $this->imageFile->saveAs($path .'/'. $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}