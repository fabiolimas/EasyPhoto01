<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LimparZips extends Command
{
    protected $signature = 'zips:limpar';

    protected $description = 'Remove arquivos ZIP temporários antigos';

    public function handle()
    {
        $directory = storage_path('app/public/uploads');

        if (!is_dir($directory)) {
            $this->error('Diretório não encontrado: ' . $directory);
            return Command::FAILURE;
        }

        $files = glob($directory . '/*.zip');

        if (!$files) {
            $this->info('Nenhum arquivo ZIP encontrado.');
            return Command::SUCCESS;
        }

        $quantidade = 0;

        foreach ($files as $file) {

            if (!is_file($file)) {
                continue;
            }

            $limite = now()->subMinutes(10)->timestamp;
            // ZIPs com mais de 1 hora
            if (filemtime($file) < $limite) {

                if (@unlink($file)) {

                    $quantidade++;

                    $this->info(
                        'Excluído: ' . basename($file)
                    );
                } else {

                    $this->error(
                        'Não foi possível excluir: ' . basename($file)
                    );
                }
            }
        }

        $this->info(
            "Limpeza concluída. {$quantidade} arquivo(s) excluído(s)."
        );

        return Command::SUCCESS;
    }
}
