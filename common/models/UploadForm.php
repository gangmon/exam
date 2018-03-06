<?php

namespace common\models;
//这个文件实际不需要
use yii\base\Model;
use yii\web\UploadedFile;

/**
* UploadForm is the model behind the upload form.
*/
class UploadForm extends Model
{
/**
* @var UploadedFile file attribute
*/
public $file;

/**
* @return array the validation rules.
*/
public function rules(){
return [
[['file'], 'file'],];
}
}