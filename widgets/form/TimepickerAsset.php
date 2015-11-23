<?php
namespace uamext\widgets\form;
use yii\web\AssetBundle;

class TimepickerAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/timepicker'; 
    public $css = [
		'bootstrap-timepicker.min.css',
	];
    public $js = [
		'bootstrap-timepicker.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
    ];	
}