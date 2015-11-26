<?php
namespace uamext\widgets\grid\datatable\extensions;
use yii\web\AssetBundle;

class ResponsiveAsset extends AssetBundle 
{
    public $sourcePath = '@uamext/plugins/datatables'; 
    public $css = [
		"extensions/Responsive/css/dataTables.responsive.css",
    ];
    public $js = [
        "extensions/Responsive/js/dataTables.responsive.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'uamext\widgets\grid\datatable\DataTableAsset',
    ];
}
