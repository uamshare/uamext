<?php
namespace uamext\widgets\form;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Json;
use yii\helpers\Html;

class Select extends \yii\widgets\InputWidget
{
	public $data = null;
	public $options = [];
	public $clientOptions = array();
	
	public function init()
    {
        parent::init();
		//$this->options['id'] = $this->getId() . $this->attribute;//'uam-select-' . $this->attribute;
		$this->options['class'] = 'form-control';
		if($this->data == null){
			throw new InvalidConfigException('The "data" property must be set.');
		}
		
    }
	
    public function run()
    {
		$view = $this->getView();
		$id = $this->options['id'];
		//Register DtGridViewAsset
		SelectAsset::register($view);
		if($this->model){	
			$content = Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
		}else{
			$content = Html::dropDownList($this->options['id'], $this->attribute, $this->data, $this->options);
			
		}
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("var uam_select".$this->getId()."=jQuery('#$id').select2($clientOptions);");
		
        return $content;
    }

    
}
