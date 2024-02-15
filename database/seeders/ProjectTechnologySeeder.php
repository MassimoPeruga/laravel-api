<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Seleziona tutti i progetti e tutte le tecnologie esistenti
        $projects = Project::all();
        $technologies = Technology::all();

        // Cicla su ogni progetto
        foreach ($projects as $project) {
            // in questo caso scegliamo un numero tra 1 e la metà delle tecnologie disponibili
            $numberOfTechnologies = rand(1, $technologies->count());

            // Prendi un numero casuale di tecnologie
            $randomTechnologies = $technologies->random($numberOfTechnologies);

            // Associa le tecnologie selezionate al progetto
            $project->technologies()->attach($randomTechnologies);
        }
    }
}
