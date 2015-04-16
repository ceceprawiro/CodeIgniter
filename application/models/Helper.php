<?php defined('BASEPATH') or die();

class Helper extends CI_Model
{
    public function __construct() { parent::__construct(); }

    public function children($table, $parent = 0)
    {
        $children = $this->db->where('parent_id', $parent)->get($table)->result_array();
        foreach ($children as $key => $child) {
            $children[$key]['children'] = $this->children($table, $child['id']);
        }

        return $children;
    }
}
