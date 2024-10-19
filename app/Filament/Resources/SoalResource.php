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
                    ->reorderable()
                    ->openable()
                    ->downloadable()
                    ->required(),

                Forms\Components\FileUpload::make('latihan')
                    ->label('Latihan Files')
                    ->preserveFilenames()
                    ->multiple()
                    ->required(),

                Forms\Components\FileUpload::make('UTS')
                    ->label('UTS File')
                    ->preserveFilenames()
                    ->required(), // No multiple files for UTS

                Forms\Components\FileUpload::make('UAS')
                    ->label('UAS File')
                    ->preserveFilenames()
                    ->required(), // No multiple files for UAS
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
        // Check if quiz is an array
        if (is_array($record->quiz)) {
            return collect($record->quiz)
                ->map(function ($file, $index) {
                    $fileUrl = Storage::url($file); // Generate the file URL
                    return "<a href='{$fileUrl}' target='_blank' style='display: inline-block; margin-right: 5px;'>quiz " . ($index + 1) . "</a>"; // Add <a> tag with numbering
                })
                ->implode(' | '); // Use ' | ' to separate the links
        }
        
        // Handle case for single file or no file
        return $record->quiz 
            ? "<a href='" . Storage::url($record->quiz) . "' target='_blank' style='display: inline-block;'>quiz 1</a>" 
            : 'No File'; // Handle case for no file
    })
    ->html() // Ensure HTML is rendered
    ->extraAttributes(['onclick' => 'event.stopPropagation();']), // Prevent event propagation

                
                
                
    Tables\Columns\TextColumn::make('latihan')
    ->label('Latihan Files')
    ->formatStateUsing(function ($record) {
        // Check if the `latihan` field is an array of file paths
        if (is_array($record->latihan)) {
            return collect($record->latihan)
                ->map(function ($file, $index) {
                    // Generate URL for each file
                    $fileUrl = asset('storage/' . $file); // Generate the file URL
                    $fileName = 'latihan ' . ($index + 1); // Create the name as "latihan 1", "latihan 2", etc.

                    // Return the file name as a clickable link with inline-block styling
                    return "<a href='{$fileUrl}' target='_blank' style='display: inline-block; margin-right: 5px;'>{$fileName}</a>";
                })
                ->implode(' | '); // Use ' | ' to separate the links
        }

        // Handle case for single file or no file
        return $record->latihan 
            ? "<a href='" . asset('storage/' . $record->latihan) . "' target='_blank' style='display: inline-block;'>latihan 1</a>" 
            : 'No File'; // Handle case for no file
    })
    ->html(), // Ensure the HTML is rendered

                

    Tables\Columns\TextColumn::make('UTS')
    ->label('UTS File')
    ->formatStateUsing(fn($state) => $state ? 'UTS' : 'No File')
    ->html()
    ->url(fn ($record) => $record->UTS ? asset('storage/' . $record->UTS) : null) // Mengatur URL untuk unduhan
    ->openUrlInNewTab()// Membuka URL di tab baru
    ->extraAttributes(['onclick' => 'event.stopPropagation();']),

Tables\Columns\TextColumn::make('UAS')
    ->label('UAS File')
    ->formatStateUsing(fn($state) => $state ? 'UAS' : 'No File')
    ->html()
    ->url(fn ($record) => $record->UAS ? asset('storage/' . $record->UAS) : null) // Mengatur URL untuk unduhan
    ->openUrlInNewTab()// Membuka URL di tab baru
    ->extraAttributes(['onclick' => 'event.stopPropagation();']),
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