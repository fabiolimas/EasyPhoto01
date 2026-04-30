<?php

namespace Database\Seeders;

use App\Models\Tamanho;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TamanhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tamanho::create([
            'nome'=>'10x15',
            'altura'=>'10',
            'largura'=>'15',
            'preco'=>2.20

        ]);

        Tamanho::create([
            'nome'=>'15x21',
            'altura'=>'15',
            'largura'=>'21',
            'preco'=>4

        ]);

        Tamanho::create([
            'nome'=>'15x20',
            'altura'=>'15',
            'largura'=>'20',
            'preco'=>4

        ]);

        Tamanho::create([
            'nome'=>'20x25',
            'altura'=>'20',
            'largura'=>'25',
            'preco'=>8.40

        ]);

        Tamanho::create([
            'nome'=>'20x30',
            'altura'=>'20',
            'largura'=>'30',
            'preco'=>9.60

        ]);

        Tamanho::create([
            'nome'=>'20x42',
            'altura'=>'20',
            'largura'=>'42',
            'preco'=>10.05

        ]);

        Tamanho::create([
            'nome'=>'25x30',
            'altura'=>'25',
            'largura'=>'30',
            'preco'=>13.60

        ]);

        Tamanho::create([
            'nome'=>'30x30',
            'altura'=>'30',
            'largura'=>'30',
            'preco'=>23.81

        ]);

        Tamanho::create([
            'nome'=>'30x40',
            'altura'=>'30',
            'largura'=>'40',
            'preco'=>32

        ]);

        Tamanho::create([
            'nome'=>'30x45',
            'altura'=>'30',
            'largura'=>'45',
            'preco'=>34

        ]);

        Tamanho::create([
            'nome'=>'30x60',
            'altura'=>'30',
            'largura'=>'60',
            'preco'=>39.68

        ]);

        Tamanho::create([
            'nome'=>'30x90',
            'altura'=>'30',
            'largura'=>'90',
            'preco'=>52.90

        ]);

    }
}
