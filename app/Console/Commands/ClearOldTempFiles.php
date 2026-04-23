<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ClearOldTempFiles extends Command
{
    protected $signature = 'temp:clear-old-files';
    protected $description = 'Remove arquivos e pastas com mais de 30 dias da pasta temp_uploads';

    public function handle()
    {
        $directory = storage_path('app/public/uploads');

        echo $directory;

        if (!File::exists($directory)) {
            $this->info("Diretório não encontrado.");
            $this->info($directory);
            return 0;
        }

        $files = File::allFiles($directory);
        $now = Carbon::now();

        foreach ($files as $file) {
            if ($now->diffInDays(Carbon::createFromTimestamp($file->getMTime())) > 60) {
                File::delete($file);
                $this->info("Arquivo deletado: {$file->getFilename()}");
            }
        }

        $folders = File::directories($directory);
        foreach ($folders as $folder) {
            if ($now->diffInDays(Carbon::createFromTimestamp(File::lastModified($folder))) > 30) {
                File::deleteDirectory($folder);
                $this->info("Pasta deletada: {$folder}");
            }
        }

        return 0;
    }
}
