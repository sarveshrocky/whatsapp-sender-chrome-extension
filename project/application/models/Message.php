<?php

class Message extends Model
{
    const STATUS_NEW = 'new';
    const STATUS_CANCELED = 'canceled';
    const STATUS_SENT = 'sent';
    const STATUS_PENDING = 'pending';
    const STATUS_REJECTED = 'rejected';

    protected $tableName = 'messages';
    protected $fields = [
        'id', 'messenger', 'phone', 'phone_sender',
        'media', 'text', 'status', 'reason', 'time', 'time_sent'
    ];

    public $id;
    public $messenger;
    public $phone;
    public $phone_sender;
    public $media;
    public $text;
    public $status;
    public $reason;
    public $time;
    public $time_formatted;
    public $time_sent;

    protected $rules = [
        [
            'field' => 'phone',
            'label' => 'Телефон',
            'rules' => 'required',
        ],
        [
            'field' => 'text',
            'label' => 'Текст сообщения',
            'rules' => 'required',
        ],
        [
            'field' => 'messenger',
            'label' => 'Мессенджер',
            'rules' => 'required',
        ],
        [
            'field' => 'time_formatted',
            'label' => 'Дата и время отправки',
            'rules' => 'required|regex_match[/^\d{2}\.\d{2}\.\d{4}\s\d{2}\:\d{2}$/]',
        ],
    ];

    public function findAll()
    {
        $result = [];
        $rows = $this->db->get($this->tableName)->result_array();
        foreach ($rows as $row) {
            $model = new Message();
            foreach ($row as $k => $v) {
                $model->{$k} = $v;
            }
            $result[] = $model;
        }

        return $result;
    }

    public function findByKey($id)
    {
        $result = null;
        $row = $this->db->get_where($this->tableName, [
            'id' => $id,
        ], 1)->result_array();
        if (count($row)) {
            $model = new Message();
            $model->load($row[0]);
            return $model;
        } else {
            return null;
        }
    }
}
