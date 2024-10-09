<?php

use App\Models\LinkOption;
use App\Models\setting;
use App\Models\SettingFoto;


function get_section_data($key)
{
    $data = SettingFoto::where('nama', $key)->first();
    if (isset($data)) {
        return $data;
    }
}

function get_setting_value($key)
{
    $data = setting::where('key', $key)->first();
    if (isset($data)) {
        return $data->value;
    } else {
        return 'empty';
    }
}

function get_link_value($key)
{
    $data = LinkOption::where('key', $key)->first();
    if (isset($data)) {
        return $data->value;
    } else {
        return 'empty';
    }
}


// function get_patner()
// {
//     $data = Setting::all();
//     return $data;
// }
