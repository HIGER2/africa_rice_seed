<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Détails de la commande / Order Details</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f9f9f9; padding:15px; color:#333; font-size:14px; line-height:1.4;">
        
    <div style="max-width:700px; margin:auto; background:#fff; padding:15px 20px; border-radius:6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        {{-- <div style="text-align: center; margin-bottom: 20px;">
            <img src="{{ asset('images/logo.webp') }}" alt="Logo" style="max-height: 40px;">
        </div> --}}
        <!-- Message bilingue -->
        <p style="margin-bottom:8px;">Bonjour <strong>{{ $order->requester->full_name }}</strong>,</p>
        <p style="margin-top:0; margin-bottom:12px; font-size:13px; color:#555;">
            Votre commande a été enregistrée avec succès.<br>Merci de votre confiance.
        </p>
        {{-- <p style="margin-top:0; margin-bottom:15px;">Cdt,<br><strong>AfricaRice</strong></p> --}}

        <hr style="border:none; border-top:1px solid #ddd; margin:25px 0;" />

        <p style="margin-bottom:8px;">Hello <strong>{{ $order->requester->full_name }}</strong>,</p>
        <p style="margin-top:0; margin-bottom:12px; font-size:13px; color:#555;">
            Your order has been successfully placed.<br>Thank you for your trust.
        </p>
        {{-- <p style="margin-top:0; margin-bottom:25px;">Regards,<br><strong>AfricaRice</strong></p> --}}

        <h2 style="font-size:18px; margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:5px;">
           Général informations / General information
        </h2>

        <p><strong>Nom / Name :</strong> {{ $order->requester->full_name ?? '—' }}</p>
        <p><strong>Email :</strong> {{ $order->requester->email ?? '—' }}</p>
        <p><strong>Genre / Gender :</strong> {{ $order->requester->gender ?? '—' }}</p>
        <p><strong>Téléphone / Phone :</strong> {{ $order->requester->phone ?? '—' }}</p>
        <p><strong>Compagnie / Company :</strong> {{ $order->requester->company ?? '—' }}</p>
        <p><strong>Adresse / Address :</strong> {{ $order->requester->address ?? '—' }}</p>
        <p><strong>Type de demandeur / Requester Type :</strong> 
        {{ $order->requester->requester_type_id == 5 
        ? ($order->requester->custom_requester_type ?? '—') 
        : ($order->requester->requesterType->label ?? '—') }}</p>


         <h2 style="font-size:18px; margin-bottom:15px; border-bottom:1px solid #ddd; padding-bottom:5px;">
            Détails de la commande #{{ $order['id'] }} / Order Details #{{ $order['id'] }}
        </h2>

        <p><strong>Classe de semence / Seed class :</strong> {{ $order['seed_class'] }}</p>
        <p><strong>Quantité totale / Total quantity :</strong> {{ $order['total_quantity'] }}</p>
        <p><strong>Coût total / Total cost :</strong> {{ number_format($order['total_cost'], 2) }} FCFA</p>
        <p><strong>Date création / Created at :</strong> {{ \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i') }}</p>
        <p><strong>Date livraison / Delivery date :</strong> {{ \Carbon\Carbon::parse($order['date_delivery'])->format('d/m/Y') }}</p>
        {{-- <p style="margin-bottom:20px;"><strong>Dernière mise à jour / Updated at :</strong> {{ \Carbon\Carbon::parse($order['updated_at'])->format('d/m/Y H:i') }}</p> --}}

        <h3 style="font-size:16px; margin-bottom:10px;">Articles commandés / Ordered Items</h3>
        <table width="100%" style="border-collapse: collapse; border: 1px solid #ddd; font-size:13px;">
            <thead>
                <tr style="background:#f7f7f7;">
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align:left;">Nom / Name</th>
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">Quantité / Quantity</th>
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">Prix/kg / Cost per kg (FCFA)</th>
                    <th style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">Sous-total / Subtotal (FCFA)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order['orderItems'] as $item)
                <tr>
                    <td style="padding: 6px 8px; border: 1px solid #ddd;">{{ $item['name'] }}</td>
                    <td style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">{{ $item['quantity'] }}</td>
                    <td style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">{{ number_format($item['cost_per_kg'], 2) }}</td>
                    <td style="padding: 6px 8px; border: 1px solid #ddd; text-align:right;">{{ number_format($item['subtotal'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p style="margin-top: 20px; font-weight: bold; font-size: 15px;">
            Montant total / Total amount : {{ number_format($order['total_cost'], 2) }} FCFA
        </p>

        <p style="margin-top:0; margin-bottom:15px;">Cdt /  regards,<br><strong>AfricaRice</strong></p>

        <!-- (optionnel) ligne de séparation -->
        <hr style="border:none; border-top:1px solid #ccc; margin:25px 0;" />

        <!-- Footer -->
        <p style="font-size: 12px; color: #888;">
            © 2025 AfricaRice. Tous droits réservés.
        </p>
    </div>
</body>
</html>
