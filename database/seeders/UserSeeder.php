<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([

            'name'=>'Fábio Lima',
            'email'=>'fabiolima01@live.com',
            'password'=>bcrypt('password'),
            'nivel'=>'administrador',
            'laboratorio_id'=>0,

        ]);

        User::create([

            'name'=>'Laboratório Jacobina',
            'email'=>'lab@lojasimagem.com.br',
            'password'=>bcrypt('vivo01'),
            'nivel'=>'laboratorio',
            'laboratorio_id'=>1,

        ]);

        User::create([

            'name'=>'Laboratório Petrolina',
            'email'=>'petrolina@lojasimagem.com.br',
            'password'=>bcrypt('imagem120'),
            'nivel'=>'laboratorio',
            'laboratorio_id'=>2,

        ]);
        User::create([

            'name'=>'Imagem Juazeiro',
            'email'=>'juazeiro@lojasimagem.com.br',
            'password'=>bcrypt('mudar123'),
            'nivel'=>'cliente',
            'laboratorio_id'=>0,

        ]);
        User::create([

            'name'=>'Imagem Capim Grosso',
            'email'=>'capimgrosso@lojasimagem.com.br',
            'password'=>bcrypt('mudar123'),
            'nivel'=>'cliente',
            'laboratorio_id'=>0,

        ]);

        User::create([

            'name'=>'Imagem Senhor do Bonfim',
            'email'=>'senhordobonfim@lojasimagem.com.br',
            'password'=>bcrypt('mudar123'),
            'nivel'=>'cliente',
            'laboratorio_id'=>0,

        ]);

        User::create([

            'name'=>'Imagem River',
            'email'=>'river@lojasimagem.com.br',
            'password'=>bcrypt('mudar123'),
            'nivel'=>'cliente',
            'laboratorio_id'=>0,

        ]);


    }
}
