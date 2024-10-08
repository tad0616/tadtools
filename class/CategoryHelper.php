<?php

namespace XoopsModules\Tadtools;

use XoopsModules\Tadtools\Utility;

class CategoryHelper
{
    protected $table;
    protected $idField;
    protected $parentField;
    protected $nameField;

    public function __construct($table, $idField, $parentField, $nameField)
    {
        $this->table = $table;
        $this->idField = $idField;
        $this->parentField = $parentField;
        $this->nameField = $nameField;
    }

    // 取得完整的分類路徑
    public function getCategoryPath($cate_id, $includeSelf = true)
    {
        $arr = array(
            0 => array(
                $this->idField => '',
                // $this->nameField => "&#xf015;",
                $this->nameField => "<i class='fa fa-home'></i>",
                'sub' => $this->getSubCategories(0),
            ),
        );

        if (!empty($cate_id)) {
            $path = $this->getCategoryPathIds($cate_id);
            foreach ($path as $id) {
                if (!$includeSelf && $id == $cate_id) {
                    break;
                }
                $arr[$id] = $this->getCategory($id);
                $arr[$id]['sub'] = $this->getSubCategories($id);
                if ($id == $cate_id) {
                    break;
                }
            }
        }

        return $arr;
    }

    // 取得分類ID的路徑
    protected function getCategoryPathIds($cate_id)
    {
        global $xoopsDB;
        $path = array();
        $currentId = $cate_id;

        while ($currentId != 0) {
            $path[] = $currentId;
            $sql = "SELECT `{$this->parentField}` FROM `" . $xoopsDB->prefix($this->table) . "` WHERE `{$this->idField}` = ?";
            $result = Utility::query($sql, 'i', array($currentId));
            $row = $xoopsDB->fetchRow($result);
            $currentId = isset($row[0]) ? $row[0] : 0;
        }

        return array_reverse($path);
    }

    // 取得某個分類的子分類
    public function getSubCategories($cate_id = 0)
    {
        global $xoopsDB;
        $sql = "SELECT `{$this->idField}`, `{$this->nameField}` FROM `" . $xoopsDB->prefix($this->table) . "` WHERE `{$this->parentField}` = ?";
        $result = Utility::query($sql, 'i', array($cate_id));
        $categories = array();
        while ($row = $xoopsDB->fetchRow($result)) {
            $categories[$row[0]] = $row[1];
        }

        return $categories;
    }

    // 取得某個分類的完整資料
    public function getCategory($cate_id)
    {
        global $xoopsDB;
        $sql = "SELECT * FROM `" . $xoopsDB->prefix($this->table) . "` WHERE `{$this->idField}` = ?";
        $result = Utility::query($sql, 'i', array($cate_id));

        $data = $xoopsDB->fetchArray($result);
        $counter = $this->getCategoryCount();
        $data['count'] = isset($counter[$cate_id]) ? $counter[$cate_id] : 0;
        $data['sub_cate'] = $this->getSubCategories($cate_id);

        return $data;
    }

    //放在分類底下的數量
    function getCategoryCount()
    {
        global $xoopsDB;
        $all = [];
        $sql = 'SELECT `' . $this->idField . '`,count(*) FROM ' . $xoopsDB->prefix($this->table) . ' GROUP BY `' . $this->idField . '`';
        $result = Utility::query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        while (list($cate_id, $count) = $xoopsDB->fetchRow($result)) {
            $all[$cate_id] = (int) ($count);
        }

        return $all;
    }
}

// use XoopsModules\Tadtools\CategoryHelper;
// $categoryHelper = new CategoryHelper('tad_news_cate', 'ncsn', 'of_ncsn', 'nc_title');
// $arr = $categoryHelper->getCategoryPath($ncsn);
// $sub_cate = $categoryHelper->getSubCategories($ncsn);
// $cate = $categoryHelper->getCategory($ncsn);
// $count = $categoryHelper->getCategoryCount();
