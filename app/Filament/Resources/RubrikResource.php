<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rubrik;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RubrikResource\Pages;
use App\Filament\Resources\RubrikResource\RelationManagers;

class RubrikResource extends Resource
{
    protected static ?string $model = Rubrik::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?int $navigationSort = 3;

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
                            $exists = \App\Models\Rubrik::where('matakuliah_id', $get('matakuliah_id'))
                                ->where('kelas_id', $value)
                                ->when($record, fn ($query) => $query->where('id', '!=', $record->id)) // Abaikan ID yang sedang diubah
                                ->exists();
            
                            if ($exists) {
                                $fail('Kombinasi Mata Kuliah dan Kelas sudah ada.');
                            }
                        },
                    ];
                }),
            

                FileUpload::make('file_rubrik_quiz')
                    ->label('File Rubrik Quiz')
                    ->required()
                    ->multiple() // Menandakan bahwa ini adalah array file
                    ->preserveFilenames()
                    ->directory('rubrik'),

                FileUpload::make('file_rubrik_latihan')
                    ->label('File Rubrik Latihan')
                    ->required()
                    ->multiple() // Menandakan bahwa ini adalah array file
                    ->preserveFilenames()
                    ->directory('rubrik'),

                FileUpload::make('file_rubrik_uts')
                    ->label('File Rubrik UTS')
                    ->required()
                    ->preserveFilenames()
                    ->directory('rubrik'),

                FileUpload::make('file_rubrik_uas')
                    ->label('File Rubrik UAS')
                    ->required()
                    ->preserveFilenames()
                    ->directory('rubrik'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah'),

                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas'),

                Tables\Columns\TextColumn::make('matakuliah.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable()
                    ->searchable(),

                    Tables\Columns\TextColumn::make('file_rubrik_quiz')
                    ->label('file rubrik quiz')
                    ->formatStateUsing(function ($record) {
                        // Check if the `quiz` field is an array of file paths
                        if (is_array($record->file_rubrik_quiz)) {
                            return collect($record->file_rubrik_quiz)
                                ->map(function ($file, $index) {
                                    // Generate URL for each file
                                    $fileUrl = asset('storage/' . $file); // Generate the file URL
                                    $fileName = 'Rubrik ' . ($index + 1); // Create the name as "latihan 1", "latihan 2", etc.
                
                                    // Return the file name as a clickable link with inline-block styling
                                    return "<a href='{$fileUrl}' target='_blank' style='display: inline-block; margin-right: 5px;'>{$fileName}</a>";
                                })
                                ->implode(' | '); // Use ' | ' to separate the links
                        }
                
                        // Handle case for single file or no file
                        return $record->latihan 
                            ? "<a href='" . asset('storage/' . $record->file_rubrik_latihan) . "' target='_blank' style='display: inline-block;'>latihan 1</a>" 
                            : 'No File'; // Handle case for no file
                    })
                    ->html(), // Ensure the HTML is rendered
                
                              

    Tables\Columns\TextColumn::make('file_rubrik_latihan')
    ->label('file rubrik latihan')
    ->formatStateUsing(function ($record) {
        // Check if the `latihan` field is an array of file paths
        if (is_array($record->file_rubrik_latihan)) {
            return collect($record->file_rubrik_latihan)
                ->map(function ($file, $index) {
                    // Generate URL for each file
                    $fileUrl = asset('storage/' . $file); // Generate the file URL
                    $fileName = 'Rubrik ' . ($index + 1); // Create the name as "latihan 1", "latihan 2", etc.

                    // Return the file name as a clickable link with inline-block styling
                    return "<a href='{$fileUrl}' target='_blank' style='display: inline-block; margin-right: 5px;'>{$fileName}</a>";
                })
                ->implode(' | '); // Use ' | ' to separate the links
        }

        // Handle case for single file or no file
        return $record->latihan 
            ? "<a href='" . asset('storage/' . $record->file_rubrik_latihan) . "' target='_blank' style='display: inline-block;'>latihan 1</a>" 
            : 'No File'; // Handle case for no file
    })
    ->html(), // Ensure the HTML is rendered

               

                

                Tables\Columns\TextColumn::make('file_rubrik_uts')
                    ->label('File Rubrik UTS')
                    ->formatStateUsing(fn ($state) => $state ? "<a href='" . asset('storage/' . $state) . "' target='_blank'>Lihat File</a>" : 'No File')
                    ->html()
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->tooltip(fn ($state) => $state ? 'Klik untuk mengunduh' : null),

                Tables\Columns\TextColumn::make('file_rubrik_uas')
                    ->label('File Rubrik UAS')
                    ->formatStateUsing(fn ($state) => $state ? "<a href='" . asset('storage/' . $state) . "' target='_blank'>Lihat File</a>" : 'No File')
                    ->html()
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->tooltip(fn ($state) => $state ? 'Klik untuk mengunduh' : null),
            ])
            ->filters([
                // Tambahkan filter jika diperlukan
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
            // Tambahkan relasi jika diperlukan
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRubriks::route('/'),
            'create' => Pages\CreateRubrik::route('/create'),
            'edit' => Pages\EditRubrik::route('/{record}/edit'),
        ];
    }
}