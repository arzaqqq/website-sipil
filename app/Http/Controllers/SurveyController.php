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
        $datasets = [];

        // Ambil semua pertanyaan untuk digunakan sebagai label dataset
        $questions = SurveyQuestion::all();

        // Kelompokkan survei berdasarkan mata kuliah dan dosen
        $groupedSurveys = $surveys->groupBy(function ($survey) {
            return $survey->matakuliah->nama_mk . ' - ' . $survey->nama_dosen; // Gabungkan mata kuliah dan dosen sebagai label
        });

        // Loop untuk setiap kelompok mata kuliah-dosen
        foreach ($groupedSurveys as $key => $surveyGroup) {
            // Hitung total rating untuk setiap pertanyaan
            $averageRatings = [];

            // Loop untuk setiap survey dalam kelompok
            foreach ($surveyGroup as $survey) {
                foreach ($survey->ratings as $rating) {
                    $questionId = $rating->question_id;

                    // Inisialisasi total rating untuk pertanyaan ini
                    if (!isset($averageRatings[$questionId])) {
                        $averageRatings[$questionId] = [
                            'total' => 0,
                            'count' => 0,
                        ];
                    }

                    // Tambahkan rating ke total
                    $averageRatings[$questionId]['total'] += $rating->rating;
                    $averageRatings[$questionId]['count']++;
                }
            }

            // Hitung rata-rata dan persentase untuk setiap pertanyaan
            foreach ($averageRatings as $questionId => $data) {
                $average = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;
                $percentage = ($average / 5) * 100; // Menghitung persentase dari skala 1-5

                // Siapkan dataset untuk setiap pertanyaan
                if (!isset($datasets[$questionId])) {
                    $datasets[$questionId] = [
                        'label' => $questions->where('id', $questionId)->first()->label,
                        'data' => [],
                    ];
                }

                // Masukkan persentase ke dalam dataset
                $datasets[$questionId]['data'][] = $percentage;
            }
        }

        // Siapkan label untuk chart
        foreach ($groupedSurveys as $key => $_) {
            $labels[] = $key;
        }

        // Return data dalam bentuk JSON
        return response()->json([
            'labels' => $labels,
            'datasets' => array_values($datasets), // Mengubah associative array menjadi indexed array
        ]);
    }

    // public function showCharts()
    // {
    //     // Ambil semua pertanyaan yang ada di survei
    //     $questionIds = SurveyRating::distinct()->pluck('question_id')->toArray();

    //     // Inisialisasi array kosong untuk menyimpan data setiap pertanyaan
    //     $questionsData = [];

    //     // Loop melalui setiap question_id yang ada
    //     foreach ($questionIds as $questionId) {
    //         // Ambil data untuk setiap rating dari 1 hingga 5 berdasarkan question_id
    //         $questionsData[$questionId] = SurveyRating::where('question_id', $questionId)
    //             ->selectRaw('rating, COUNT(*) as count')
    //             ->groupBy('rating')
    //             ->pluck('count', 'rating')
    //             ->toArray();

    //         // Inisialisasi data dengan nol untuk rating 1 hingga 5 jika tidak ada
    //         for ($i = 1; $i <= 5; $i++) {
    //             $questionsData[$questionId][$i] = $questionsData[$questionId][$i] ?? 0;
    //         }
    //     }

    //     // Kirim data ke view
    //     return view('filament.resources.survey-resource.pages.survey-chart', compact('questionsData'));
    // }
}
