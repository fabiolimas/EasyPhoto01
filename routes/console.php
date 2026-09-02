<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');






Schedule::call(function () {

    $directory = storage_path('app/public/uploads');

    if (!File::exists($directory)) {
        return;
    }

    foreach (File::files($directory) as $file) {

        // Somente arquivos ZIP
        if (strtolower($file->getExtension()) !== 'zip') {
            continue;
        }

        // Excluir ZIPs com mais de 30 minutos
        if ($file->getMTime() < now()->subMinutes(30)->timestamp) {
            File::delete($file->getPathname());
        }
    }

})->everyTenMinutes();
