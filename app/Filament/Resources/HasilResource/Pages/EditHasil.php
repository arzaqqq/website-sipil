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
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\HasilResource;

class EditHasil extends EditRecord
{
    protected static string $resource = HasilResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            Card::make([
                Grid::make(3)->schema([
                    // Field Mata Kuliah - Disabled dengan dehydrateStateUsing untuk menyimpan nilai
                    Select::make('matakuliah_id')
                        ->label('Mata Kuliah')
                        ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                        ->default($this->record->matakuliah_id)
                        
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set) {
                            // Reset state ketika mata kuliah diubah
                            $set('kelas_id', null);
                            $set('nama_dosen', null);
                            $set('persen_absen', null);
                            $set('persen_latihan', null);
                            $set('persen_UTS', null);
                            $set('persen_UAS', null);
                        })
                        ->dehydrateStateUsing(fn ($state) => $state),

                    // Field Kelas - Disabled dengan dehydrateStateUsing untuk menyimpan nilai
                    Select::make('kelas_id')
                        ->label('Kelas')
                        ->options(function ($get) {
                            $matakuliahId = $get('matakuliah_id');
                            return $matakuliahId ? Kelas::where('matakuliah_id', $matakuliahId)->pluck('nama_kelas', 'id') : [];
                        })
                        ->default($this->record->kelas_id)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get, $state) {
                            $persen = Persen::where('matakuliah_id', $get('matakuliah_id'))
                                            ->where('kelas_id', $state)
                                            ->first();

                            if ($persen) {
                                // Set nilai persen dan nama dosen
                                $set('persen_absen', $persen->persen_absen);
                                $set('persen_latihan', $persen->persen_latihan);
                                $set('persen_UTS', $persen->persen_UTS);
                                $set('persen_UAS', $persen->persen_UAS);
                                $set('nama_dosen', $persen->nama_dosen);
                            } else {
                                // Reset jika tidak ada persen
                                $set('persen_absen', null);
                                $set('persen_latihan', null);
                                $set('persen_UTS', null);
                                $set('persen_UAS', null);
                                $set('nama_dosen', null);
                            }
                        })
                        ->dehydrateStateUsing(fn ($state) => $state),

                    // Field Nama Dosen - Disabled dengan default berdasarkan Persen
                    TextInput::make('nama_dosen')
                        ->label('Nama Dosen')
                        ->disabled()
                        ->default(function (callable $get) {
                            $matakuliah_id = $get('matakuliah_id');
                            $kelas_id = $get('kelas_id');
                            $persen = Persen::where('matakuliah_id', $matakuliah_id)
                                            ->where('kelas_id', $kelas_id)
                                            ->first();
                            return $persen ? $persen->nama_dosen : null;
                        }),
                ]),

                Grid::make(4)->schema([
                    // Field Persen Absen - Disabled dengan default berdasarkan Persen
                    TextInput::make('persen_absen')
                        ->label('Persen Absen')
                        ->disabled()
                        ->default(function (callable $get) {
                            $matakuliah_id = $get('matakuliah_id');
                            $kelas_id = $get('kelas_id');
                            $persen = Persen::where('matakuliah_id', $matakuliah_id)
                                            ->where('kelas_id', $kelas_id)
                                            ->first();
                            return $persen ? $persen->persen_absen : null;
                        }),

                    // Field Persen Latihan - Disabled dengan default berdasarkan Persen
                    TextInput::make('persen_latihan')
                        ->label('Persen Latihan')
                        ->disabled()
                        ->default(function (callable $get) {
                            $matakuliah_id = $get('matakuliah_id');
                            $kelas_id = $get('kelas_id');
                            $persen = Persen::where('matakuliah_id', $matakuliah_id)
                                            ->where('kelas_id', $kelas_id)
                                            ->first();
                            return $persen ? $persen->persen_latihan : null;
                        }),

                    // Field Persen UTS - Disabled dengan default berdasarkan Persen
                    TextInput::make('persen_UTS')
                        ->label('Persen UTS')
                        ->disabled()
                        ->default(function (callable $get) {
                            $matakuliah_id = $get('matakuliah_id');
                            $kelas_id = $get('kelas_id');
                            $persen = Persen::where('matakuliah_id', $matakuliah_id)
                                            ->where('kelas_id', $kelas_id)
                                            ->first();
                            return $persen ? $persen->persen_UTS : null;
                        }),

                    // Field Persen UAS - Disabled dengan default berdasarkan Persen
                    TextInput::make('persen_UAS')
                        ->label('Persen UAS')
                        ->disabled()
                        ->default(function (callable $get) {
                            $matakuliah_id = $get('matakuliah_id');
                            $kelas_id = $get('kelas_id');
                            $persen = Persen::where('matakuliah_id', $matakuliah_id)
                                            ->where('kelas_id', $kelas_id)
                                            ->first();
                            return $persen ? $persen->persen_UAS : null;
                        }),
                ]),
            ]),

            // Input fields untuk satu mahasiswa
            Card::make()->schema([
                Grid::make(8)->schema([
                    TextInput::make('nama_mahasiswa')
                        ->label('Mahasiswa')
                        ->default($this->record->nama_mahasiswa)
                        ->required(),

                    TextInput::make('nim')
                        ->label('NIM')
                        ->numeric()
                        ->default($this->record->nim)
                        ->required(),

                    TextInput::make('absen')
                        ->label('Absen')
                        ->default($this->record->absen)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $get, $set) {
                            $this->updateTotalAndGrade($get, $set);
                        }),

                    TextInput::make('tugas')
                        ->label('Tugas')
                        ->numeric()
                        ->default($this->record->tugas)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $get, $set) {
                            $this->updateTotalAndGrade($get, $set);
                        }),

                    TextInput::make('uts')
                        ->label('UTS')
                        ->numeric()
                        ->default($this->record->uts)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $get, $set) {
                            $this->updateTotalAndGrade($get, $set);
                        }),

                    TextInput::make('uas')
                        ->label('UAS')
                        ->numeric()
                        ->default($this->record->uas)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $get, $set) {
                            $this->updateTotalAndGrade($get, $set);
                        }),

                    TextInput::make('total_nilai')
                        ->label('Total Nilai')
                        ->reactive()
                        ->disabled()
                        ->default($this->record->total_nilai),

                    TextInput::make('huruf_mutu')
                        ->label('Huruf Mutu')
                        ->reactive()
                        ->disabled()
                        ->default($this->record->huruf_mutu),
                ]),
            ])
        ]);
    }

    /**
     * Override untuk mengisi data persen dan nama_dosen sebelum form diisi
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Pastikan 'matakuliah_id' dan 'kelas_id' ada dalam data
        $matakuliah_id = $data['matakuliah_id'] ?? $this->record->matakuliah_id;
        $kelas_id = $data['kelas_id'] ?? $this->record->kelas_id;

        // Cari data persen berdasarkan matakuliah_id dan kelas_id
        $persen = Persen::where('matakuliah_id', $matakuliah_id)
                        ->where('kelas_id', $kelas_id)
                        ->first();

        if ($persen) {
            $data['nama_dosen'] = $persen->nama_dosen;
            $data['persen_absen'] = $persen->persen_absen;
            $data['persen_latihan'] = $persen->persen_latihan;
            $data['persen_UTS'] = $persen->persen_UTS;
            $data['persen_UAS'] = $persen->persen_UAS;
        } else {
            // Reset jika tidak ada persen
            $data['nama_dosen'] = null;
            $data['persen_absen'] = null;
            $data['persen_latihan'] = null;
            $data['persen_UTS'] = null;
            $data['persen_UAS'] = null;
        }

        return $data;
    }

    /**
     * Menghitung total nilai dan huruf mutu berdasarkan input
     */
    protected function updateTotalAndGrade(callable $get, callable $set): void
    {
        $matakuliah_id = $get('matakuliah_id');
        $kelas_id = $get('kelas_id');

        if (!$matakuliah_id || !$kelas_id) {
            $set('total_nilai', null);
            $set('huruf_mutu', null);
            return;
        }

        $persen = Persen::where('matakuliah_id', $matakuliah_id)
                        ->where('kelas_id', $kelas_id)
                        ->first();

        if ($persen) {
            $absen = floatval($get('absen'));
            $tugas = floatval($get('tugas'));
            $uts = floatval($get('uts'));
            $uas = floatval($get('uas'));

            $nilai_absen = $absen * ($persen->persen_absen / 100);
            $nilai_tugas = $tugas * ($persen->persen_latihan / 100);
            $nilai_uts = $uts * ($persen->persen_UTS / 100);
            $nilai_uas = $uas * ($persen->persen_UAS / 100);

            $total = $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
            $huruf_mutu = $this->getLetterGrade($total);

            $set('total_nilai', $total);
            $set('huruf_mutu', $huruf_mutu);
        } else {
            $set('total_nilai', null);
            $set('huruf_mutu', null);
        }
    }

    /**
     * Mendapatkan huruf mutu berdasarkan total nilai
     */
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
        } elseif ($total_nilai >= 40) {
            return 'D';
        } else {
            return 'E'; 
        }
    }

    /**
     * Menyimpan data yang telah diperbarui
     */
    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $get = $this->form->getState();

        // Cek apakah record yang ada ditemukan
        $existingRecord = Hasil::find($this->record->id);
        if ($existingRecord) {
            // Validasi keberadaan foreign key
            if (!Matakuliah::find($get['matakuliah_id']) || !Kelas::find($get['kelas_id'])) {
                // Redirect jika data tidak ditemukan
                redirect()->back()->withErrors(['error' => 'Mata Kuliah atau Kelas tidak ditemukan.']);
                return; // Hentikan eksekusi setelah redirect
            }

            // Hitung total_nilai
            $total_nilai = $this->calculateTotal($get);
            $huruf_mutu = $this->getLetterGrade($total_nilai);

            // Perbarui record yang ada dengan data baru
            $existingRecord->update([
                'matakuliah_id' => (int) $get['matakuliah_id'],
                'kelas_id' => (int) $get['kelas_id'],
                'nama_mahasiswa' => (string) $get['nama_mahasiswa'],
                'nim' => (string) $get['nim'],
                'absen' => (float) $get['absen'],
                'tugas' => (float) $get['tugas'],
                'uts' => (float) $get['uts'],
                'uas' => (float) $get['uas'],
                'total_nilai' => $total_nilai,
                'huruf_mutu' => $huruf_mutu,
            ]);

            // Redirect setelah berhasil diperbarui
            if ($shouldRedirect) {
                redirect()->to('admin/hasils')->with('success', 'Data berhasil diperbarui!');
                return; // Hentikan eksekusi setelah redirect
            }
        } else {
            // Tangani kasus jika record tidak ditemukan
            redirect()->back()->withErrors(['error' => 'Data tidak ditemukan.']);
            return; // Hentikan eksekusi setelah redirect
        }
    }

    /**
     * Menghitung total nilai berdasarkan input dan persen
     */
    protected function calculateTotal($get)
    {
        $persen = Persen::where('matakuliah_id', $get['matakuliah_id'])
                        ->where('kelas_id', $get['kelas_id'])
                        ->first();

        if ($persen) {
            $nilai_absen = floatval($get['absen']) * ($persen->persen_absen / 100);
            $nilai_tugas = floatval($get['tugas']) * ($persen->persen_latihan / 100);
            $nilai_uts = floatval($get['uts']) * ($persen->persen_UTS / 100);
            $nilai_uas = floatval($get['uas']) * ($persen->persen_UAS / 100);

            return $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
        }

        return null; // Atau tangani sesuai kebutuhan
    }
}