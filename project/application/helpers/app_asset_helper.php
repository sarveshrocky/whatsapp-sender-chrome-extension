<?php

function vendors($path)
{
    return base_url("public/vendors/{$path}");
}

function assets($path)
{
    return base_url("public/{$path}");
}
