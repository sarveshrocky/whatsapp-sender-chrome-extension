<?php

require __DIR__ . '/Controller.php';

/**
 * Class Messages
 * @property Message $message
 * @property PhoneNumber $phoneNumber
 */
class Messages extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('message', 'message');
        $this->load->model('phoneNumber');
    }

    public function create()
    {
        $model = $this->message;

        if ($this->input->post('submit')) {
            if ($model->load($this->input->post()) && $model->validate()) {
                $model->time = (new \DateTime($model->time_formatted))->getTimestamp();
                $model->phone = formatPhone($model->phone, 'WA', 'save');
                $model->phone_sender = empty($model->phone_sender)
                    ? null
                    : $model->phone_sender;
                $model->status = Message::STATUS_NEW;
                $result = $model->save();
                if ($result['status'] === 'success') {
                    redirect('messages/success');
                } else {
                    redirect('messages/error');
                }
            }
        }

        $this->load->view('messages/form', [
            'model' => $model,
            'phones' => $this->_getPhones(),
        ]);
    }

    public function update($id)
    {
        $model = $this->message->findByKey($id);

        if ($this->input->post('submit')) {
            if ($model->load($this->input->post()) && $model->validate()) {
                $model->time = (new \DateTime($model->time_formatted))->getTimestamp();
                $model->phone = formatPhone($model->phone, 'WA', 'save');
                $model->phone_sender = empty($model->phone_sender)
                    ? null
                    : $model->phone_sender;
                $result = $model->save();
                if ($result['status'] === 'success') {
                    $this->session->set_flashdata('success', 'Сообщение успешно добавлено');
                    redirect('messages/queue');
                } else {
                    $this->session->set_flashdata('danger', 'Сообщение не было добавлено');
                    redirect('messages/queue');
                }
            }
        }

        $this->load->view('messages/form', [
            'model' => $model,
            'phones' => $this->_getPhones(),
        ]);
    }

    public function cancel($id)
    {
        $model = $this->message->findByKey($id);
        if (!is_null($model)) {
            $model->status = Message::STATUS_CANCELED;
            $model->save();
            $this->session->set_flashdata('info', 'Сообщение успешно отменено');
            redirect('messages/queue');
        } else {
            show_404();
        }
    }

    public function queue()
    {
        $db = $this->message->find();
        $db->order_by('id', 'DESC');
        $queue = $db->get()->result();

        $this->load->view('header', ['title' => 'Очередь сообщений']);
        $this->load->view('messages/queue', ['queue' => $queue]);
        $this->load->view('footer');
    }

    public function success()
    {
        $this->load->view('messages/success');
    }

    public function fail()
    {
        $this->load->view('messages/fail');
    }

    private function _getPhones()
    {
        $phones = array_reduce(
            $this->phoneNumber->find()
                ->where('is_visible', 1)
                ->get()->result_array(),
            function ($v, $x) {
                $v[] = [
                    'value' => $x['phone'],
                    'text' => $x['name'] ?: formatPhone($x['phone'], 'WA', 'fetch'),
                ];
                return $v;
            }, []);
        return $phones;
//        return array_merge([[
//            'value' => '',
//            'text' => 'Без привязки',
//        ]], $phones);
    }
}
