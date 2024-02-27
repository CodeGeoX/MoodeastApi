<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FraseDiaria;

class FraseDiariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FraseDiaria::create(['frase' => '¿Cuál es el sitio más bonito que has visitado y las fotos no le hacen justicia?']);
        FraseDiaria::create(['frase' => '¿Cuál es tu película favorita de todos los tiempos y por qué?']);
        FraseDiaria::create(['frase' => 'Si pudieras tener cualquier habilidad o superpoder, ¿cuál elegirías y por qué?']);
        FraseDiaria::create(['frase' => '¿Cuál es tu estrategia para manejar el estrés en situaciones difíciles?']);
        FraseDiaria::create(['frase' => '¿Qué actividad te ayuda a sentirte más relajado y en paz?']);
        FraseDiaria::create(['frase' => '¿Cómo te motivas cuando te sientes desanimado?']);
        FraseDiaria::create(['frase' => '¿Qué consejo le darías a alguien que está luchando con su salud mental?']);
        FraseDiaria::create(['frase' => '¿Cuál es tu recuerdo más feliz de la infancia?']);
        FraseDiaria::create(['frase' => '¿Qué te hace sentir agradecido hoy?']);
        FraseDiaria::create(['frase' => '¿Cuál es tu técnica favorita para mejorar tu estado de ánimo cuando te sientes triste?']);
        FraseDiaria::create(['frase' => '¿Cómo te cuidas a ti mismo durante los días difíciles?']);
        FraseDiaria::create(['frase' => '¿Qué te inspira a seguir adelante cuando las cosas parecen difíciles?']);

    }
}
