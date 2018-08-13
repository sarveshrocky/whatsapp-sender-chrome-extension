<?php

/**
 * Class Model
 * @property CI_Loader $load
 * @property CI_Form_validation $form_validation
 * @property CI_DB_query_builder|CI_DB_pdo_mysql_driver $db
 * @property int $id;
 */
class Model extends CI_Model
{
    protected $rules = [];
    protected $fields = [];
    protected $tableName;

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function load(array $data = [])
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }

        return true;
    }

    public function validate()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules($this->rules);
        $this->form_validation->set_data($this->asArray());
        return !!$this->form_validation->run();
    }

    public function asArray()
    {
        return get_object_vars($this);
    }

    public function isNew()
    {
        return $this->id === null;
    }

    public function find()
    {
        $this->db->from($this->tableName);
        return $this->db;
    }

    public function save()
    {
        $set = [];
        foreach (get_object_vars($this) as $k => $v) {
            if (in_array($k, $this->fields)) {
                $set[$k] = $v;
            }
        }

        if ($this->isNew()) {
            $isSaved = $this->db->insert($this->tableName, $set);
        } else {
            $isSaved = $this->db->update($this->tableName, $set, [
                'id' => $this->id
            ]);
        }

        return [
            'status' => $isSaved ? 'success' : 'error',
            'insert_id' => $isSaved ? $this->db->insert_id() : null,
        ];
    }

    public function findByKey($id)
    {
        $result = null;
        $row = $this->db->get_where($this->tableName, [
            'id' => $id,
        ], 1)->result_array();
        if (count($row)) {
            $model = new static();
            $model->load($row[0]);
            return $model;
        } else {
            return null;
        }
    }
}
