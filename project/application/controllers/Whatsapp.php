<?php

require_once __DIR__ . '/Controller.php';

/**
 * Class Whatsapp
 * @property PhoneNumber $phoneNumber
 */
class Whatsapp extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('phoneNumber');
    }

    public function index()
    {
        $db = $this->phoneNumber->find();
        $db->where('messenger', 'WhatsApp');
        $items = $db->get()->result();

        return $this->load->view('whatsapp/index', compact('items'));
    }

    /**
     * @return object|string
     * @deprecated
     */
    public function create()
    {
        $model = $this->phoneNumber;

        if ($this->input->post('submit')) {
            if ($model->load($this->input->post()) && $model->validate()) {
                $model->phone = formatPhone($model->phone, 'WA', 'save');
                $model->is_visible = true;
                $result = $model->save();
                if ($result['status'] === 'success') {
                    redirect('whatsapp');
                }
            }
        }

        return $this->load->view('whatsapp/create');
    }

    public function update()
    {
        /** @var PhoneNumber $model */
        $model = $this->phoneNumber->findByKey($this->input->post('id'));

        if ($this->input->post('submit') && $model) {
            $postData = $this->input->post();
            $postData['is_visible'] = $postData['is_visible'] === 'on' ? 1 : 0;
            if ($model->load($postData) && $model->validate()) {
                $result = $model->save();
                if ($result['status'] === 'success') {
                    $this->session->set_flashdata('success', 'Номер обновлён');
                } else {
                    $this->session->set_flashdata('error', 'Номер не обновлён');
                }
            }
        }

        redirect('whatsapp');
    }
}
