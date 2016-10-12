<?php

namespace app\models;

use yii\db\ActiveRecord;
use Yii;
use yii\helpers\ArrayHelper;

class Category extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%category}}";
    }

    public function attributeLabels()
    {
        return [
            'parentId' => '上级分类',
            'title' => '分类名称'
        ];
    }

    public function rules()
    {
        return [
            ['parentId', 'required', 'message' => '上级分类不能为空'],
            ['title', 'required', 'message' => '标题名称不能为空'],
            ['createtime', 'safe']
        ];
    }

    public function add($data)
    {
        $data['Category']['createtime'] = time();
        if ($this->load($data) && $this->save()) {
            return true;
        }
        return false;
    }

    public function getData()
    {
        $cates = self::find()->all();
        $cates = ArrayHelper::toArray($cates);
        return $cates;
    }

    public function getTree($cates, $pid = 0)
    {
        $tree = [];
        foreach($cates as $cate) {
            if ($cate['parentId'] == $pid) {
                $tree[] = $cate;
                $tree = array_merge($tree, $this->getTree($cates, $cate['cateId']));
            }
        }
        return $tree;
    }

    public function setPrefix($data, $p = "|-----")
    {
        $tree = [];
        $num = 1;
        $prefix = [0 => 1];
        while($val = current($data)) {
            $key = key($data);
            if ($key > 0) {
                if ($data[$key - 1]['parentId'] != $val['parentId']) {
                    $num ++;
                }
            }
            if (array_key_exists($val['parentId'], $prefix)) {
                $num = $prefix[$val['parentId']];
            }
            $val['title'] = str_repeat($p, $num).$val['title'];
            $prefix[$val['parentId']] = $num;
            $tree[] = $val;
            next($data);
        }
        return $tree;
    }

    public function getOptions()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        $tree = $this->setPrefix($tree);
        $options = ['添加顶级分类'];
        foreach($tree as $cate) {
            $options[$cate['cateId']] = $cate['title'];
        }
        return $options;
    }

    public function getTreeList()
    {
        $data = $this->getData();
        $tree = $this->getTree($data);
        return $tree = $this->setPrefix($tree);
    }

    public static function getMenu()
    {
        $top = self::find()->asArray()->all();
        $data = self::array_list($top);
        return $data;
    }

    /**
     * 获取一个三维数组
     * @param 		当前array pid
     * @return 		array
     */
    public static function array_list($arr,$pid=0){
        //保存最终数据的array
        $list = array();
        //遍历顶层目录
        foreach ($arr as $v) {
            //判断是否为顶层节点
            if($v['parentId'] == $pid){
                //保存数组
                $v['children'] = self::array_list($arr,$v['cateId']);
                $list[] = $v;
            }
        }
        return $list;
    }

}
