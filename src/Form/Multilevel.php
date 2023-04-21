<?php
namespace Ake\Multilevel\Form;

use Dcat\Admin\Form\Field;

class Multilevel extends Field
{
    protected $view = 'ake.multilevel::index';

    #url数组
    public $arr = [];

    #改变时候的数组
    public $change = [];

    #是否必填
    public $required = false;

    public function __construct($column, $arguments = [])
    {
        if (count(array_unique($column)) != count($column)) throw new \Exception('Field duplication');
        if (count($column) < 1) throw new \Exception('Field must have at least one column');
        $this->setChange($column);
        parent::__construct($column,$arguments);
    }

    /**
     * @description:load 加载
     * @param array $urls url 数组
     * @param $is_admin 是否是admin链接
     * @return $this
     * @throws \Exception
     * @Author:AKE
     * @Date:2023/4/21 10:17
     */
    public function load(array $urls, $is_admin = 1)
    {
        $arr = [];
        $i = 0;
        #获取第一个url，后面如果有没链接，则默认使用第一个
        $tmp = array_get($urls, $i);
        #判断使用了load，但是没有填写链接，抛出异常
        if (!$tmp) throw new \Exception('load url failed');
        foreach ($this->column() as $column) {
            //最后一个不用请求
            if ($column == last($this->column())) continue;
            #获取url
            $url = array_get($urls, $i, $tmp);
            #赋值url，判断是否是后台链接，并生成链接
            $arr[$column] = $is_admin ? admin_url($url) : url($url);
            $i++;
        }

        $this->arr = $arr;
        return $this;
    }

    /**
     * set the input filed required.
     *
     * @param  bool  $isLabelAsterisked
     * @return $this
     */
    public function required($isLabelAsterisked = true)
    {
        parent::required($isLabelAsterisked);
        $this->required = $isLabelAsterisked;
        return $this;
    }

    public function defaultVariables()
    {
        return array_merge(parent::defaultVariables(),[
            'arr' => $this->arr,
            'change' => $this->change,
            'required' => $this->required
        ]);
    }


    /**
     * @description:设置change数组
     * @param $columns
     * @Author:AKE
     * @Date:2023/4/21 13:18
     */
    private function setChange($columns)
    {
        $change = [];
        foreach ($columns as $k => $column){
            if ($column == last($columns)) continue;
            #设置禁用字段
            $change['disable'][$column] = array_slice($columns,$k+2);
            #设置重置的字段
            $change['reset'][$column] = array_slice($columns, $k+1);
            #需要填充的字段
            $change['fill'][$column] = array_get($columns, $k+1);
        }
        $this->change = $change;
    }
}
