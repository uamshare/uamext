<?php
namespace uamext\widgets\navbar;

use Yii;
use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class Messages extends Widget
{
	public $options = [
		//'id' => 'nav-message',
		'class' => 'dropdown messages-menu'
	];
	public $clientOptions = [];
	
	public function init()
    {
        parent::init();
		if (!isset($this->options['id'])) {
            $this->options['id'] = 'nav-message-'.$this->getId();
        }
    }
	
    public function run()
    {
		parent::run();
		$view = $this->getView();
		MessagesAsset::register($view);
		
		$options = $this->options;
		$tag = 'li';
		$content = '';
		$id = $this->options['id'];
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("jQuery('#$id').navmessages($clientOptions);");
		return Html::tag($tag, $content, $options);
    }
    
    
    
}
