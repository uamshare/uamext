<?php
namespace uamext\widgets\gridview\extensions;
use yii\web\AssetBundle;

class ResponsiveAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables'; 
    public $css = [
		"extensions/Responsive/css/dataTables.responsive.css",
    ];
    public $js = [
        "extensions/Responsive/js/dataTables.responsive.min.js",
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'uamext\widgets\gridview\DtGridViewAsset',
    ];
}
