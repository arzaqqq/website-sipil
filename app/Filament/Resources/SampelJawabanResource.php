<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SampelJawaban;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SampelJawabanResource\Pages;

class SampelJawabanResource extends Resource
{
    protected static ?string $model = SampelJawaban::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Penilaian';
    
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('matakuliah_id')
                ->label('Mata Kuliah')
                ->relationship('matakuliah', 'nama_mk')
                ->required()
                ->reactive(),
                
                Forms\Components\FileUpload::make('sampel_quiz')
                    ->label('Sampel Quiz')
                    ->directory('sampel')
                    ->preserveFilenames()
                    ->required(),
                Forms\Components\FileUpload::make('sampel_latihan')
                    ->label('Sampel Latihan')
                    ->directory('sampel')
                    ->preserveFilenames()
                    ->required(),
                Forms\Components\FileUpload::make('sampel_UTS')
                    ->label('Sampel UTS')
                    ->directory('sampel')
                    ->preserveFilenames()
                    ->required(),
                Forms\Components\FileUpload::make('sampel_UAS')
                    ->label('Sampel UAS')
                    ->directory('sampel')
                    ->preserveFilenames()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('mataKuliah.nama_mk')
                    ->label('Mata Kuliah'),
                    
                TextColumn::make('sampel_quiz')
                ->label('Sampel Quiz')
                ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel Quiz' : 'No File')
                ->extraAttributes(['style' => 'text-align: left;'])
                ->url(fn($record) => $record->sampel_quiz ? asset('storage/' . $record->sampel_quiz) : null)
                ->html()
                ->openUrlInNewTab(),
            
            TextColumn::make('sampel_latihan')
                ->label('Sampel Latihan')
                ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel Latiahan' : 'No File')
                ->extraAttributes(['style' => 'text-align: left;'])
                ->url(fn($record) => $record->sampel_latihan ? asset('storage/' . $record->sampel_latihan) : null)
                ->html()
                ->openUrlInNewTab(),
            
            TextColumn::make('sampel_UTS')
                ->label('Sampel UTS')
                ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel UTS' : 'No File')
                ->extraAttributes(['style' => 'text-align: left;'])
                ->url(fn($record) => $record->sampel_UTS ? asset('storage/' . $record->sampel_UTS) : null)
                ->html()
                ->openUrlInNewTab(),
            
            TextColumn::make('sampel_UAS')
                ->label('Sampel UAS')
                ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel UAS' : 'No File')
                ->extraAttributes(['style' => 'text-align: left;'])
                ->url(fn($record) => $record->sampel_UAS ? asset('storage/' . $record->sampel_UAS) : null)
                ->html()
                ->openUrlInNewTab(),
            
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSampelJawabans::route('/'),
            'create' => Pages\CreateSampelJawaban::route('/create'),
            'edit' => Pages\EditSampelJawaban::route('/{record}/edit'),
        ];
    }
}