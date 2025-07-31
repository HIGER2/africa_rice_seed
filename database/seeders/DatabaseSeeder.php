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
        $requesters = [
            ['label' => 'Public Seed Company'],
            ['label' => 'Public Research Institute'],
            ['label' => 'Private Seed Company'],
            ['label' => 'Farmers’ Cooperative'],
            ['label' => 'Others (precise)'],
        ];

        foreach ($requesters as $requester) {
            DB::table('requester_types')->updateOrInsert(
                ['label' => $requester['label']], // condition : on cherche par label
                ['label' => $requester['label']]  // valeur à insérer ou mettre à jour
            );
        }

        $types = [
            ['name' => 'Breeder seed', 'price_per_kg' => 8],
            ['name' => 'Foundation seed', 'price_per_kg' => 5],
            ['name' => 'Hybrid', 'price_per_kg' => 10],
        ];

        foreach ($types as $type) {
            DB::table('variety_types')->updateOrInsert(
                ['name' => $type['name']],      // condition (on vérifie si le nom existe déjà)
                ['price_per_kg' => $type['price_per_kg']]     // données à mettre à jour ou insérer
            );
        }


        $mails = [
            ['email' => 'C.Kacou@cgiar.org'],
            ['email' => 'S.Bah@cgiar.org'],
            ['email' => 'S.Ndindeng@cgiar.org'],
        ];

        foreach ($mails as $value) {
            DB::table('ccmails')->updateOrInsert(
                ['email' => $value['email']],    
                $value
            );
        }

        // $ngo = RequesterType::create(['label' => 'NGO']);
        // $private = RequesterType::create(['label' => 'Private']);
        // $gov = RequesterType::create(['label' => 'Government']);

        // // Seed variety types
        // $breeder = VarietyType::create(['name' => 'Breeder']);
        // $foundation = VarietyType::create(['name' => 'Foundation']);

        // Seed varieties
       

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
