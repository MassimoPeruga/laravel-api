<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ProjectTechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Disabilita temporaneamente i vincoli delle chiavi esterne
        Schema::disableForeignKeyConstraints();

        // Svuota la tabella pivot
        DB::table('project_technology')->truncate();

        // Riabilita i vincoli delle chiavi esterne
        Schema::enableForeignKeyConstraints();

        // Seleziona tutti i progetti e tutte le tecnologie esistenti
        $projects = Project::all();
        $technologies = Technology::all();

        // Cicla su ogni progetto
        foreach ($projects as $project) {
            // Genera un numero casuale di tecnologie associate a ciascun progetto
            $numberOfTechnologies = rand(0, $technologies->count());

            // Prendi un numero casuale di tecnologie
            $randomTechnologies = $technologies->random($numberOfTechnologies);

            // Associa le tecnologie selezionate al progetto
            $project->technologies()->attach($randomTechnologies);
        }
    }
}
