<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\FileHasil;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\FileHasilResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FileHasilResource\RelationManagers;

class FileHasilResource extends Resource
{
    protected static ?string $model = FileHasil::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Upload File Hasil ';
    protected static ?string $navigationGroup = 'Hasil & Evaluasi';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                ->rules(function (callable $get, $record) {
                    return [
                        function (string $attribute, $value, $fail) use ($get, $record) {
                            // Cek apakah kombinasi duplikat, kecuali data yang sedang diubah
                            $exists = \App\Models\FileHasil::where('matakuliah_id', $get('matakuliah_id'))
                                ->where('kelas_id', $value)
                                ->when($record, fn ($query) => $query->where('id', '!=', $record->id)) // Abaikan ID yang sedang diubah
                                ->exists();
            
                            if ($exists) {
                                $fail('Kombinasi Mata Kuliah dan Kelas sudah ada.');
                            }
                        },
                    ];
                }),
            

                    FileUpload::make('file_hasil')
                    ->label('File Hasil Nilai')
                    ->required()
                    ->preserveFilenames()
                    ->directory('hasil'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('mataKuliah.nama_mk')
                    ->label('Mata Kuliah'),

                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),
                
                Tables\Columns\TextColumn::make('matakuliah.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable()
                    ->searchable(),
                    
                    TextColumn::make('file_hasil')
                    ->label('File Hasil Nilai')
                    ->formatStateUsing(function ($state) {
                        // Ubah tampilannya menjadi teks yang diinginkan
                        return $state ? 'File Hasil Penilaian' : 'Tidak Ada File';
                    })
                    ->url(function ($record) {
                        // Generate a downloadable URL
                        return $record->file_hasil ? Storage::url($record->file_hasil) : null;
                    })
                    ->openUrlInNewTab()  // Membuka file di tab baru
                    ->extraAttributes([
                        'style' => 'cursor: pointer;',  // Ubah kursor menjadi pointer untuk indikasi klik
                        'title' => 'Klik untuk mengunduh file hasil penilaian',  // Tooltip saat hover
                    ])
                

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFileHasils::route('/'),
            'create' => Pages\CreateFileHasil::route('/create'),
            'edit' => Pages\EditFileHasil::route('/{record}/edit'),
        ];
    }
}