<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Product;
use App\Models\Slot;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'info@ntoufoudis.com',
        ]);

        // Create Products
        Product::create([
            'name' => 'Cheetos Cheese',
            'image' => '01JP2D3Y7E2RP55QTNFFG9VDB3.png',
        ]);

        Product::create([
            'name' => 'Cheetos Flamin\' Hot Limon',
            'image' => '01JP2D55DMT9E57VQ818AMXKCN.png',
        ]);

        Product::create([
            'name' => 'Cheetos Flamin\' Hot Cheese',
            'image' => '01JP2D6YTKV49HE62P4B1ZTKBV.png',
        ]);

        Product::create([
            'name' => 'Cheetos XXTRA Flamin\' Hot',
            'image' => '01JP2D83GA44MSNZMVVTH1QH3M.png',
        ]);

        Product::create([
            'name' => 'Cheetos Jalapeno',
            'image' => '01JP2D8VFYBZ16YBQ9Q17F3ZWN.png',
        ]);

        $machines = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        foreach ($machines as $machine) {
            $machine = Machine::create([
                'name' => 'Machine #' . $machine,
            ]);

            Slot::create([
                'name' => 'Slot #1',
                'machine_id' => $machine->id,
                'product_id' => 1,
                'price' => 1.00,
            ]);
            Slot::create([
                'name' => 'Slot #2',
                'machine_id' => $machine->id,
                'product_id' => 1,
                'price' => 1.50,
            ]);
            Slot::create([
                'name' => 'Slot #3',
                'machine_id' => $machine->id,
                'product_id' => 2,
                'price' => 1.00,
            ]);
            Slot::create([
                'name' => 'Slot #4',
                'machine_id' => $machine->id,
                'product_id' => 2,
                'price' => 3.50,
            ]);
            Slot::create([
                'name' => 'Slot #5',
                'machine_id' => $machine->id,
                'product_id' => 3,
                'price' => 3.00,
            ]);
            Slot::create([
                'name' => 'Slot #6',
                'machine_id' => $machine->id,
                'product_id' => 3,
                'price' => 4.00,
            ]);
            Slot::create([
                'name' => 'Slot #7',
                'machine_id' => $machine->id,
                'product_id' => 4,
                'price' => 1.00,
            ]);
            Slot::create([
                'name' => 'Slot #8',
                'machine_id' => $machine->id,
                'product_id' => 4,
                'price' => 4.00,
            ]);
            Slot::create([
                'name' => 'Slot #9',
                'machine_id' => $machine->id,
                'product_id' => 5,
                'price' => 1.00,
            ]);
            Slot::create([
                'name' => 'Slot #10',
                'machine_id' => $machine->id,
                'product_id' => 5,
                'price' => 1.80,
            ]);
        }
    }
}
