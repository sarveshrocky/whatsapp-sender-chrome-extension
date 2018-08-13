<?php

require_once __DIR__ . '/../Controller.php';

/**
 * Class MessagesApi
 * @property Message $message
 * @property PhoneNumber $phoneNumber
 */
class MessagesApi extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('message');
        $this->load->model('phoneNumber');
        $this->output->set_content_type('application/json');
    }

    public function index()
    {
        $phone = $this->input->get('last_wid');

        /** @var Message[] $items */
        $db = $this->message->find();
        $db->where_in('status', [Message::STATUS_NEW, Message::STATUS_PENDING]);
        $db->where('time <', time());
        $db->where('phone_sender', $phone);
//        $db->or_where('phone_sender', null);
        $db->limit(5);
        $items = $db->get()->result_array();

        foreach ($items as $item) {
            $model = new Message();
            $model->load($item);
            $model->status = Message::STATUS_PENDING;
            $model->save();
        }

        if ($phone) {
            $model = new PhoneNumber();
            $db = $this->phoneNumber->find();
            $db->where('phone', $phone);
            $db->limit(1);
            $phoneRows = $db->get()->result_array();
            if (count($phoneRows)) {
                $model->load($phoneRows[0]);
                $model->last_activity = time();
                $model->save();
            } else {
                $model->messenger = 'WhatsApp';
                $model->phone = $phone;
                $model->last_activity = time();
                $model->save();
            }
        }

        foreach ($items as $i => $item) {
            $items[$i]['text'] = str_replace('%', '%25', $item['text']);
        }

        $this->output->set_output(json_encode([
            'status' => 'ok',
            'payload' => $items,
        ]));
    }

    public function confirm()
    {
        $id = $this->input->post('id');
        $model = $this->message->findByKey($id);
        if (!is_null($model)) {
            $model->status = Message::STATUS_SENT;
            $model->time_sent = time();
            $this->output->set_output(json_encode($model->save()));
            return;
        }
        $this->output->set_status_header(404);
        $this->output->set_output(json_encode([
            'status' => 'error',
            'error' => 'Not found',
        ]));
    }

    public function reject()
    {
        $id = $this->input->post('id');
        $model = $this->message->findByKey($id);
        if (!is_null($model)) {
            $model->status = Message::STATUS_REJECTED;
            $model->reason = $this->input->post('reason');
            $model->time_sent = time();
            $this->output->set_output(json_encode($model->save()));
            return;
        }
        $this->output->set_status_header(404);
        $this->output->set_output(json_encode([
            'status' => 'error',
            'error' => 'Not found',
        ]));
    }
}
