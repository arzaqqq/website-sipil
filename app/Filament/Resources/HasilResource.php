<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Hasil;
use App\Models\Kelas;
use App\Models\Persen;
use Pages\CreateHasils;

use Filament\Forms\Form;
use App\Models\Matakuliah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\HasilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HasilResource\RelationManagers;

class HasilResource extends Resource
{
    protected static ?string $model = Hasil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 3;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\Card::make([
                // Baris pertama: Mata Kuliah, Kelas, dan Nama Dosen
                Forms\Components\Grid::make(3)->schema([
                    Forms\Components\Select::make('matakuliah_id')
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
            
                    Forms\Components\Select::make('kelas_id')
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
            
                    Forms\Components\TextInput::make('nama_dosen')
                        ->label('Nama Dosen')
                        ->disabled(),
                ]),
            
                // Baris kedua: Persentase Absen, Latihan, UTS, dan UAS
                Forms\Components\Grid::make(4)->schema([
                    Forms\Components\TextInput::make('persen_absen')
                        ->label('Persen Absen')
                        ->disabled(),
            
                    Forms\Components\TextInput::make('persen_latihan')
                        ->label('Persen Latihan')
                        ->disabled(),
            
                    Forms\Components\TextInput::make('persen_UTS')
                        ->label('Persen UTS')
                        ->disabled(),
            
                    Forms\Components\TextInput::make('persen_UAS')
                        ->label('Persen UAS')
                        ->disabled(),
                ]),
            ]),
            
    
            Forms\Components\Card::make()->schema([
                Forms\Components\TextInput::make('nama_mahasiswa')
                    ->label('Nama Mahasiswa')
                    ->columnSpan('full')
                    ->required(),
            
                Forms\Components\TextInput::make('nim')
                    ->label('NIM Mahasiswa')
                    ->numeric()
                    ->required(),
            
                Forms\Components\TextInput::make('target')
                    ->label('Target Mahasiswa')
                    ->numeric()
                    ->required()
                    ->reactive(),

                Forms\Components\TextInput::make('hadir')
                    ->label('Kehadiran Mahasiswa')
                    ->numeric()
                    ->required()
                    ->reactive(),
            
                Forms\Components\TextInput::make('absen')
                    ->label('Nilai Absen Mahasiswa')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($set, $get) => self::calculateTotalAndGrade($set, $get)),
            
                Forms\Components\TextInput::make('tugas')
                    ->label('Nilai Tugas Mahasiswa')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($set, $get) => self::calculateTotalAndGrade($set, $get)),
            
                Forms\Components\TextInput::make('uts')
                    ->label('Nilai UTS Mahasiswa')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($set, $get) => self::calculateTotalAndGrade($set, $get)),
            
                Forms\Components\TextInput::make('uas')
                    ->label('Nilai UAS Mahasiswa')
                    ->numeric()
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn($set, $get) => self::calculateTotalAndGrade($set, $get)),
            
                Forms\Components\TextInput::make('total_nilai')
                    ->label('Total Nilai Mahasiswa')
                    ->disabled(),
            
                Forms\Components\TextInput::make('huruf_mutu')
                    ->label('Huruf Mutu Mahasiswa')
                    ->disabled(),
            ]),
            // Card 2
        ]);
    }
      
    

    protected static function calculateTotalAndGrade($set, $get)
    {
        // Cari persentase berdasarkan kelas dan matakuliah
        $persen = Persen::where('matakuliah_id', $get('matakuliah_id'))
            ->where('kelas_id', $get('kelas_id'))
            ->first();
    
        if ($persen) {
            // Ambil nilai dari state form dan konversi ke float
            $hadir = floatval($get('hadir') ?? 0);
            $absen = floatval($get('absen') ?? 0);
            $tugas = floatval($get('tugas') ?? 0);
            $uts = floatval($get('uts') ?? 0);
            $uas = floatval($get('uas') ?? 0);
    
            // Hitung nilai berdasarkan persentase yang ada
            $nilai_absen = $absen * ($persen->persen_absen / 100);
            $nilai_tugas = $tugas * ($persen->persen_latihan / 100);
            $nilai_uts = $uts * ($persen->persen_UTS / 100);
            $nilai_uas = $uas * ($persen->persen_UAS / 100);
    
            // Hitung total nilai
            $total_nilai = $nilai_absen + $nilai_tugas + $nilai_uts + $nilai_uas;
            $set('total_nilai', $total_nilai);
    
            // Dapatkan huruf mutu
            $huruf_mutu = self::getLetterGrade($total_nilai);
            $set('huruf_mutu', $huruf_mutu);
        } else {
            // Reset jika tidak ada persentase
            $set('total_nilai', null);
            $set('huruf_mutu', null);
        }
    }
    

    protected static function getLetterGrade($total_nilai)
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

    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('nama_mahasiswa')
                ->label('Nama Mahasiswa')
                ->sortable()
                ->searchable(),
            
            Tables\Columns\TextColumn::make('nim')
                ->label('NIM')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                ->label('Mata Kuliah')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('kelas.nama_kelas')
                ->label('Kelas')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('absen')
                ->label('Nilai Absen')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('tugas')
                ->label('Nilai Tugas')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('uts')
                ->label('Nilai UTS')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('uas')
                ->label('Nilai UAS')
                ->sortable()
                ->searchable(),
                
            Tables\Columns\TextColumn::make('total_nilai')
                ->label('Total Nilai')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('huruf_mutu')
                ->label('Huruf Mutu')
                ->sortable()
                ->searchable(),
                

                
        ])
        
        ->filters([
            // Tambahkan filter jika diperlukan
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            
            
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}


     // Menambahkan tombol dan aksi untuk mengganti template
     

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHasils::route('/'),
            'create' => Pages\CreateHasil::route('/create'),
            'edit' => Pages\EditHasil::route('/{record}/edit'),
        ];
    }
}