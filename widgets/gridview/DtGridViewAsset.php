<?php
namespace uamext\widgets\gridview;
use yii\web\AssetBundle;

class DtGridViewAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables'; 
    public $css = [
        //"jquery.dataTables.min.css",
		"dataTables.bootstrap.css",
    ];
    public $js = [
        "jquery.dataTables.js",
		"dataTables.bootstrap.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapAsset',
		'yii\grid\GridViewAsset',
    ];
}