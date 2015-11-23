<?php
namespace uamext\widgets\form;
use yii\web\AssetBundle;

class DatepickerAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datepicker'; 
    public $css = [
		'datepicker3.css',
	];
    public $js = [
		'bootstrap-datepicker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
    ];	
}