<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SurveyQuestion;
use Filament\Resources\Resource;
use Filament\Navigation\NavigationItem;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\Pages\SurveyChart;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Survey & Tindak lanjut';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $questions = SurveyQuestion::all();

        $fields = [
            Forms\Components\TextInput::make('nama')->required(),
            Forms\Components\TextInput::make('nim')->required(),
            Forms\Components\TextInput::make('email')->required(),
            Forms\Components\Select::make('matakuliah_id')
                ->relationship('matakuliah', 'nama_mk')
                ->required(),
            Forms\Components\Select::make('kelas_id')
                ->relationship('kelas', 'nama_kelas')
                ->required(),
            Forms\Components\TextInput::make('nama_dosen')->required(),
        ];

        foreach ($questions as $question) {
            $fields[] = Forms\Components\Select::make('ratings[' . $question->id . ']')
                ->options([
                    1 => 'Sangat Buruk',
                    2 => 'Buruk',
                    3 => 'Cukup',
                    4 => 'Baik',
                    5 => 'Sangat Baik',
                ])
                ->label($question->label)
                ->required();
        }

        return $form->schema($fields);
    }

    public static function table(Table $table): Table
    {
        $questions = SurveyQuestion::all();

        return $table
            ->query(Survey::with('ratings.question')) // Eager load ratings dan questions
            ->columns(array_merge(
                [
                    Tables\Columns\TextColumn::make('nama')->label('Nama'),
                    Tables\Columns\TextColumn::make('nim')->label('NIM'),
                    Tables\Columns\TextColumn::make('email')->label('Email'),
                    Tables\Columns\TextColumn::make('matakuliah.nama_mk')->label('Matakuliah'),
                    Tables\Columns\TextColumn::make('kelas.nama_kelas')->label('Kelas'),
                    Tables\Columns\TextColumn::make('nama_dosen')->label('Dosen'),
                ],
                // Tambahkan kolom untuk setiap pertanyaan
                $questions->map(function ($question) {
                    return Tables\Columns\TextColumn::make('ratings.' . $question->id) // Menggunakan key dari ratings
                        ->label($question->label)
                        ->getStateUsing(function ($record) use ($question) {
                            // Ambil rating berdasarkan survey dan question
                            $rating = $record->ratings()->where('question_id', $question->id)->first();
                            return $rating ? $rating->rating : 'Belum Dinilai'; // Tampilkan rating atau keterangan jika tidak ada
                        });
                })->toArray()
            ))
            ->filters([
                Tables\Filters\SelectFilter::make('matakuliah_id')
                    ->label('Matakuliah')
                    ->relationship('matakuliah', 'nama_mk')
                    ->multiple(), // Jika ingin filter dengan multiple selection
                // Filter berdasarkan Nama Dosen
                SelectFilter::make('nama_dosen')
                    ->label('Nama Dosen')
                    ->options(
                        Survey::distinct()->pluck('nama_dosen')->mapWithKeys(fn($name) => [$name => $name])
                    )
                    ->placeholder('Pilih nama dosen...')
                    ->multiple(),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
            'chart' => Pages\SurveyChart::route('/chart'),

        ];
    }

    public static function getNavigationItems(): array
    {
        return [
            // Menu default untuk ListSurveys
            NavigationItem::make()
                ->label('Survey List')
                ->icon('heroicon-o-rectangle-stack')
                ->group('Survey & Tindak lanjut')
                ->url(static::getUrl()),

            // Menu tambahan untuk SurveyChart
            NavigationItem::make()
                ->label('Survey Chart')
                ->icon('heroicon-o-chart-bar')
                ->group('Survey & Tindak lanjut')
                ->url(SurveyChart::getUrl()),  // URL ke SurveyChart
        ];
    }
}
