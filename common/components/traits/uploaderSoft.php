<?php

namespace common\components\traits;

use Yii;
use common\models\Attachment;
use common\components\upload\File;
use common\components\upload\UploadFile;
use common\components\extended\extActiveRecord;

/**
 * Class uploaderSoft
 * @package common\components\traits
 */
trait uploaderSoft
{
    # Upload

    /**
     * @param array|string $path
     * @param extActiveRecord|string $obj
     * @param int $show
     * @return array
     */
    public static function uploadFromPath($path, $obj, $show = Attachment::SHOW_TRUE)
    {
        $models = [];
        $array = is_string($path) ? [$path] : $path;
        $type = is_object($obj) ? $obj::lastNameClass() : $obj;
        $attachments = UploadFile::loadFilesFromPath($array);

        if ($attachments && self::checkFolder($type)) {
            foreach ($attachments as $attachment) {

                $attachment->getFullPath($attachment->baseName);
                $models[] = self::saveAttachment([
                    'path' => $attachment->urlPath,
                    'name' => $attachment->baseName,
                    'ext' => $attachment->extension,
                    'obj_id' => $obj->id,
                    'obj_type' => $type,
                    'type' => $attachment->typeByExtension,
                    'real_name' => $attachment->baseName,
                    'thumbnail_path' => null, // TODO: fix -> $attachment->thumbnailPath
                    'show' => (int)$show
                ]);
            }
        }
        return $models;
    }

    /**
     * @param array $attributes
     * @param extActiveRecord|string $obj
     * @param int $show
     * @return bool
     */
    public static function uploadBase64($attributes, $obj, $show = Attachment::SHOW_TRUE)
    {
        $file = new File();
        $file->isBase64 = true;

        $type = is_object($obj) ? $obj::lastNameClass() : $obj;
        $base64 = Yii::$app->request->post($attributes);

        if ($base64 && self::checkFolder($type)) {

            $part = explode(',', $base64);
            $file->fileBase64 = base64_decode($part[1]);

            if (file_put_contents($file->fullPath, $file->fileBase64)) {

                return self::saveAttachment([
                    'path' => $file->urlPath,
                    'name' => $file->realName,
                    'ext' => $file->extension,
                    'obj_id' => $obj->id,
                    'obj_type' => $type,
                    'type' => $file->typeByExtension,
                    'real_name' => $file->realName,
                    'thumbnail_path' => $file->thumbnailPath,
                    'show' => (int)$show
                ], $file->fullPath, $file->isBase64);
            }
        }
        return false;
    }

    /**
     * @param extActiveRecord|string $obj
     * @param int $show
     * @return array
     */
    public static function upload($obj, $show = Attachment::SHOW_TRUE)
    {
        $models = [];
        $attachments = UploadFile::loadFiles();
        $type = is_object($obj) ? $obj::lastNameClass() : $obj;

        if ($attachments && self::checkFolder($type)) {
            foreach ($attachments as $attachment) {

                $path = $attachment->getFullPath();
                if ($attachment->saveAs($path)) {

                    $models[] = self::saveAttachment([
                        'path' => $attachment->urlPath,
                        'name' => $attachment->baseName,
                        'ext' => $attachment->extension,
                        'obj_id' => $obj->id,
                        'obj_type' => $type,
                        'type' => $attachment->typeByExtension,
                        'real_name' => $attachment->realName,
                        'thumbnail_path' => $attachment->thumbnailPath,
                        'show' => $show
                    ], $path);
                }
            }
            return $models;
        }
        return [];
    }

    #  Check Path

    /**
     * @param string $type
     * @return bool
     */
    private static function checkFolder($type)
    {
        return UploadFile::checkPaths(Yii::getAlias('@' . Yii::$app->uploader->module . '/web/' . $type), Yii::$app->uploader->typePath);
    }

    # Download

    /**
     * @param array $models
     * @param string|null $zip_name
     * @return bool
     */
    public static function downloadAll(array $models, $zip_name = null)
    {
        $zip = new \ZipArchive();
        $zip_name = $zip_name ?: uniqid(10, false) . '.zip';

        if ($zip->open($zip_name, \ZIPARCHIVE::CREATE)) {

            foreach ($models as $file) {
                if ($file instanceof Attachment && file_exists($file->filePath)) {
                    $zip->addFile($file->filePath, basename($file->baseName));
                }
            }

            $zip->close();

            if (file_exists($zip_name)) {
                header('Content-type: application/zip');
                header('Content-Disposition: attachment; filename="' . $zip_name . '"');
                readfile($zip_name);

                unlink($zip_name);

                return true;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function download()
    {
        if (file_exists($this->getFilePath())) {
            header('Content-Description: Reports');
            header('Last-Modified: ' . gmdate('D,d M YH:i:s') . 'GMT');
            header('Content-Disposition: attachment; filename=' . basename($this->getFilePath()));
            header('Expires: 0');
            header('Cache-Control: no-cache, must-revalidate');
            header('Pragma: no-cache');
            header('Content-Length: ' . filesize($this->getFilePath()));
            header('Content-Length: ' . filesize($this->getFilePath()));

            readfile($this->getFilePath());

            return true;
        }
        return false;
    }

    # Remove

    /**
     * @return bool
     */
    public function removeFile()
    {
        if (is_file($this->getFilePath()) && unlink($this->getFilePath())) {
            if (isset($this->thumbnail_path) && is_file($this->getFilePath(true))) {
                return unlink($this->getFilePath(true));
            }
        }
        return false;
    }

    # Icon

    /**
     * @param string $objType
     * @param string|null $type
     * @return string
     */
    public static function getDefaultIconUrl($objType, $type = null)
    {
        $defaultArray = Yii::$app->uploader->default_image;

        if (array_key_exists($objType, $defaultArray)) {

            if ($type && is_array($defaultArray[$objType])) {
                $path = $defaultArray[$objType][$type];
            } else {
                $path = $defaultArray[$objType];
            }

            return self::getBase() . $path;
        }

        return Yii::t('app', 'Default image is not installed!');
    }

    # Getter

    public static function getBase()
    {
        $folder = isset(Yii::$app->uploader->folder) ? '/' . Yii::$app->uploader->folder : '';
        return Yii::$app->urlManager->getHostInfo() . $folder . '/' . Yii::$app->uploader->module . '/web/';
    }

    public function getFilePath($thumbnailPath = false)
    {
        $path = $thumbnailPath ? $this->thumbnail_path : $this->path;
        return Yii::getAlias('@' . Yii::$app->uploader->module) . '/web/' . $this->obj_type . $path;
    }

    public function getUrl()
    {
        return self::getBase() . $this->obj_type . $this->path;
    }

    public function getUrlThumbnail()
    {
        return self::getBase() . $this->obj_type . $this->thumbnail_path;
    }

    public function getMiniature()
    {
        return $this->thumbnail_path ? $this->getUrlThumbnail() : self::getDefaultIconUrl($this->obj_type, $this->type);
    }

    public function getBaseName($length = 0)
    {
        $name = $this->name . '.' . $this->ext;

        if ($length && mb_strlen($name) >= $length) {
            return mb_substr(strip_tags($this->name), 0, $length, 'UTF-8') . '...';
        }
        return $name;
    }
}