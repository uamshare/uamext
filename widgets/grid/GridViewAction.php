<?php namespace uamext\widgets\grid;
/**
 * @copyright Copyright (c) 2014 Serhiy Vinichuk
 * @license MIT
 * @author Serhiy Vinichuk <serhiyvinichuk@gmail.com>
 * @author UAM <uamshare@gmail.com>
 */

use Yii;
use yii\base\Action;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\i18n\Formatter;
use yii\helpers\ArrayHelper;

/**
 * Action for processing ajax requests from DataTables.
 * @see 
 * @package uamext\widgets\grid
 */
class GridViewAction extends Action
{
    /**
     * Attached Active Query
     * @var ActiveQuery
     * @access public
     */
    public $query;
   
    /**
     * Applies ordering according to params from DataTable
     * function ($query, $columns, $order, $modelClassname)
     * @var  callable
     * @access public
     */
    public $applyOrder;

    /**
     * Applies filtering according to params from DataTable
     * function ($query, $columns, $search, $modelClassname)
     * @var callable
     * @access public
     */
    public $applyFilter;

    /**
     * Regiter The Client Action
     * function ($query, $columns, $search, $modelClassname)
     * @var Actions Class
     * @access private
     */
    private $clientClassAction;
	
    /*
     * Initialize the Action Gridview
     */
    public function init()
    {
        if ($this->query === null) {
            throw new InvalidConfigException(get_class($this) . '::$query must be set.');
        }
        $this->clientClassAction = Yii::createObject([
            'class' => 'uamext\widgets\grid\datatable\DataTableAction',
            'query' => $this->query,
            'applyOrder' => $this->applyOrder,
            'applyFilter' => $this->applyFilter,
        ],[$this->id, $this]);
        $this->clientClassAction->init();
    }

    public function run(){
        return $this->clientClassAction->run();
    }
} 
