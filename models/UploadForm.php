<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\Inflector;
use app\models\File;
use yii\imagine\Image;

class UploadForm extends Model
{
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    public function rules()
    {
        return [
            [['imageFiles'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg', 'maxFiles' => 5],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) { 
            foreach ($this->imageFiles as $file) {
                $fileBaseName = Inflector::transliterate(mb_strtolower($file->baseName));
                $filePath = \Yii::$app->basePath . '/web/uploads/' . $fileBaseName . '.' . $file->extension;
                while (file_exists($filePath)) {
                    $fileBaseName = 'image_' . md5(microtime() . rand(0, 1000));
                    $filePath = \Yii::$app->basePath . '/web/uploads/' . $fileBaseName . '.' . $file->extension;
                }
                $file->saveAs($filePath);
                Image::thumbnail(\Yii::getAlias('@webroot/uploads/' . $fileBaseName . '.' . $file->extension), 100, 100)
                    ->save(\Yii::$app->basePath . '/web/uploads/thumbs/' . $fileBaseName . '.' . $file->extension, ['quality' => 80]);
                $fileDB = new File();
                $fileDB->name = $fileBaseName . '.' . $file->extension;
                $fileDB->created_at = date('Y-m-d H:i:s');
                $fileDB->save();
            }
            return true;
        } else {
            return false;
        }
    }
}