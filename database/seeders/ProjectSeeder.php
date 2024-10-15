<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Project as Project;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $project = new Project();

            $project->name = $faker->word();
            $project->description = $faker->paragraphs(2, true);
            $project->start_date = $faker->date();
            $project->end_date = $faker->date();
            $project->stack = implode('-', $faker->randomElements(['HTML', 'CSS', 'JS', 'EJS', 'VUE', 'VITE', 'PHP', 'LARAVEL', 'NODEJS'], 4));
            $project->status = $faker->boolean();
            $project->image_path = $faker->imageUrl(400, 300);
            $project->slug = Project::generateSlug($project->name);

            $project->save();
        }
    }
}
