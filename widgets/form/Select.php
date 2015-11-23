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
		$this->options['id'] = 'uam-select-' . $this->attribute;
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
		
		$content = Html::activeDropDownList($this->model, $this->attribute, $this->data, $this->options);
		$clientOptions = Json::encode($this->clientOptions);
		$view->registerJs("jQuery('#$id').select2($clientOptions);");
		
        return $content;
    }

    
}
