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
use Illuminate\Database\Eloquent\Collection;
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
                    ->relationship('matakuliah', 'nama_mk') // Relasi dengan kolom 'nama_mk'
                    ->required()
                    ->searchable()
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        return "{$record->nama_mk} - {$record->tahun_ajaran}";
                    })
                    ->reactive()
                    ->columnSpanFull()
                    ->unique(),

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
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->sortable()
                    ->searchable()
                    ->columnSpanFull(),

                Tables\Columns\TextColumn::make('matakuliah.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sampel_quiz')
                    ->label('Sampel Quiz')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel Quiz' : 'No File')
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->url(fn($record) => $record->sampel_quiz ? asset('storage/' . $record->sampel_quiz) : null)
                    ->html()
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('sampel_latihan')
                    ->label('Sampel Latihan')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel Latihan' : 'No File')
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->url(fn($record) => $record->sampel_latihan ? asset('storage/' . $record->sampel_latihan) : null)
                    ->html()
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('sampel_UTS')
                    ->label('Sampel UTS')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel UTS' : 'No File')
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->url(fn($record) => $record->sampel_UTS ? asset('storage/' . $record->sampel_UTS) : null)
                    ->html()
                    ->openUrlInNewTab(),

                Tables\Columns\TextColumn::make('sampel_UAS')
                    ->label('Sampel UAS')
                    ->formatStateUsing(fn($state) => $state ? 'Lihat Sampel UAS' : 'No File')
                    ->extraAttributes(['style' => 'text-align: left;'])
                    ->url(fn($record) => $record->sampel_UAS ? asset('storage/' . $record->sampel_UAS) : null)
                    ->html()
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->after(function (SampelJawaban $record) {
                    if ($record->sampel_quiz) {
                        $quizPath = public_path('storage/' . $record->sampel_quiz);
                        if (file_exists($quizPath) && !is_dir($quizPath)) {
                            unlink($quizPath); // Menghapus file Quiz
                        }
                    }

                    if ($record->sampel_latihan) {
                        $latihanPath = public_path('storage/' . $record->sampel_latihan);
                        if (file_exists($latihanPath) && !is_dir($latihanPath)) {
                            unlink($latihanPath); // Menghapus file Latihan
                        }
                    }

                    if ($record->sampel_UTS) {
                        $utsPath = public_path('storage/' . $record->sampel_UTS);
                        if (file_exists($utsPath) && !is_dir($utsPath)) {
                            unlink($utsPath); // Menghapus file UTS
                        }
                    }

                    if ($record->sampel_UAS) {
                        $uasPath = public_path('storage/' . $record->sampel_UAS);
                        if (file_exists($uasPath) && !is_dir($uasPath)) {
                            unlink($uasPath); // Menghapus file UAS
                        }
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records) {
                    foreach ($records as $record) {
                        if ($record->sampel_quiz) {
                            $quizPath = public_path('storage/' . $record->sampel_quiz);
                            if (file_exists($quizPath) && !is_dir($quizPath)) {
                                unlink($quizPath); // Menghapus file Quiz
                            }
                        }

                        if ($record->sampel_latihan) {
                            $latihanPath = public_path('storage/' . $record->sampel_latihan);
                            if (file_exists($latihanPath) && !is_dir($latihanPath)) {
                                unlink($latihanPath); // Menghapus file Latihan
                            }
                        }

                        if ($record->sampel_UTS) {
                            $utsPath = public_path('storage/' . $record->sampel_UTS);
                            if (file_exists($utsPath) && !is_dir($utsPath)) {
                                unlink($utsPath); // Menghapus file UTS
                            }
                        }

                        if ($record->sampel_UAS) {
                            $uasPath = public_path('storage/' . $record->sampel_UAS);
                            if (file_exists($uasPath) && !is_dir($uasPath)) {
                                unlink($uasPath); // Menghapus file UAS
                            }
                        }
                    }
                }),
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
