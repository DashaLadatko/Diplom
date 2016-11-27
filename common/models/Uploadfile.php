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
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'docs, txt'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {//продумать создадить - папку с ай ди юзера
            $this->imageFile->saveAs('D:/OpenServer/domains/Diplom/uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}