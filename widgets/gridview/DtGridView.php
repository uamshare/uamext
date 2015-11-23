<?php
namespace uamext\widgets\gridview;

use Yii;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\JsExpression;

class DtGridView extends \yii\grid\GridView
{
	/*
	 * public property tableOptions
	 * Fungsi : Nilai untuk attribute Table
	 */
    public $tableOptions = ["class"=>"DtGridView display table table-striped table-bordered hover","cellspacing"=>"0", "width"=>"100%"];
	/*
	 * public property extensions
	 * Fungsi : Mengaktifkan extensions DataTable
	 * ['ResponsiveAsset','TableToolsAsset']
	 */
	public $extensions = ['ResponsiveAsset',''];
	/*
	 * public property tableOptions
	 * Fungsi : Nilai untuk property DataTable
	 */
	public $clientOptions = [];
	/*
	 * public property tplclientOptions
	 * Template untuk property DataTable
	 * 
	 * - 'CheckboxColumn' : [
	 * 						  	'data' => 'active',
	 * 							'render' => new JsExpression('function (data, type, row) {
	 *											if ( type === 'display' ) {
	 *												return '<input type="checkbox" class="editor-active">';
	 *											}
	 *											return data;
	 *										}'),
	 * 							'className' => 'dt-body-center'
	 * 						]
	 * - 'SerialColumn' : [
	 * 						  	'data' => 'rownumber',
	 * 							'orderable' => false,
	 *							'width' => '35px'
	 * 						]
	 * 
	 * 
	 */
	public $tplclientOptionsColumns = [];
	/*
	 * public property DefaultclientOptions
	 * Fungsi : Nilai Default untuk property DataTable 
	 */
	protected $DefaultclientOptions = [
		'lengthMenu' => [[20,30,50,75,100,-1], [20,30,50,75,100,'All']],
		'info' => false,
		'responsive' => true, 
		//'dom' => 'frtilp',
		'dom' => 'Bfrtilp',
		"order" => [[ 3, "asc" ]],
	];
	/*
	 * protected Property attrColumns
	 * Fungsi : digunakan sebagai penampung nilai julah kolom table
	 */
	protected $attrColumns ;
	/**
     * Overide parent::init().
     */
	public function init()
    {
		$this->tplclientOptionsColumns=[
			'CheckboxColumn' =>[
				'data' => 'active',
				'className' => 'dt-body-center',
				'render' => new JsExpression('function (data, type, row) {
					if ( type === "display" ) {
						return \'<input type="checkbox" value="\' + data + \'" class="editor-active">\';
					}
					return data;
				}'),
				'orderable' => false,
				'width' => '1px'
			],
			'SerialColumn' =>[
				'data' => 'rownumber',
				'className' => 'dt-body-center',
				'orderable' => false,
				'width' => '5px'
			],
		];
		$this->transformationColumns();
		if($this->dataProvider != null){
			parent::init();	
			$this->filterModel = null;
			$this->dataProvider->sort = false;
			$this->dataProvider->pagination = false;
		}else{
			//$this->initColumns();
		}
        
        $this->layout = "{items}";
        if (!isset($this->tableOptions['id'])) {
            $this->tableOptions['id'] = ($this->options['id']) ? $this->options['id'] : 'DtGridView-'.$this->getId();
        }
		$this->clientOptions = ArrayHelper::merge($this->DefaultclientOptions,$this->clientOptions);
    }
	
	/**
     * transformationColumns
     */
    protected function transformationColumns()
    {
		if($this->columns){
			$this->attrColumns = $this->columns;
			//Transformation Column Class GridView to DataTable
			if (!isset($this->clientOptions["columns"]) && isset($clientOptions["ajax"])){
				foreach($this->attrColumns as $key => $column){
					if(is_string($column)){
						$this->clientOptions["columns"][$key] = ['data' => $column];
					}else if(isset($column['class']) && $column['class'] == 'yii\grid\SerialColumn'){
						$this->clientOptions["columns"][$key] = 'SerialColumn';
					}else if(isset($column['class']) && $column['class'] == 'yii\grid\CheckboxColumn'){
						$this->clientOptions["columns"][$key] = 'CheckboxColumn';
					}
				}
			}
		}
		$opColumns = [];
		if(isset($this->clientOptions['columns'])){
			$this->clientOptions['columns'] = $this->renderQueryRegisterJswithTpl();
			foreach($this->clientOptions['columns'] as $k => $column){
				$this->attrColumns[$k] = $column['data'];
				switch($column['data']){
					case 'rownumber' :
						$opColumns[$k] = ['class' => 'yii\grid\SerialColumn','headerOptions' => ['width' => '50']];
						break;
					case 'active' :
						$opColumns[$k] = ['class' => 'yii\grid\CheckboxColumn','headerOptions' => ['width' => '50']];
						break;
					default :
						if(isset($column['header'])){
							$opColumns[$k] = [
								'value' => $column['data'],
								'header' => (isset($column['header'])) ? $column['header'] : null,
							];
						}else{
							$opColumns[$k] = $column['data'];
						}
						break;
				}	
			}
		}
		if(empty($this->columns)){
			$this->columns = $opColumns;
		}
		$this->renderDTButtons();
    }
	/**
     * Overide parent::run().
	 * Runs the widget.
     */
    public function run()
    {
        $view = $this->getView();
		//$this->tableOptions = ArrayHelper::merge($this->options,$this->tableOptions);
        
        DtGridViewAsset::register($view);
		// iCheckAsset::register($view);
		
		//Set Extensions
		foreach($this->extensions as $ext){
			if($ext){
				$class = "\uamext\widgets\gridview\\extensions\\$ext";
				$class::register($view);	
			}
		}
		$view->registerJs($this->renderQueryRegisterJs());

        if ($this->showOnEmpty || $this->dataProvider->getCount() > 0) {
            $content = preg_replace_callback("/{\\w+}/", function ($matches) {
                $content = $this->renderSection($matches[0]);
                return $content === false ? $matches[0] : $content;
            }, $this->layout);
        } else {
            $content = $this->renderEmpty();
        }
        $tag = ArrayHelper::remove($this->options, 'tag', 'div');
		
        return $content;
    }
	/**
     * Membuat script buttons DataTable.
     * @return string the rendering result.
     */
	public function renderDTButtons(){
		if(!isset($this->clientOptions['buttons'])) return null;
		\uamext\widgets\gridview\extensions\ButtonsAsset::register($this->getView());
		foreach($this->clientOptions['buttons'] as $index => $button){
			if(is_string($button)){
				continue;	
			}else{
				foreach($button as $key => $value){
					switch($key){
						case 'add' :
							$this->clientOptions['buttons'][$index] = [
								'text' => 'Add',
								'action' => new \yii\web\JsExpression('function(){
										location.href = "' . \yii\helpers\Url::to($value) .'";
								}'),
								'className' => 'buttons-add',
							];
							break;
						case 'edit' :
							$this->clientOptions['buttons'][$index] = [
								'text' => 'Edit',
								'action' => new \yii\web\JsExpression('function(){
									var id = $("input.editor-active:checked",_0Table).val();
									location.href = "' . \yii\helpers\Url::to($value) .'?id=" + id;
								}'),
								'className' => 'buttons-edit',
								'enabled' => false,
							];
							break;
						case 'remove' :
							$this->clientOptions['buttons'][$index] = [
								'text' => 'Remove',
								'action' => new \yii\web\JsExpression('function(){
									
									location.href = "' . \yii\helpers\Url::to($value) .'";
								}'),
								'className' => 'buttons-remove',
								'enabled' => false,
							];
							break;
					}		
				}
			}
		}
	}
	/**
     * Membuat script js DataTable.
     * @return string the rendering result.
     */
	protected function renderQueryRegisterJs()
	{
		$id = $this->tableOptions['id'];
		$clientOptions = $this->clientOptions;
		/*
		 * 
		 * 
		 * 
		if (isset($clientOptions["tableTools"]) ||(isset($clientOptions["dom"]) && preg_match("/T/", $clientOptions["dom"]))){
            $tableTools = DtGridViewExtAsset::register($this->getView());
            $clientOptions["tableTools"]["sSwfPath"] = $tableTools->baseUrl."/extensions/TableTools/swf/copy_csv_xls_pdf.swf";
        }
		*/
		if (isset($clientOptions["ajax"])){
			if(isset($clientOptions["ajax"]['url'])){
				$clientOptions["ajax"]['url'] = \yii\helpers\Url::to($clientOptions["ajax"]['url']);	
			}else{
				$clientOptions["ajax"] = \yii\helpers\Url::to($clientOptions["ajax"]);	
			}
		}
		$DataTableoptions = Json::encode($clientOptions);
		//$DataTableoptions = preg_replace("/columns/",'aoColumns',$DataTableoptions);
		$registerJs  = "var _0Table = jQuery('#$id').dataTable($DataTableoptions);\n";
        $registerJs .= "jQuery('div.dataTables_filter input').unbind('keyup search input');\n";
		$registerJs .= "jQuery('div.dataTables_filter input').bind('keypress', function(e) {
							if(e.which == 13) {
								_0Table.fnFilter(this.value);   
							}
						})\n;"; 
		$registerJs .= "_0Table.on('change', 'input.select-on-check-all', function () {
							$('input.editor-active',_0Table).prop('checked', $(this).prop('checked'));
							if( $('input.editor-active',_0Table).prop('checked')){
								$('input.editor-active',_0Table).closest('tr').addClass('selected');	
							}else{
								$('input.editor-active',_0Table).closest('tr').removeClass('selected');	
							}
							if(_0Table.DataTable().button && $('input.buttons-remove',_0Table).length){
								_0Table.DataTable().button( 2 ).enable( $(this).prop('checked') );
							}
							
						});\n;"; 
		$registerJs .= "_0Table.on('change', 'input.editor-active', function () {
							var selectedRows = $('input.editor-active:checked',_0Table);
							if(_0Table.DataTable().button){
								_0Table.DataTable().button( 1 ).enable( selectedRows.length === 1 );
								if($('input.buttons-remove',_0Table).length){
									_0Table.DataTable().button( 2 ).enable( selectedRows.length > 0 );								
								}
							}
							if( $(this).prop('checked')){
								$(this).closest('tr').addClass('selected');	
							}else{
								$(this).closest('tr').removeClass('selected');	
							}
							
						});\n"; 
		// $registerJs .= "$('input[type=checkbox]').iCheck({
		// checkboxClass: 'icheckbox_flat-blue',
		// radioClass: 'iradio_flat-blue'
		// });\n"; 
		
		return $registerJs;
	}
	protected function renderQueryRegisterJswithTpl()
	{
		foreach($this->tplclientOptionsColumns as $key => $tplvalue){
			//var_dump($key);
			$keytpl = array_search($key, $this->clientOptions['columns']);
			$this->clientOptions['columns'][$keytpl] = $tplvalue;
		}
		//var_dump($this->clientOptions);exit();
		return $this->clientOptions['columns'];
	}
	/**
     * Overide parent::run().
     */
    public function renderTableBody()
	{
		if($this->dataProvider != null){
			return parent::renderTableBody();	
		}
	}
	/**
     * Overide parent::run().
     */
	public function renderTableHeader()
	{
		if($this->dataProvider != null){
			return parent::renderTableHeader();	
		}else{
			$content = [];
			foreach($this->attrColumns as $column){
				if(is_string($column)){
					$content[] = Html::tag('th', $column, $this->headerRowOptions);
				}else if(isset($column['class']) && $column['class'] == 'yii\grid\SerialColumn'){
					$content[] = Html::tag('th', '#', $this->headerRowOptions);
				}
			}
			$content = Html::tag('tr', implode('', $content), $this->headerRowOptions);
			return "<thead>\n" . $content . "\n</thead>";
		}
	}
    
    
}
