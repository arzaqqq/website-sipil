<?php 


use App\Models\SettingFoto;


function get_section_data($key)
    {
        $data = SettingFoto::where('nama' , $key)->first();
        if(isset($data)){
            return $data;
        }
    }

// function get_patner()
// {
//     $data = Setting::all();
//     return $data;
// }

?>