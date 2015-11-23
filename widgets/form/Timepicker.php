<?php
namespace uamext\widgets\form;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;

class Timepicker extends \yii\widgets\InputWidget
{
	public $data = null;
	public $options = [];
	public $clientOptions = array();
	public $type = 'text';
	
	public function init()
    {
        parent::init();
		$this->options['id'] = 'uam-timepicker-' . $this->attribute;
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
		TimepickerAsset::register($view);
		
		$content = Html::activeInput($this->type,$this->model, $this->attribute, $this->options);
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("jQuery('#$id').timepicker($clientOptions);");
		
        return $content;
    }

    
}
