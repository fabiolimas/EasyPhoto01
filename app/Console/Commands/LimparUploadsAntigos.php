<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Finder;

class LimparUploadsAntigos extends Command
{
    protected $signature = 'uploads:limpar';
    protected $description = 'Remove arquivos e pastas com mais de 2 meses em storage/app/public/uploads';

    public function handle()
    {
        $path = storage_path('app/public/uploads');
        $limite = Carbon::now()->subMonth(2);

        if (!File::exists($path)) {
            $this->error('Diretório não encontrado.');
            return;
        }

        // Percorre todos os arquivos e pastas
        $itens = File::allFiles($path);

        foreach ($itens as $arquivo) {
            $ultimaModificacao = Carbon::createFromTimestamp($arquivo->getMTime());

            if ($ultimaModificacao->lt($limite)) {
                File::delete($arquivo->getRealPath());
                $this->info('Arquivo deletado: ' . $arquivo->getFilename());
            }
        }

       // Remove pastas vazias recursivamente
$finder = new Finder();
$finder->directories()->in($path)->sort(function ($a, $b) {
    return strlen($b->getRealPath()) - strlen($a->getRealPath()); // mais profundas primeiro
});

foreach ($finder as $dir) {
    $dirPath = $dir->getRealPath();

    if (count(File::files($dirPath)) === 0 && count(File::directories($dirPath)) === 0) {
        File::deleteDirectory($dirPath);
        $this->info('Pasta removida: ' . $dirPath);
    }
}

        $this->info('Limpeza concluída.');
    }
}
