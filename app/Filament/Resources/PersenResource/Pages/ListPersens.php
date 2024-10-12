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
            // Actions\CreateAction::make(),

            Action::make('Tambah Persentase')
                ->label('Tambah Persentase')
                ->form([
                    Forms\Components\Select::make('matakuliah_id')
                        ->label('Mata Kuliah')
                        ->options(Matakuliah::all()->pluck('nama_mk', 'id'))
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set) {
                            // Reset kelas saat mata kuliah berubah
                            $set('kelas_id', null);
                        }),

                    Forms\Components\Select::make('kelas_id')
                        ->label('Kelas')
                        ->options(function (callable $get) {
                            $matakuliahId = $get('matakuliah_id');
                            if (!$matakuliahId) {
                                return [];
                            }

                            return Kelas::where('matakuliah_id', $matakuliahId)
                                ->pluck('nama_kelas', 'id')
                                ->toArray();
                        })
                        ->required(),

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
                            $this->setTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_latihan')
                        ->label('Persen Latihan (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->setTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_UTS')
                        ->label('Persen UTS (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->setTotalPersen($set, $get);
                        }),

                    Forms\Components\TextInput::make('persen_UAS')
                        ->label('Persen UAS (%)')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($set, $get) {
                            $this->setTotalPersen($set, $get);
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

    

    protected function setTotalPersen($set, $get)
    {
        $totalPersen = intval($get('persen_absen')) + intval($get('persen_latihan')) + intval($get('persen_UTS')) + intval($get('persen_UAS'));
        $set('total_persen', $totalPersen);
    }
}