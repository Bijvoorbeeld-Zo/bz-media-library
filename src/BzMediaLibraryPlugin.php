<?php

namespace JornBoerema\BzMediaLibrary;

use Filament\Panel;
use Filament\Contracts\Plugin;
use JornBoerema\BzMediaLibrary\Filament\Pages\MediaLibrary;

class BzMediaLibraryPlugin implements Plugin
{

    public function getId(): string
    {
        return 'bz-media-library';
    }

    public function register(Panel $panel): void
    {
        $panel->resources([])->pages([
            MediaLibrary::class
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return new static;
    }
}
