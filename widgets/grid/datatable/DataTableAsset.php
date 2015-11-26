<?php
namespace uamext\widgets\grid\datatable;
use yii\web\AssetBundle;

class DataTableAsset extends AssetBundle 
{
    public $sourcePath = '@uamext/plugins/datatables'; 
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