<?php $this->load->view('header', ['title' => 'Сообщение не было добавлено']); ?>

<div class="container-fluid">
    <div class="alert alert-danger">
        Сообщение не было добавлено
    </div>
    <div class="row">
        <div class="col-sm-12 but-marl">
            <span><a href="<?= base_url('messages/create') ?>">Написать еще сообщение</a></span>
            <span><a href="<?= base_url('messages/queue') ?>">Очередь сообщений</a></span>
        </div>
    </div>
</div>

<?php $this->load->view('footer'); ?>
