<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Finder\Finder;

class LimparUploadsAntigos extends Command
{
    protected $signature = 'uploads:limpar';
    protected $description = 'Remove arquivos e pastas com mais de 2 meses em storage/app/public/uploads';

    public function handle()
    {
        $path = storage_path('app/public/uploads');
        $limite = Carbon::now()->subMonths(2);

        $arquivosRemovidos = 0;
        $pastasRemovidas = 0;

        if (!File::exists($path)) {
            $this->error('Diretório não encontrado.');
            Log::error("Limpeza de uploads: diretório não encontrado: {$path}");
            return;
        }

        Log::info('================ INÍCIO DA LIMPEZA DE UPLOADS ================');
        Log::info('Data/Hora: ' . now()->format('d/m/Y H:i:s'));

        // Remove arquivos antigos
        $itens = File::allFiles($path);

        foreach ($itens as $arquivo) {

            $ultimaModificacao = Carbon::createFromTimestamp($arquivo->getMTime());

            if ($ultimaModificacao->lt($limite)) {

                $arquivoPath = $arquivo->getRealPath();

                if (File::delete($arquivoPath)) {

                    $arquivosRemovidos++;

                    $this->info('Arquivo deletado: ' . $arquivoPath);

                    Log::info('Arquivo removido', [
                        'arquivo' => $arquivoPath,
                        'ultima_modificacao' => $ultimaModificacao->format('Y-m-d H:i:s'),
                    ]);
                } else {

                    Log::warning('Falha ao remover arquivo', [
                        'arquivo' => $arquivoPath
                    ]);
                }
            }
        }

        // Remove pastas vazias (das mais profundas para as mais rasas)
        $finder = new Finder();

        $finder->directories()
            ->in($path)
            ->sort(function ($a, $b) {
                return strlen($b->getRealPath()) - strlen($a->getRealPath());
            });

        foreach ($finder as $dir) {

            $dirPath = $dir->getRealPath();

            if (
                count(File::files($dirPath)) === 0 &&
                count(File::directories($dirPath)) === 0
            ) {

                if (File::deleteDirectory($dirPath)) {

                    $pastasRemovidas++;

                    $this->info('Pasta removida: ' . $dirPath);

                    Log::info('Pasta removida', [
                        'pasta' => $dirPath
                    ]);
                } else {

                    Log::warning('Falha ao remover pasta', [
                        'pasta' => $dirPath
                    ]);
                }
            }
        }

        Log::info('Resumo da limpeza', [
            'arquivos_removidos' => $arquivosRemovidos,
            'pastas_removidas'   => $pastasRemovidas,
            'fim'                => now()->format('d/m/Y H:i:s')
        ]);

        Log::info('================ FIM DA LIMPEZA DE UPLOADS ===================');

        $this->info("Limpeza concluída. Arquivos removidos: {$arquivosRemovidos}. Pastas removidas: {$pastasRemovidas}.");
    }
}
