<?php
namespace uamext\widgets\gridview;
use yii\web\AssetBundle;

class iCheckAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/iCheck'; 
    public $css = [
		"all.css",
		"flat/blue.css",
    ];
    public $js = [
		"icheck.min.js",
    ];
    public $depends = [
		'uamext\widgets\gridview\DtGridViewAsset',
    ];
}