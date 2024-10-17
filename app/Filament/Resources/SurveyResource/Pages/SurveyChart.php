<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Resources\Pages\Page;

class SurveyChart extends Page
{
    protected static string $resource = SurveyResource::class;

    protected static string $view = 'filament.resources.survey-resource.pages.survey-chart';

    protected static ?string $navigationLabel = 'Survey Chart';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Survey & Tindak lanjut'; // Kelompok navigasi, opsional
    public static function getNavigation(): string
    {
        return static::getResource()::getNavigation('chart');  // Mengambil URL dari resource
    }
}
