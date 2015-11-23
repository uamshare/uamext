<?php
/**
 * @copyright Copyright (c) 2014 Serhiy Vinichuk
 * @license MIT
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 */

namespace uamext\widgets\gridview;


use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\i18n\Formatter;
use yii\helpers\ArrayHelper;

/**
 * Action for processing ajax requests from DataTables.
 * @see http://datatables.net/manual/server-side for more info
 * @package nullref\datatable
 */
class DataTableAction extends Action
{
    /**
     * @var ActiveQuery
     */
    public $query;

    /**
     * Applies ordering according to params from DataTable
     * Signature is following:
     * function ($query, $columns, $order)
     * @var  callable
     */
    public $applyOrder;

    /**
     * Applies filtering according to params from DataTable
     * Signature is following:
     * function ($query, $columns, $search)
     * @var callable
     */
    public $applyFilter;

	private $postdata;
	
    public function init()
    {
        if ($this->query === null) {
            throw new InvalidConfigException(get_class($this) . '::$query must be set.');
        }
		$this->postdata = Yii::$app->request->post();
    }

    public function run()
    {
        /** @var ActiveQuery $originalQuery */
        $originalQuery = $this->query;
        $filterQuery = clone $originalQuery;
		
		$draw = $this->postdata['draw'];
        $filterQuery->where = null;
        $search = $this->postdata['search'];
        $columns = $this->postdata['columns'];
        $order = $this->postdata['order'];
		
        $filterQuery = $this->applyFilter($filterQuery, $columns, $search);
        $filterQuery = $this->applyOrder($filterQuery, $columns, $order);
        if (!empty($originalQuery->where)) {
            $filterQuery->andWhere($originalQuery->where);
        }
        $actionQuery = clone $filterQuery;
        $filterQuery
            ->offset(Yii::$app->request->getQueryParam('start', $this->postdata['start']))
            ->limit(Yii::$app->request->getQueryParam('length', $this->postdata['length']));
			
        $dataProvider = new ActiveDataProvider(['query' => $filterQuery, 'pagination' => false]);
		
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
        try {
			$data = [];
			$row_number = 1;
			foreach($dataProvider->getModels() as $key => $value){
				$datavalue = $value;//->toArray();
				// $data[$key] = $value->toArray();
				foreach($columns as $column){
					if(in_array($column['data'],array('rownumber','active'))) continue;
					$data[$key][$column['data']] = $this->getValueColumn($column['data'],$value);//$datavalue->$column['data'];
				}
                $data[$key]['primarykey'] = $value->primarykey;
				$data[$key]['rownumber'] = $row_number;
				$data[$key]['active'] = $value->getPrimaryKey();
				$row_number++;	
			}
            $response = [
                'draw' => (int)$draw,
                'recordsTotal' => (int)$originalQuery->count(),
                'recordsFiltered' => $actionQuery->count(),
                'data' => $data,
            ];
        } catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
        return $response;
    }

	protected function getValueColumn($text,$model)
    {
        if (!preg_match('/^([^:]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new InvalidConfigException('The column must be specified in the format of "attribute", "attribute:format" or "attribute:format:label"');
        }
		//var_dump($matches);
		$attribute = $matches[1];
		$attribute = preg_replace('/->/', '.',$attribute);
		return ArrayHelper::getValue($model, $attribute);//$value;
    }
	
    /**
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $order
     * @return ActiveQuery
     */
    public function applyOrder(ActiveQuery $query, $columns, $order)
    {
        if ($this->applyOrder !== null) {
            return call_user_func($this->applyOrder, $query, $columns, $order);
        }
		$modelClass = $query->modelClass;
        $schema = $modelClass::getTableSchema()->columns;
        foreach ($order as $key => $item) {
            $sort = $item['dir'] == 'desc' ? SORT_DESC : SORT_ASC;
			if (array_key_exists($columns[$item['column']]['data'], $schema) !== false) {
				$attribute = $columns[$item['column']]['data'];
				$attribute = preg_replace('/->/', '.',$attribute);
				$attribute = explode(".",$attribute);
				$query->addOrderBy([$attribute[0] => $sort]);
			}
        }
        return $query;
    }

    /**
     * @param ActiveQuery $query
     * @param array $columns
     * @param array $search
     * @return ActiveQuery
     * @throws InvalidConfigException
     */
    public function applyFilter(ActiveQuery $query, $columns, $search)
    {
        if ($this->applyFilter !== null) {
            return call_user_func($this->applyFilter, $query, $columns, $search);
        }

        /** @var \yii\db\ActiveRecord $modelClass */
        $modelClass = $query->modelClass;
        $schema = $modelClass::getTableSchema()->columns;
        foreach ($columns as $column) {
            if ($column['searchable'] == 'true' && array_key_exists($column['data'], $schema) !== false) {
                $value = empty($search['value']) ? $column['search']['value'] : $search['value'];
                $query->orFilterWhere(['like', $column['data'], $value]);
            }
        }
        return $query;
    }
} 
