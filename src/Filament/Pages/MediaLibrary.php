<?php

namespace JornBoerema\BzMediaLibrary\Filament\Pages;

use Filament\Pages\Page;

class MediaLibrary extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Media';
    protected static ?int $navigationSort = 999;

    protected static string $view = 'bz-media-library::filament.pages.media-library';

    protected $listeners = [
        'refresh_media' => '$refresh'
    ];
}
