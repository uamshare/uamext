<?php
namespace uamext\widgets\form;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;

class Daterangepicker extends \yii\widgets\InputWidget
{
	public $data = null;
	public $options = [];
	public $clientOptions = array();
	public $type = 'text';
	
	public function init()
    {
        parent::init();
		$this->options['id'] = 'uam-daterangepicker-' . $this->attribute;
		$this->options['class'] = 'form-control';
		//if($this->data == null){
		//	throw new InvalidConfigException('The "data" property must be set.');
		//}
		
    }
	
    public function run()
    {
		$view = $this->getView();
		$id = $this->options['id'];
		
		//Register DtGridViewAsset
		DaterangepickerAsset::register($view);
		
		$content = Html::activeInput($this->type,$this->model, $this->attribute, $this->options);
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("jQuery('#$id').daterangepicker($clientOptions);");
		
        return $content;
    }

    
}
