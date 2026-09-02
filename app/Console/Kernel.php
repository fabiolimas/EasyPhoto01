<?php

namespace App\Console;

use App\Models\Payment;
use App\Models\Pedido;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {

     $schedule->command('uploads:limpar')->daily();
        // $schedule->command('inspire')->hourly();
        $schedule->command('temp:clear-old-files')->dailyAt('3:00');

         $schedule->call(function () {
        $pedidos = Payment::where('status', 'pendente')->get();



        foreach ($pedidos as $pedido) {
            $data = app()->call('App\Http\Controllers\PagamentoController@consultarPix', [
                'paymentId' => $pedido->payment_id
            ]);

            $pedidoreg=Pedido::find($pedido->pedido_id);

            if ($data['Payment']['Status'] == 2) {
                $pedido->status = 'pago';
                $pedido->save();

                $pedidoreg->status_pagamento='pago';
                $pedidoreg->save();
            }
        }
    })->everyMinute();

    $schedule->call(function () {

        $directory = storage_path('app/public/uploads');

        if (!is_dir($directory)) {
            return;
        }

        $files = glob($directory . '/*.zip');

        if (!$files) {
            return;
        }

        foreach ($files as $file) {

            // Arquivos ZIP com mais de 30 minutos
            if (filemtime($file) < now()->subMinutes(30)->timestamp) {

                @unlink($file);
            }
        }

    })->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


}
