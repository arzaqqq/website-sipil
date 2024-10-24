<?php

use App\Models\User;
use App\Models\Kelas;
use App\Models\Survey;
use App\Models\Setting;
use App\Models\LinkOption;
use App\Models\Matakuliah;
use App\Models\SettingFoto;
use App\Models\SurveyRating;
use App\Models\HeaderLulusan;
use App\Models\ProfilLulusan;
use App\Models\SurveyQuestion;
use Illuminate\Support\Facades\Validator;

function get_section_data($key)
{
    $data = SettingFoto::where('nama', $key)->first();
    if (isset($data)) {
        return $data;
    }
}

function get_setting_value($key)
{
    $data = Setting::where('key', $key)->first();
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

function get_profile()
{
    return ProfilLulusan::limit(5)->get();
}

function get_header_value($key)
{
    $data = HeaderLulusan::where('key', $key)->first();
    if (isset($data)) {
        return $data->value;
    } else {
        return 'empty';
    }
}

function get_matakuliahs()
{
    return Matakuliah::all();
}

if (!function_exists('get_kelas_by_matakuliah')) {
    function get_kelas_by_matakuliah($matakuliahId)
    {
        return Kelas::where('matakuliah_id', $matakuliahId)->get();
    }
}

function get_dosens()
{
    return User::where('role', 'dosen')->get();
}

function store_survey($surveyData, $ratings)
{
    // Simpan data survei
    $survey = Survey::create($surveyData);

    // Simpan rating
    foreach ($ratings as $questionId => $ratingData) {
        SurveyRating::create([
            'survey_id' => $survey->id,
            'question_id' => $questionId,
            'rating' => $ratingData['rating'],
        ]);
    }

    return $survey; // Kembalikan objek survei yang baru dibuat
}

function get_questions($key)
{
    $data = SurveyQuestion::where('key', $key)->get();
    if ($data->isNotEmpty()) {
        return $data;
    } else {
        return collect();
    }
}



// function get_patner()
// {
//     $data = Setting::all();
//     return $data;
// }