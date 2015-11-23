<?php
namespace uamext\widgets\form;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;

class Inputmask extends \yii\widgets\InputWidget
{
	public $data = null;
	public $options = [];
	public $alias = "";
	public $clientOptions = array();
	public $type = 'text';
	
	public function init()
    {
        parent::init();
		$this->options['id'] = 'uam-inputmask-' . $this->attribute;
		$this->options['class'] = 'form-control';
		//if($this->data == null){
		//	throw new InvalidConfigException('The "data" property must be set.');
		//}
		
    }
	
    public function run()
    {
		//var_dump($this->attribute);exit();
		$view = $this->getView();
		$id = $this->options['id'];
		//Register DtGridViewAsset
		InputmaskAsset::register($view);
		
		$content = Html::activeInput($this->type,$this->model, $this->attribute, $this->options);
		$clientOptions = Json::encode($this->clientOptions);
		$alias = Json::encode($this->alias);
		$view->registerJs("jQuery('#$id').inputmask($alias,$clientOptions);");
		
        return $content;
    }

    
}
