<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyRating;
use Illuminate\Http\Request;
use App\Models\SurveyQuestion;

class SurveyController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'nama' => 'required|string',
            'nim' => 'required|string',
            'email' => 'required|email',
            'matakuliah_id' => 'required|exists:matakuliahs,id',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_dosen' => 'required|string',
            'ratings.*.rating' => 'required|integer|between:1,5',
        ]);

        // Simpan survei
        $survey = Survey::create($request->except('ratings'));

        // Simpan rating
        foreach ($request->ratings as $questionId => $ratingData) {
            SurveyRating::create([
                'survey_id' => $survey->id,
                'question_id' => $questionId,
                'rating' => $ratingData['rating'],
            ]);
        }

        return redirect()->back()->with('success', 'Survei berhasil dikirim!');
    }

    public function getChartData()
    {
        // Ambil semua survei, relasi dengan rating dan mata kuliah
        $surveys = Survey::with('ratings', 'matakuliah')->get();

        // Variabel untuk menyimpan label dan dataset
        $labels = [];
        $datasets = [
            'label' => 'Rata-rata Rating',
            'data' => [],
            'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1,
        ];

        // Kelompokkan survei berdasarkan mata kuliah dan dosen
        $groupedSurveys = $surveys->groupBy(function ($survey) {
            return $survey->matakuliah->nama_mk . ' - ' . $survey->nama_dosen; // Gabungkan mata kuliah dan dosen sebagai label
        });

        // Loop untuk setiap kelompok mata kuliah-dosen
        foreach ($groupedSurveys as $key => $surveyGroup) {
            // Tambahkan label (gabungan mata kuliah dan dosen)
            $labels[] = $key;

            // Hitung rata-rata rating dari survei yang ada pada kelompok ini
            $averageRating = $surveyGroup->flatMap->ratings->avg('rating');
            $datasets['data'][] = $averageRating;
        }

        // Return data dalam bentuk JSON
        return response()->json([
            'labels' => $labels,
            'datasets' => [$datasets],
        ]);
    }
}
