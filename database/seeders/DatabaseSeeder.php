<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Requester;
use App\Models\RequesterType;
use App\Models\User;
use App\Models\Variety;
use App\Models\VarietyType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        // Seed requester types
        $requesters = [
            ['id' => 1, 'label' => 'Public Seed Company'],
            ['id' => 2, 'label' => 'Public Research Institute'],
            ['id' => 3, 'label' => 'Private Seed Company'],
            ['id' => 4, 'label' => 'Farmers’ Cooperative'],
            ['id' => 5, 'label' => 'Others (precise)'],
        ];
        foreach ($requesters as $requester) {
            DB::table('requester_types')->updateOrInsert(
                ['id' => $requester['id']],
                ['label' => $requester['label']]
            );
        }
        // $ngo = RequesterType::create(['label' => 'NGO']);
        // $private = RequesterType::create(['label' => 'Private']);
        // $gov = RequesterType::create(['label' => 'Government']);

        // // Seed variety types
        // $breeder = VarietyType::create(['name' => 'Breeder']);
        // $foundation = VarietyType::create(['name' => 'Foundation']);

        // // Seed varieties
        // $variety1 = Variety::create(['name' => 'Nerica 1', 'variety_type_id' => $breeder->id]);
        // $variety2 = Variety::create(['name' => 'Nerica 4', 'variety_type_id' => $foundation->id]);
        // $variety3 = Variety::create(['name' => 'IR64', 'variety_type_id' => $breeder->id]);

        // // Seed requesters
        // $requester1 = Requester::create([
        //     'full_name' => 'Jean Koffi',
        //     'phone' => '0701234567',
        //     'email' => 'jean.koffi@example.com',
        //     'address' => 'Abidjan, CI',
        //     'requester_type_id' => $ngo->id,
        // ]);

        // // Seed orders
        // $order = Order::create([
        //     'requester_id' => $requester1->id,
        //     'seed_class' => 'AfricaRice',
        //     'total_quantity' => 0, // Calculé après
        //     'total_cost_usd' => 0, // Calculé après
        // ]);

        // // Seed order items
        // $items = [
        //     ['variety_id' => $variety1->id, 'quantity' => 10, 'cost' => 2.5],
        //     ['variety_id' => $variety2->id, 'quantity' => 5, 'cost' => 3.0],
        // ];

        // $totalQty = 0;
        // $totalCost = 0;

        // foreach ($items as $item) {
        //     $subtotal = $item['quantity'] * $item['cost'];
        //     OrderItem::create([
        //         'order_id' => $order->id,
        //         'variety_id' => $item['variety_id'],
        //         'quantity' => $item['quantity'],
        //         'cost_per_kg_usd' => $item['cost'],
        //         'subtotal_usd' => $subtotal,
        //     ]);
        //     $totalQty += $item['quantity'];
        //     $totalCost += $subtotal;
        // }
        // // Update totals
        // $order->update([
        //     'total_quantity' => $totalQty,
        //     'total_cost_usd' => $totalCost
        // ]);
    }
}
