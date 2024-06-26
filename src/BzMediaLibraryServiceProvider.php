<?php

namespace JornBoerema\BzMediaLibrary;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class BzMediaLibraryServiceProvider extends PackageServiceProvider
{

    public function configurePackage(Package $package): void
    {
        $package
            ->name('bz-media-library')
            ->hasViews()
            ->hasMigrations('create_media_library_items_table')
            ->hasInstallCommand(function (InstallCommand $installCommand) {
                $installCommand->publishMigrations();
            });
    }
}
