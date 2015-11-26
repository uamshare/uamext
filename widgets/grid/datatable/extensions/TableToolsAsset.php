<?php
namespace uamext\widgets\grid\datatable\extensions;
use yii\web\AssetBundle;

class TableToolsAsset extends AssetBundle 
{
    public $sourcePath = '@uamext/plugins/datatables'; 
    public $css = [
		"extensions/TableTools/css/dataTables.tableTools.min.css",
    ];
    public $js = [
        "extensions/TableTools/js/dataTables.tableTools.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'uamext\widgets\grid\datatable\DataTableAsset',
    ];
}