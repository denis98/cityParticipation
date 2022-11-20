<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Area;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $munich = new Area(array('label' => 'München'));
				$munich->save();

				$labels = array(
					"Maxvorstadt",
					"Lehel",
					"Neuperlach",
					"Trudering-Riem",
					"Neuhausen",
					"Neuhausen-Nymphenburg",
					"Pasing",
					"Laim",
					"Sendling",
					"Solln",
					"Isarvorstadt",
					"Ramersdorf",
					"Haidhausen",
					"Bogenhausen",
					"Ludwigsvorstadt",
					"Schwabing",
					"Milbertshofen",
					"Hasenbergl",
					"Berg am Laim",
					"Giesing",
					"Daglfing",
					"Denning",
					"Nymphenburg",
					"Obermenzing",
					"Untermenzing",
				);

				foreach($labels as $label) {
					$area = new Area(array('label' => $label) );
					$area->parent_id = 1;
					$area->save();
				}
    }
}
