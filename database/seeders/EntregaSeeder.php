<?php

namespace Database\Seeders;

use App\Models\FormasEntrega;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntregaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FormasEntrega::create([

            'nome'=>'Motoboy - Jacobina',
            'valor'=>'7.00',
            'local_relacionado'=>'1',
            'tipo_entrega'=>'Motoboy',

        ]);

         FormasEntrega::create([

            'nome'=>'Retirada na loja de Jacobina',
            'valor'=>'0.00',
            'local_relacionado'=>'1',
            'tipo_entrega'=>'Retirar na loja',

        ]);

        FormasEntrega::create([

            'nome'=>'Retirada na loja de Senhor do Bonfim',
            'valor'=>'0.00',
            'local_relacionado'=>'1',
            'tipo_entrega'=>'Retirar na loja',

        ]);

        FormasEntrega::create([

            'nome'=>'Retirada na loja de Capim Grosso',
            'valor'=>'0.00',
            'local_relacionado'=>'1',
            'tipo_entrega'=>'Retirar na loja',

        ]);

        FormasEntrega::create([

            'nome'=>'Motoboy - Petrolina',
            'valor'=>'15.00',
            'local_relacionado'=>'2',
            'tipo_entrega'=>'Motoboy',

        ]);
        FormasEntrega::create([

            'nome'=>'Motoboy - Juazeiro',
            'valor'=>'15.00',
            'local_relacionado'=>'2',
            'tipo_entrega'=>'Motoboy',

        ]);



          FormasEntrega::create([

            'nome'=>'Retirada na loja de Petrolina',
            'valor'=>'0.00',
            'local_relacionado'=>'2',
            'tipo_entrega'=>'Retirar na loja',

        ]);
          FormasEntrega::create([

            'nome'=>'Retirada na loja de River Shopping',
            'valor'=>'0.00',
            'local_relacionado'=>'2',
            'tipo_entrega'=>'Retirar na loja',

        ]);
          FormasEntrega::create([

            'nome'=>'Retirada na loja de Juazeiro',
            'valor'=>'0.00',
            'local_relacionado'=>'2',
            'tipo_entrega'=>'Retirar na loja',

        ]);
    }
}
