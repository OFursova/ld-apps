<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create(['name' => 'white', 'rgb' => '#FFFFFF']);
        Color::create(['name' => 'black', 'rgb' => '#000000']);
        Color::create(['name' => 'red', 'rgb' => '#FF0000']);
        Color::create(['name' => 'lime', 'rgb' => '#00FF00']);
        Color::create(['name' => 'blue', 'rgb' => '#0000FF']);
        Color::create(['name' => 'yellow', 'rgb' => '#FFFF00']);
        Color::create(['name' => 'cyan', 'rgb' => '#00FFFF']);
        Color::create(['name' => 'magenta', 'rgb' => '#FF00FF']);
        Color::create(['name' => 'silver', 'rgb' => '#C0C0C0']);
        Color::create(['name' => 'gray', 'rgb' => '#808080']);
        Color::create(['name' => 'maroon', 'rgb' => '#800000']);
        Color::create(['name' => 'olive', 'rgb' => '#808000']);
        Color::create(['name' => 'green', 'rgb' => '#008000']);
        Color::create(['name' => 'purple', 'rgb' => '#800080']);
        Color::create(['name' => 'teal', 'rgb' => '#008080']);
        Color::create(['name' => 'navy', 'rgb' => '#000080']);
    }
}
