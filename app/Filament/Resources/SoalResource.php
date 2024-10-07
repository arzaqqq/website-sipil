<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Soal;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Storage;
use App\Filament\Resources\SoalResource\Pages;

class SoalResource extends Resource
{
    protected static ?string $model = Soal::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Penilaian';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->relationship('matakuliah', 'nama_mk')
                    ->required()
                    ->reactive(),
                
                Forms\Components\Select::make('kelas_id')
                    ->label('Kelas')
                    ->options(function (callable $get) {
                        $matakuliahId = $get('matakuliah_id');
                        if (!$matakuliahId) {
                            return [];
                        }
                        return \App\Models\Kelas::where('matakuliah_id', $matakuliahId)
                            ->pluck('nama_kelas', 'id');
                    })
                    ->required(),

                // Form components for file uploads
                Forms\Components\FileUpload::make('quiz')
                    ->label('Quiz Files')
                    ->preserveFilenames()
                    ->multiple()
                    ->required(false),

                Forms\Components\FileUpload::make('latihan')
                    ->label('Latihan Files')
                    ->preserveFilenames()
                    ->multiple()
                    ->required(false),

                Forms\Components\FileUpload::make('UTS')
                    ->label('UTS File')
                    ->preserveFilenames()
                    ->required(false), // No multiple files for UTS

                Forms\Components\FileUpload::make('UAS')
                    ->label('UAS File')
                    ->preserveFilenames()
                    ->required(false), // No multiple files for UAS
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
                    Tables\Columns\TextColumn::make('quiz')
                    ->label('Quiz Files')
                    ->formatStateUsing(function ($record) {
                        // Check if the `quiz` field is an array of file paths
                        return is_array($record->quiz) 
                            ? collect($record->quiz)
                                ->map(function ($file) {
                                    // Generate the file URL
                                    $fileUrl = Storage::url($file); // Generate the file URL
                                    // Extract the file name
                                    $fileName = basename($file); // Kembalikan hanya nama file
                
                                    // Return the file name as a clickable download link
                                    return "<a href='{$fileUrl}' target='_blank'>{$fileName}</a>"; // Tambahkan tag <a>
                                })
                                ->implode('|') // Gunakan <br> untuk menampilkan file secara vertikal
                            : ($record->quiz 
                                ? "<a href='" . Storage::url($record->quiz) . "' target='_blank'>" . basename($record->quiz) . "</a>" // Tambahkan tag <a>
                                : 'No File'); // Handle case for single file or no file
                    })
                    ->html() // Pastikan HTML dirender
                    ->openUrlInNewTab(), // Buka link di tab baru
                

                
                    Tables\Columns\TextColumn::make('latihan')
                    ->label('Latihan Files')
                    ->formatStateUsing(function ($record) {
                        // Check if the `latihan` field is an array of file paths
                        return is_array($record->latihan)
                            ? collect($record->latihan)
                                ->map(function ($file) {
                                    // Generate URL for each file
                                    $fileUrl = asset('storage/' . $file); // Generate the file URL
                                    $fileName = basename($file); // Extract the file name
                
                                    // Return the file name as a clickable link
                                    return "<a href='{$fileUrl}' target='_blank'>{$fileName}</a>";
                                })
                                ->implode('|') // Ensure files are displayed on separate lines
                            : ($record->latihan 
                                ? "<a href='" . asset('storage/' . $record->latihan) . "' target='_blank'>" . basename($record->latihan) . "</a>" 
                                : 'No File'); // Handle case for single file or no file
                    })
                    ->html() // Ensure the HTML is rendered
                    // Add CSS for proper text wrapping
                ,
                
                

                Tables\Columns\TextColumn::make('UTS')
                    ->label('UTS File')
                    ->formatStateUsing(fn($state) => $state ?: 'No File'),

                Tables\Columns\TextColumn::make('UAS')
                    ->label('UAS File')
                    ->formatStateUsing(fn($state) => $state ?: 'No File'),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            // Define relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoals::route('/'),
            'create' => Pages\CreateSoal::route('/create'),
            'edit' => Pages\EditSoal::route('/{record}/edit'),
        ];
    }
}