<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Requester;
use App\Models\RequesterType;
use App\Models\Variety;
use App\Models\VarietyType;
use App\Notifications\RequesterConfirmationNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class AppController extends Controller
{
    
    public function index(): Response
    {
        return Inertia::render('Home', [
            'requesterType' => RequesterType::get(),
            'variety'=> VarietyType::get()
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order.seed_class' => 'required|in:AfricaRice_Mandated_Seed_Classes,Certified_Seed',
            'order.total_quantity' => 'required|integer|min:1',
            'order.total_cost' => 'required|numeric|min:0',
            'user.full_name' => 'required|string',
            'user.gender' => 'required|string',
            'user.company' => 'required|string',
            'user.phone' => 'nullable|string',
            'user.email' => 'nullable|email',
            'user.address' => 'nullable|string',
            'user.requester_type_id' => 'required',
            // 'user.requester_type_id' => 'nullable|exists:requester_type_id,id',
            'user.custom_requester_type' => 'nullable|string',
            'order_items' => 'required|array|min:1',
            'order_items.*.name' => 'required|string',
            'order_items.*.quantity' => 'required|integer|min:1',
            'order_items.*.cost_per_kg' => 'required|numeric|min:0',
            'order_items.*.subtotal' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Créer le requester
            $requester = Requester::firstOrCreate(
                [
                    'email' => $request->user['email'] ?? null
                ],
                $data['user']);

            // Créer la commande
            $order = $data['order'];
            $order['requester_id'] = $requester->id;
            $order['date'] = Carbon::now()->toDateString(); // Format : YYYY-MM-DD
            $order['date_delivery'] = Carbon::now()->addMonths(6)->toDateString(); // Ajoute 6 mois
            $order['requester_id'] = $requester->id;
            $order = Order::create($order);

            // Créer les articles de la commande
            foreach ($data['order_items'] as $item) {
                $item['requester_id'] = $requester->id;
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }   

            $order->load(['orderItems', 'requester']);

            DB::commit();

            $requester->notify(new RequesterConfirmationNotification($order));
            return response()->json(['message' => 'Commande créée avec succès.', 'order' => $order], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Erreur serveur.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function email(): Mixed
    {
            $order = Order::first();

            // var_dump($order['order_items']);
        $order->load(['orderItems', 'requester']);
        return view('emails.order-notification', ['order' => $order]);
    }
}
