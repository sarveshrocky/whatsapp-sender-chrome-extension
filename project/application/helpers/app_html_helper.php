<?php

function alert()
{
    $app = &get_instance();

    $map = [
        [
            'key' => 'success',
            'value' => 'alert alert-success'
        ],
        [
            'key' => 'danger',
            'value' => 'alert alert-danger'
        ],
        [
            'key' => 'info',
            'value' => 'alert alert-info'
        ],
        [
            'key' => 'warning',
            'value' => 'alert alert-warning'
        ],
    ];

    foreach ($map as $item) {
        $flash = $app->session->flashdata($item['key']);
        if ($flash) {
            echo '<div class="' . $item['value'] . '">' . $flash . '</div>';
        }
    }
}

/**
 * @param string $phone
 * @param string $messenger "WA" or "TG"
 * @param string $op "save" or "fetch"
 * @return mixed
 */
function formatPhone($phone, $messenger, $op)
{
    if ($messenger === 'WA') {
        if ($op === 'save') {
            return str_replace('+', '', $phone);
        } else {
            return '+' . $phone;
        }
    }

    return $phone;
}
