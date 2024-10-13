<?php

use App\Models\Kelas;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveiController;
use App\Http\Controllers\SurveyController;
use App\Filament\Resources\SurveyResource\Pages\SurveyChart;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', [HomeController::class, 'index']);
Route::get('/survei', [HomeController::class, 'survei']);
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/surveys/chart-data', [SurveyController::class, 'getChartData']);
Route::get('/kelas/{matakuliahId}', function ($matakuliahId) {
    return Kelas::where('matakuliah_id', $matakuliahId)->get();
});
