<?php
namespace uamext\widgets\gridview\extensions;
use yii\web\AssetBundle;

class ButtonsAsset extends AssetBundle 
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/datatables'; 
    public $css = [
		"extensions/Buttons/css/buttons.dataTables.min.css",
		"extensions/Buttons/css/buttons.bootstrap.min.css",
    ];
    public $js = [
        "extensions/Buttons/js/dataTables.buttons.js",
		"extensions/Buttons/js/buttons.flash.js",
		"extensions/Buttons/js/buttons.html5.js",
		"extensions/Buttons/js/jszip.min.js",
		"extensions/Buttons/js/pdfmake.js",
		"extensions/Buttons/js/vfs_fonts.js",
		"extensions/Buttons/js/buttons.print.js",
		
    ];
    public $depends = [
        'yii\web\JqueryAsset',
		'uamext\widgets\gridview\DtGridViewAsset',
    ];
}
