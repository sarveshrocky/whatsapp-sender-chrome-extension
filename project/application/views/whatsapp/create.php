<?php $this->load->view('header', ['title' => 'Добавление номера WhatsApp']); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h3>Добавление номера WhatsApp</h3>

            <div>
                <div class="pull-left">
                    <a href="<?= base_url('whatsapp') ?>">Спискок номеров WhatsApp</a>
                </div>
                <div class="pull-right">
                    <a href="<?= base_url('messages/create') ?>">На главную</a>
                </div>
                <div class="clearfix"></div>
            </div>

            <?= form_open(current_url(), [
                'method' => 'post',
            ]) ?>
            <input type="hidden" name="messenger" value="Whatsapp">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group <?= form_error('phone') ? 'has-error' : '' ?>">
                        <label for="phone">Телефон:</label>
                        <input type="text" class="form-control" id="phone" name="phone"
                               placeholder="+00000000000"
                               value="<?= set_value('phone') ?>"/>
                        <?= form_error('phone') ?>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="submit" name="submit"
                           class="btn btn-success"
                           value="Добавить">
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>

<script>
jQuery(function ($) {
  var $phone = $("#phone")
  $phone.mask("+999999999?999");
  $phone.on("blur", function () {
    var last = $(this).val().substr($(this).val().indexOf("-") + 1);

    if (last.length === 3) {
      var move = $(this).val().substr($(this).val().indexOf("-") - 1, 1);
      var lastfour = move + last;

      var first = $(this).val().substr(0, 9);

      $(this).val(first + '-' + lastfour);
    }
  })
})
</script>

<?php $this->load->view('footer'); ?>


