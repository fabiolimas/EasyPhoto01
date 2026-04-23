<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cliente::create([

            'nome'=>'Fábio Lima',
            'email'=>'fabiolima01@live.com',
            'telefone'=>'74991381274',
            'endereco'=>'Rua do Cantinho',
            'bairro'=>'Curral Velho',
            'cidade'=>'Miguel Calmon',
            'uf'=>'BA',
            'user_id'=>1,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Laboratório Jacobina',
            'email'=>'lab@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida Orlando Oliveira Pires',
            'bairro'=>'Centro',
            'cidade'=>'Jacobina',
            'uf'=>'BA',
            'user_id'=>2,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Laboratório Petrolina',
            'email'=>'petrolina@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida Guararapes',
            'bairro'=>'Centro',
            'cidade'=>'Petrolina',
            'uf'=>'PE',
            'user_id'=>3,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Imagem Juazeiro',
            'email'=>'juazeiro@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida Guararapes',
            'bairro'=>'Centro',
            'cidade'=>'Juazeiro',
            'uf'=>'BA',
            'user_id'=>4,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Imagem Capim Grosso',
            'email'=>'capimgrosso@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida ACM',
            'bairro'=>'Centro',
            'cidade'=>'Capim Grosso',
            'uf'=>'BA',
            'user_id'=>5,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Imagem Senhor do Bonfim',
            'email'=>'senhordobonfim@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida Guararapes',
            'bairro'=>'Centro',
            'cidade'=>'Senhro do Bonfim',
            'uf'=>'BA',
            'user_id'=>6,
            'cep'=>'44700000',

        ]);

        Cliente::create([

            'nome'=>'Imagem River',
            'email'=>'river@lojasimagem.com.br',
            'telefone'=>'7436213085',
            'endereco'=>'Avenida Guararapes',
            'bairro'=>'Centro',
            'cidade'=>'Petrolina',
            'uf'=>'PE',
            'user_id'=>7,
            'cep'=>'44700000',

        ]);
    }
}
