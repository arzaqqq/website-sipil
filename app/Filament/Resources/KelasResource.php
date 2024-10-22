<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Kelas;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;

use Filament\Resources\Components\Tab;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\KelasResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\KelasResource\RelationManagers;



class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Perkuliahan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->options(
                        \App\Models\Matakuliah::all()->mapWithKeys(function ($matakuliah) {
                            return [
                                $matakuliah->id => "{$matakuliah->nama_mk} - {$matakuliah->tahun_ajaran}"
                            ];
                        })
                    )
                    ->required()
                    ->searchable(),

                Forms\Components\TextInput::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->required()
                    ->minLength(2)
                    ->rules(function ($get, $record) {
                        return [
                            function (string $attribute, $value, $fail) use ($get, $record) {
                                // Cek apakah kombinasi duplikat, kecuali data yang sedang diubah
                                $exists = \App\Models\Kelas::where('matakuliah_id', $get('matakuliah_id'))
                                    ->where('nama_kelas', $value)
                                    ->when($record, fn($query) => $query->where('id', '!=', $record->id)) // Abaikan ID yang sedang diubah
                                    ->exists();

                                if ($exists) {
                                    $fail('Kombinasi Mata Kuliah dan Nama Kelas sudah ada.');
                                }
                            },
                        ];
                    }),




                Forms\Components\FileUpload::make('file_template')
                    ->label('File Template')
                    ->required()
                    ->directory('template_kelas')
                    ->preserveFilenames(),

                Forms\Components\FileUpload::make('file_kelas')
                    ->label('File Kontak')
                    ->required()
                    ->directory('kelas')
                    ->preserveFilenames(),
            ])
            ->columns(2); // Opsional, untuk mengatur layout kolom
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kelas')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('matakuliah.nama_mk')
                    ->label('Mata Kuliah')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('matakuliah.tahun_ajaran')
                    ->label('Tahun Ajaran')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('matakuliah.semester')
                    ->label('Semester'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Tidak Aktif'),
                Tables\Columns\TextColumn::make('file_template')
                    ->label('File Template')
                    ->formatStateUsing(fn($state) => $state ? 'File Template' : 'No File')
                    ->url(fn($record) => $record->file_template ? asset("storage/{$record->file_template}") : null)
                    ->openUrlInNewTab()
                    ->extraAttributes([
                        'style' => 'cursor: pointer; ',
                        'title' => 'Download File Kontrak',
                        'class' => 'hover-underline-primary',

                    ]),
                Tables\Columns\TextColumn::make('file_kelas')
                    ->label('File Kontrak')
                    ->formatStateUsing(fn($state) => $state ? 'File Kontrak' : 'No File')
                    ->url(fn($record) => $record->file_kelas ? asset("storage/{$record->file_kelas}") : null)
                    ->openUrlInNewTab()
                    ->extraAttributes([
                        'style' => 'cursor: pointer; ',
                        'title' => 'Download File Kontrak',
                        'class' => 'hover-underline-primary',

                    ]),
            ])
            ->filters([


                // Filter Semester Ganjil
                Tables\Filters\Filter::make('Semester Ganjil')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereHas('matakuliah', fn(Builder $q) =>
                        $q->where('semester', 'ganjil'))
                    ),

                // Filter Semester Genap
                Tables\Filters\Filter::make('Semester Genap')
                    ->query(
                        fn(Builder $query) =>
                        $query->whereHas('matakuliah', fn(Builder $q) =>
                        $q->where('semester', 'genap'))
                    ),


                Tables\Filters\SelectFilter::make('nama_kelas')
                    ->label('Nama Kelas')
                    ->options(
                        \App\Models\Kelas::all()->pluck('nama_kelas', 'nama_kelas')
                    )
                    ->searchable()
                    ->placeholder('Pilih Nama Kelas'),
                // Filter Mata Kuliah
                Tables\Filters\SelectFilter::make('matakuliah_id')
                    ->label('Mata Kuliah')
                    ->searchable()
                    ->relationship('matakuliah', 'nama_mk'),




            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->after(function (Kelas $record) {
                    if ($record->file_template) {
                        $templatePath = public_path('storage/' . $record->file_template);
                        if (file_exists($templatePath) && !is_dir($templatePath)) {
                            unlink($templatePath); // Menghapus file template
                        }
                    }

                    // Hapus file_kelas
                    if ($record->file_kelas) {
                        $kelasPath = public_path('storage/' . $record->file_kelas);
                        if (file_exists($kelasPath) && !is_dir($kelasPath)) {
                            unlink($kelasPath); // Menghapus file kelas
                        }
                    }
                }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    BulkAction::make('Aktif')
                        ->action(fn(Collection $records) =>
                        $records->each->update(['status' => 1]))
                        ->label('Status Aktif')
                        ->icon('heroicon-o-check-circle')
                        ->requiresConfirmation()
                        ->color('success'),

                    BulkAction::make('Tidak Aktif')
                        ->action(fn(Collection $records) =>
                        $records->each->update(['status' => 0]))
                        ->label('Status Tidak Aktif')
                        ->icon('heroicon-o-x-circle')
                        ->requiresConfirmation()
                        ->color('danger'),
                ]),
                Tables\Actions\DeleteBulkAction::make()->after(function (Collection $records) {
                    foreach ($records as $record) {
                        if ($record->file_template) {
                            $templatePath = public_path('storage/' . $record->file_template);
                            if (file_exists($templatePath) && !is_dir($templatePath)) {
                                unlink($templatePath); // Menghapus file template
                            }
                        }
    
                        // Hapus file_kelas
                        if ($record->file_kelas) {
                            $kelasPath = public_path('storage/' . $record->file_kelas);
                            if (file_exists($kelasPath) && !is_dir($kelasPath)) {
                                unlink($kelasPath); // Menghapus file kelas
                            }
                        }
                    } 
                }),
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
