<?php

class PhoneNumber extends Model
{
    protected $tableName = 'phone_numbers';

    public $id;
    public $messenger;
    public $phone;
    public $name;
    public $is_visible;
    public $last_activity;

    protected $fields = ['id', 'messenger', 'phone', 'name', 'is_visible', 'last_activity'];

    protected $rules = [
        [
            'field' => 'phone',
            'label' => 'Телефон',
            'rules' => 'required',
        ],
        [
            'field' => 'messenger',
            'label' => 'Мессенджер',
            'rules' => 'required',
        ],
    ];
}
