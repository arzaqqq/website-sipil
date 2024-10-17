<?php

namespace App\Filament\Resources\HasilResource\Pages;

use App\Models\Hasil;
use App\Models\Kelas;
use App\Models\Persen;
use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use App\Filament\Resources\HasilResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHasil extends CreateRecord
{
    protected static string $resource = HasilResource::class;

    protected static string $view = 'filament.resources.hasilcostum';

    public function form(Form $form): Form
    {
        return $form->schema([
            Card::make([
                Grid::make(3)->schema([
                    Select::make('matakuliah_id')
                        ->label('Mata Kuliah')
                        ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $set('kelas_id', null);
                            $set('nama_dosen', null);
                            $set('persen_absen', null);
                            $set('persen_latihan', null);
                            $set('persen_UTS', null);
                            $set('persen_UAS', null);
                        }),

                    Select::make('kelas_id')
                        ->label('Kelas')
                        ->options(function ($get) {
                            $matakuliahId = $get('matakuliah_id');
                            return $matakuliahId ? Kelas::where('matakuliah_id', $matakuliahId)->pluck('nama_kelas', 'id') : [];
                        })
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get, $state) {
                            $persen = Persen::where('matakuliah_id', $get('matakuliah_id'))
                                ->where('kelas_id', $state)
                                ->first();

                            if ($persen) {
                                $set('persen_absen', $persen->persen_absen);
                                $set('persen_latihan', $persen->persen_latihan);
                                $set('persen_UTS', $persen->persen_UTS);
                                $set('persen_UAS', $persen->persen_UAS);
                                $set('nama_dosen', $persen->nama_dosen);
                            } else {
                                $set('persen_absen', null);
                                $set('persen_latihan', null);
                                $set('persen_UTS', null);
                                $set('persen_UAS', null);
                                $set('nama_dosen', null);
                            }
                        }),

                    TextInput::make('nama_dosen')
                        ->label('Nama Dosen')
                        ->disabled(),
                ]),

                Grid::make(4)->schema([
                    TextInput::make('persen_absen')
                        ->label('Persen Absen')
                        ->disabled(),
                    TextInput::make('persen_latihan')
                        ->label('Persen Latihan')
                        ->disabled(),
                    TextInput::make('persen_UTS')
                        ->label('Persen UTS')
                        ->disabled(),
                    TextInput::make('persen_UAS')
                        ->label('Persen UAS')
                        ->disabled(),
                ]),
            ]),

            // Repeater untuk data mahasiswa dan nilai
            Card::make()->schema([
                Repeater::make('mahasiswa_nilai')
                    ->label('Daftar Mahasiswa dan Nilai')
                    ->schema([
                        Grid::make(8)->schema([
                            TextInput::make('nama_mahasiswa')
                                ->label('Mahasiswa')
                                ->required(),

                            TextInput::make('nim')
                                ->label('NIM ')
                                ->numeric()
                                ->required(),

                            TextInput::make('absen')
                                ->label('Absen ')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $get, $set) {
                                    $this->updateTotalAndGrade($get, $set);
                                }),

                            TextInput::make('tugas')
                                ->label('Tugas ')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $get, $set) {
                                    $this->updateTotalAndGrade($get, $set);
                                }),

                            TextInput::make('uts')
                                ->label('UTS')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $get, $set) {
                                    $this->updateTotalAndGrade($get, $set);
                                }),

                            TextInput::make('uas')
                                ->label('UAS')
                                ->numeric()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $get, $set) {
                                    $this->updateTotalAndGrade($get, $set);
                                }),

                            TextInput::make('total_nilai')
                                ->label('Total Nilai ')
                                ->reactive()
                                ->disabled()
                                ,

                            TextInput::make('huruf_mutu')
                                ->label('Huruf Mutu ')
                                ->reactive()
                                ->disabled()
                                ,
                        ]),
                    ])
                    ->createItemButtonLabel('Tambah Mahasiswa')
                    ->collapsible()
                    ->reactive()
    ->afterStateUpdated(function ($state, $get, $set) {
        $this->updateTotalAndGrade($get, $set);
    }), // agar tampilan ringkas
            ])
        ]);
    }

    protected function updateTotalAndGrade($get, $set)
    {
        $mahasiswaNilai = $get('mahasiswa_nilai') ?? [];
    
        if (!is_array($mahasiswaNilai)) {
            return;
        }
    
        foreach ($mahasiswaNilai as $index => $data) {
            $persen = Persen::where('matakuliah_id', $get('matakuliah_id'))
                ->where('kelas_id', $get('kelas_id'))
                ->first();
    
            // Pastikan semua nilai sudah diinput sebelum menghitung total dan huruf mutu
            if ($persen && isset($data['absen'], $data['tugas'], $data['uts'], $data['uas'])) {
                $absen = floatval($data['absen']);
                $tugas = floatval($data['tugas']);
                $uts = floatval($data['uts']);
                $uas = floatval($data['uas']);
    
                $nilai_absen = $absen * ($persen->persen_absen / 100);
                $nilai_tugas = $tugas * ($persen->persen_latihan / 100);
                $nilai_uts = $uts * ($persen->persen_UTS / 100);
                $nilai_uas = $uas * ($persen->persen_UAS / 100);
    
                // Hitung total nilai dan huruf mutu
                $total = $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
                $huruf_mutu = $this->getLetterGrade($total);
    
                // Set total_nilai dan huruf_mutu hanya jika semua input sudah terisi
                $set("mahasiswa_nilai.$index.total_nilai", $total);
                $set("mahasiswa_nilai.$index.huruf_mutu", $huruf_mutu);
            } else {
                // Kosongkan total_nilai dan huruf_mutu jika belum lengkap
                $set("mahasiswa_nilai.$index.total_nilai", null);
                $set("mahasiswa_nilai.$index.huruf_mutu", null);
            }
        }
    }
    
    protected function getLetterGrade($total_nilai)
    {
        if ($total_nilai >= 90) {
            return 'A';
        } elseif ($total_nilai >= 80) {
            return 'A-';
        } elseif ($total_nilai >= 75) {
            return 'B+';
        } elseif ($total_nilai >= 70) {
            return 'B';
        } elseif ($total_nilai >= 65) {
            return 'B-';
        } elseif ($total_nilai >= 60) {
            return 'C+';
        } elseif ($total_nilai >= 55) {
            return 'C';
        } elseif ($total_nilai >= 50) {
            return 'C-';
        }elseif ($total_nilai >= 40) {
            return 'D';
        } else {
            return 'E';
        }
    }

    public function save()
    {
        $get = $this->form->getState();
        $insert = [];

        $persen = Persen::where('matakuliah_id', $get['matakuliah_id'])
                        ->where('kelas_id', $get['kelas_id'])
                        ->first();

        $persen_id = $persen ? $persen->id : null;

        foreach ($get['mahasiswa_nilai'] as $row) {
            $nilai_absen = floatval($row['absen']) * ($persen->persen_absen / 100);
            $nilai_tugas = floatval($row['tugas']) * ($persen->persen_latihan / 100);
            $nilai_uts = floatval($row['uts']) * ($persen->persen_UTS / 100);
            $nilai_uas = floatval($row['uas']) * ($persen->persen_UAS / 100);

            $total = $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
            $huruf_mutu = $this->getLetterGrade($total);

            array_push($insert, [
                'matakuliah_id' => $get['matakuliah_id'],
                'kelas_id' => $get['kelas_id'],
                'persen_id' => $persen_id,
                'nama_mahasiswa' => $row['nama_mahasiswa'],
                'nim' => $row['nim'],
                'absen' => $row['absen'],
                'tugas' => $row['tugas'],
                'uts' => $row['uts'],
                'uas' => $row['uas'],
                'total_nilai' => $total,
                'huruf_mutu' => $huruf_mutu,
            ]);
        }

        if ($persen_id !== null) {
            Hasil::insert($insert);
        } else {
            return redirect()->back()->withErrors(['error' => 'Data persen tidak ditemukan untuk kombinasi mata kuliah dan kelas yang dipilih.']);
        } 

        return redirect()->to('admin/hasils');
    }
} 