<?php
namespace uamext\widgets\form;
use yii\web\AssetBundle;

class SelectAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/select2'; 
    public $css = [
        "select2.min.css",
    ];
    public $js = [
        "select2.full.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
    ];	
}