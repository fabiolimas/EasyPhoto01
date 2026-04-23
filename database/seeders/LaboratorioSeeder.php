<?php

namespace Database\Seeders;

use App\Models\Laboratorio;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LaboratorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            Laboratorio::create([

                'nome'=>'Jacobina',
                'endereco'=>'Av. Orlando Oliveira Pires, 206 - Jacobina/BA',
                'status'=>'ativo'

            ]);

            Laboratorio::create([

                'nome'=>'Petrolina',
                'endereco'=>'Av. Guararapes - Petrolina/PE',
                'status'=>'ativo'

            ]);
    }
}
