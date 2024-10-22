<?php

namespace App\Filament\Resources\PersenResource\Pages;

use Filament\Actions;
use App\Models\Persen;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Filament\Forms;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PersenResource;

class ListPersens extends ListRecords
{
    protected static string $resource = PersenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Membuat aksi untuk menambah persentase
            Action::make('Tambah Persentase')
                ->label('Tambah Persentase')
                ->form([
            Forms\Components\Select::make('matakuliah_id')
                ->label('Mata Kuliah')
                ->relationship('matakuliah', 'nama_mk') // Relasi dengan kolom 'nama_mk'
                ->required()
                ->searchable()
                ->getOptionLabelFromRecordUsing(function ($record) {
                    // Menggabungkan nama mata kuliah dengan tahun ajaran untuk ditampilkan
                    return "{$record->nama_mk} - {$record->tahun_ajaran}";
                })
                ->reactive(),
            
            Forms\Components\Select::make('kelas_id')
                ->label('Kelas')
                ->searchable()
                ->options(function (callable $get) {
                    $matakuliahId = $get('matakuliah_id');
                    if (!$matakuliahId) {
                        return [];
                    }
                    return \App\Models\Kelas::where('matakuliah_id', $matakuliahId)
                        ->pluck('nama_kelas', 'id');
                })
                ->required()
                ->rules(function (callable $get) {
                    return [
                        function (string $attribute, $value, $fail) use ($get) {
                            // Cek apakah kombinasi duplikat
                            $exists = \App\Models\Persen::where('matakuliah_id', $get('matakuliah_id'))
                                ->where('kelas_id', $value)
                                ->exists();
            
                            if ($exists) {
                                $fail('Kombinasi Mata Kuliah dan Kelas sudah ada.');
                            }
                        },
                    ];
                }),

                    Forms\Components\TextInput::make('nama_dosen')
                        ->label('Nama Dosen')
                        ->required(),

                    // Inputan persentase
                    Forms\Components\TextInput::make('persen_absen')
                        ->label('Persen Absen (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->calculateTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_latihan')
                        ->label('Persen Latihan (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->calculateTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_UTS')
                        ->label('Persen UTS (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->calculateTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_UAS')
                        ->label('Persen UAS (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->calculateTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('total_persen')
                        ->label('Total Persentase (%)')
                        ->disabled()
                        ->numeric()
                        ->default(0),
                ])
                ->action(function (array $data) {
                    // Hitung total persentase
                    $totalPersen = intval($data['persen_absen']) + intval($data['persen_latihan']) + intval($data['persen_UTS']) + intval($data['persen_UAS']);

                    // Validasi total persentase harus 100%
                    if ($totalPersen !== 100) {
                        Notification::make()
                            ->title('Total persentase harus 100%')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Validasi apakah kombinasi matakuliah_id dan kelas_id sudah ada
                    $existingRecord = Persen::where('matakuliah_id', $data['matakuliah_id'])
                        ->where('kelas_id', $data['kelas_id'])
                        ->first();

                    if ($existingRecord) {
                        Notification::make()
                            ->title('Data untuk mata kuliah dan kelas ini sudah ada!')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Simpan data ke database
                    Persen::create([
                        'matakuliah_id' => $data['matakuliah_id'],
                        'kelas_id' => $data['kelas_id'],
                        'nama_dosen' => $data['nama_dosen'],
                        'persen_absen' => $data['persen_absen'],
                        'persen_latihan' => $data['persen_latihan'],
                        'persen_UTS' => $data['persen_UTS'],
                        'persen_UAS' => $data['persen_UAS'],
                        'total_persen' => $totalPersen,
                    ]);

                    // Notifikasi sukses
                    Notification::make()
                        ->title('Data berhasil disimpan!')
                        ->success()
                        ->send();
                })
                ->modalHeading('Tambah Persentase'),
        ];
    }

    protected function calculateTotalPersen($set, $get)
    {
        $persenAbsen = $get('persen_absen');
        $persenLatihan = $get('persen_latihan');
        $persenUTS = $get('persen_UTS');
        $persenUAS = $get('persen_UAS');

        // Periksa apakah semua input sudah terisi sebelum menghitung total
        if ($persenAbsen !== null && $persenLatihan !== null && $persenUTS !== null && $persenUAS !== null) {
            $totalPersen = intval($persenAbsen) + intval($persenLatihan) + intval($persenUTS) + intval($persenUAS);
            $set('total_persen', $totalPersen);
        }
    }
}