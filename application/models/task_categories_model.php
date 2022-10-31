<?php

class task_categories_model extends CI_Model
{
    public function getTaskCategories($id = null)
    {
        if (is_null($id)) {
            return $this->db->get('task_categories')->result_array();
        } else {
            return $this->db->get_where('task_categories', ['id' => $id])->result_array();
        }
    }

    public function deleteTaskCategories($id)
    {
        $this->db->delete('task_categories', ['id' => $id]);
        return $this->db->affected_rows();
    }

    public function createTaskCategories($data)
    {
        $this->db->insert('task_categories', $data);
        return $this->db->affected_rows();
    }

    public function updateTaskCategories($data, $id)
    {
        $this->db->update('task_categories', $data, ['id' => $id]);
        return $this->db->affected_rows();
    }
}