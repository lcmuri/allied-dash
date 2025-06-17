<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\DoseForm;
use Illuminate\Database\Seeder;

class DoseFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doseForms = [
            // Solid Oral Dosage Forms
            ['name' => 'Tablet', 'description' => 'Solid dosage form for oral administration'],
            ['name' => 'Capsule', 'description' => 'Gelatin shell containing medication'],
            ['name' => 'Chewable Tablet', 'description' => 'Tablet designed to be chewed before swallowing'],
            ['name' => 'Sublingual Tablet', 'description' => 'Tablet that dissolves under the tongue'],
            ['name' => 'Buccal Tablet', 'description' => 'Tablet that dissolves between cheek and gum'],

            // Liquid Oral Dosage Forms
            ['name' => 'Syrup', 'description' => 'Sweetened liquid medication'],
            ['name' => 'Suspension', 'description' => 'Liquid with undissolved particles that settle on standing'],
            ['name' => 'Solution', 'description' => 'Clear liquid with dissolved medication'],
            ['name' => 'Elixir', 'description' => 'Clear, sweetened hydro-alcoholic solution'],
            ['name' => 'Drops', 'description' => 'Concentrated liquid for precise dosing'],

            // Topical Dosage Forms
            ['name' => 'Cream', 'description' => 'Semi-solid emulsion for topical application'],
            ['name' => 'Ointment', 'description' => 'Greasy semi-solid for topical application'],
            ['name' => 'Gel', 'description' => 'Semi-solid system for topical application'],
            ['name' => 'Lotion', 'description' => 'Low-viscosity liquid for topical application'],
            ['name' => 'Patch', 'description' => 'Transdermal drug delivery system'],

            // Injectable Dosage Forms
            ['name' => 'Injection', 'description' => 'Sterile solution for parenteral administration'],
            ['name' => 'Ampoule', 'description' => 'Sealed glass container for injectable medication'],
            ['name' => 'Vial', 'description' => 'Glass container with rubber stopper for injectables'],
            ['name' => 'Prefilled Syringe', 'description' => 'Ready-to-use syringe with medication'],

            // Special Dosage Forms
            ['name' => 'Suppository', 'description' => 'Solid dosage form for rectal/vaginal administration'],
            ['name' => 'Vaginal Tablet', 'description' => 'Tablet for vaginal insertion'],
            ['name' => 'Inhaler', 'description' => 'Device for delivering medication to the lungs'],
            ['name' => 'Nebulizer Solution', 'description' => 'Liquid converted to mist for inhalation'],
            ['name' => 'Eye Drops', 'description' => 'Sterile solution for ophthalmic use'],
            ['name' => 'Ear Drops', 'description' => 'Solution for aural administration'],
        ];

        foreach ($doseForms as $doseForm) {
            DoseForm::firstOrCreate(
                ['name' => $doseForm['name']],
                ['description' => $doseForm['description']]
            );
        }

        $this->command->info('Successfully seeded dose forms!');
    }
}
