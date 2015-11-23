<?php
namespace uamext\widgets\gridview\extentions;
use yii\web\AssetBundle;

class TableToolsAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables'; 
    public $css = [
		"extensions/TableTools/css/dataTables.tableTools.min.css",
    ];
    public $js = [
        "extensions/TableTools/js/dataTables.tableTools.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'uamext\widgets\gridview\DtGridViewAsset',
    ];
}