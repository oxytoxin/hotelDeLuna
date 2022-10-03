<?php

namespace Database\Seeders;

use App\Models\HotelItem;
use App\Models\RequestableItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlmaResidencesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'MAIN DOOR',
            'price' => 5000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'PURTAHAN SA C.R.',
            'price' => 2500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SUGA SA ROOM',
            'price' => 150,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SUGA SA C.R.',
            'price' => 130,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SAMIN SULOD SA ROOM',
            'price' => 1000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SAMIN SULOD SA C.R.',
            'price' => 1000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SAMIN SA GAWAS',
            'price' => 1500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SALOG SA ROOM PER TILES',
            'price' => 1200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SALOG SA C.R. PER TILE',
            'price' => 1200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'RUG/ TRAPO SA SALOG',
            'price' => 40,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'UNLAN',
            'price' => 500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'HABOL',
            'price' => 500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'PUNDA',
            'price' => 200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'PUNDA WITH MANTSA(HAIR DYE)',
            'price' => 500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'BEDSHEET WITH INK',
            'price' => 500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'BED PAD WITH INK',
            'price' => 800,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'BED SKIRT WITH INK',
            'price' => 1500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'TOWEL',
            'price' => 300,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'DOORKNOB C.R.',
            'price' => 350,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'MAIN DOOR DOORKNOB',
            'price' => 500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'T.V.',
            'price' => 30000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'TELEPHONE',
            'price' => 1000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'DECODER PARA SA CABLE',
            'price' => 1600,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'CORD SA DECODER',
            'price' => 100,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'CHARGER SA DECODER',
            'price' => 400,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'WIRING SA TELEPHONE',
            'price' => 100,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'WIRINGS SA T.V.',
            'price' => 200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'WIRING SA DECODER',
            'price' => 50,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'CEILING',
            'price' => 0,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SHOWER HEAD',
            'price' => 800,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SHOWER BULB',
            'price' => 800,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'BIDET',
            'price' => 400,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'HINGES/ TOWEL BAR',
            'price' => 200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'TAKLOB SA TANGKE',
            'price' => 1200,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'TANGKE SA BOWL',
            'price' => 3000,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'TAKLOB SA BOWL',
            'price' => 1000,
        ]);
       
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'ILALOM SA LABABO',
            'price' => 0,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'SINK/LABABO',
            'price' => 1500,
        ]);
        HotelItem::create([
            'branch_id' => 1,
            'name' => 'BASURAHAN',
            'price' => 70,
        ]);
        RequestableItem::create([
            'branch_id' => 1,
            'name' => 'EXTRA PERSON WITH FREE PILLOW, BLANKET,TOWEL',
            'price'=>'100'
        ]);
        RequestableItem::create([
            'branch_id'=>1,
            'name'=>'EXTRA TOWEL',
            'price'=>'20'
        ]);
        RequestableItem::create([
            'branch_id'=>1,
            'name'=>'EXTRA BLANKET',
            'price'=>'20'
        ]);
        RequestableItem::create([
            'branch_id'=>1,
            'name'=>'EXTRA FITTED SHEET',
            'price'=>'20'
        ]);
    }
}
