<?php
namespace uamext\widgets\form;
use yii\web\AssetBundle;

class DaterangepickerAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/daterangepicker'; 
    public $css = [
		'daterangepicker-bs3.css',
	];
    public $js = [
		'moment.min.js',
		'daterangepicker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
    ];	
}