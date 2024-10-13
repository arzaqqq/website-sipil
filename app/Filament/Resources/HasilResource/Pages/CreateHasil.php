<?php

namespace App\Filament\Resources\HasilResource\Pages;

use App\Models\Hasil;
use App\Models\Persen;
use App\Filament\Resources\HasilResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateHasil extends CreateRecord
{
    protected static string $resource = HasilResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['persen_id'] = Persen::where('matakuliah_id', $data['matakuliah_id'])
            ->where('kelas_id', $data['kelas_id'])
            ->value('id');

        if (!$data['persen_id']) {
            throw new \Exception("Persen ID tidak ditemukan untuk Matakuliah ID {$data['matakuliah_id']} dan Kelas ID {$data['kelas_id']}. Pastikan data di tabel 'persens' tersedia.");
        }

        $data['total_nilai'] = $this->calculateTotalAndGrade($data);
        $data['huruf_mutu'] = $this->getLetterGrade($data['total_nilai']);

        return $data;
    }
    
    protected function calculateTotalAndGrade(array $data)
    {
        $persen = Persen::where('matakuliah_id', $data['matakuliah_id'] ?? null)
            ->where('kelas_id', $data['kelas_id'] ?? null)
            ->first();

        if ($persen) {
            $absen = floatval($data['absen'] ?? 0);
            $tugas = floatval($data['tugas'] ?? 0);
            $uts = floatval($data['uts'] ?? 0);
            $uas = floatval($data['uas'] ?? 0);

            $nilai_absen = $absen * ($persen->persen_absen / 100);
            $nilai_tugas = $tugas * ($persen->persen_latihan / 100);
            $nilai_uts = $uts * ($persen->persen_UTS / 100);
            $nilai_uas = $uas * ($persen->persen_UAS / 100);

            return $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
        }

        return 0;
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
        } else {
            return 'D';
        }
    }

    protected function getFormActions(): array
    {
        return [
            \Filament\Pages\Actions\ButtonAction::make('save')
                ->label('Simpan')
                ->action('submitForm')
                ->color('primary'),
            
            \Filament\Pages\Actions\ButtonAction::make('saveAndAddAnother')
                ->label('Simpan & Tambah Lagi')
                ->action('submitAndAddAnother')
                ->color('success'),
        ];
    }

    public function submitForm(): void
    {
        // Memastikan bahwa `mutateFormDataBeforeCreate` dipanggil
        $data = $this->mutateFormDataBeforeCreate($this->form->getState());

        // Simpan data dengan `create`
        Hasil::create($data);

        // Notifikasi berhasil disimpan
        Notification::make()
            ->title('Data berhasil disimpan!')
            ->success()
            ->send();

        $this->redirect($this->getResource()::getUrl('index'));
    }

    public function submitAndAddAnother(): void
    {
        // Memastikan bahwa `mutateFormDataBeforeCreate` dipanggil
        $data = $this->mutateFormDataBeforeCreate($this->form->getState());
    
        // Simpan data dengan `create`
        Hasil::create($data);
    
        // Kosongkan hanya input di Card 2 untuk memasukkan data baru
        $this->form->fill([
            'nama_mahasiswa' => null,
            'nim' => null,
            'target' => null,
            'hadir' => null,
            'absen' => null,
            'tugas' => null,
            'uts' => null,
            'uas' => null,
            'total_nilai' => null,
            'huruf_mutu' => null,
        ]);
    
        // Notifikasi berhasil disimpan dan siap menambah lagi
        Notification::make()
            ->title('Data berhasil disimpan! Anda dapat menambah data mahasiswa baru.')
            ->success()
            ->send();
    }
    
}