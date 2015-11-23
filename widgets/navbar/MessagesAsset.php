<?php
namespace uamext\widgets\navbar;
use yii\web\AssetBundle;

class MessagesAsset extends AssetBundle 
{
    public $sourcePath = '@vuamext/widgets/navbar'; 
    public $css = [];
    public $js = [
        'nav-messages.js',
    ];
    public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
    ];
}