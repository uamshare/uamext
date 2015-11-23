<?php
namespace uamext\widgets\form;
use yii\web\AssetBundle;

class InputmaskAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/input-mask'; 
    public $css = [];
    public $js = [
        "jquery.inputmask.js",
		"jquery.inputmask.date.extensions.js",
		"jquery.inputmask.extensions.js",
		'jquery.inputmask.numeric.extensions.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
    ];	
}