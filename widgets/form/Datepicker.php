<?php
namespace uamext\widgets\form;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;

class Datepicker extends \yii\widgets\InputWidget
{
	public $data = null;
	public $options = [];
	public $clientOptions = [];
	public $type = 'text';


	private $defaultclientoptions = [
		'format' => 'dd-mm-yyyy',
	];
	
	public function init()
    {
        parent::init();
		$this->options['id'] = 'uam-datepicker-' . $this->attribute;
		$this->options['class'] = 'form-control';
		$this->clientOptions = \yii\helpers\ArrayHelper::merge($this->defaultclientoptions, $this->clientOptions);
		//if($this->data == null){
		//	throw new InvalidConfigException('The "data" property must be set.');
		//}
		
    }
	
    public function run()
    {
		$view = $this->getView();
		$id = $this->options['id'];
		
		//Register DtGridViewAsset
		DatepickerAsset::register($view);
		
		$content = Html::activeInput($this->type,$this->model, $this->attribute, $this->options);
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("jQuery('#$id').datepicker($clientOptions);");
		
        return $content;
    }

    
}
