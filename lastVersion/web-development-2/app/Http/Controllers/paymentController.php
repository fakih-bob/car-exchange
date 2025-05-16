<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class paymentController extends Controller
{

    //using stripe
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $product = $request->input('product');
        $amount = $request->input('amount'); // in dollars
        $orderId = $request->input('order_id');
    
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product ?? 'Unnamed Product',
                        ],
                        'unit_amount' => 20000, // Convert dollars to cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('dashboard') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
                'metadata' => [
                    'order_id' => $orderId,
                ],
                // Enable Stripe's email collection form
                'customer_creation' => 'always',
            ]);
    
            return response()->json(['url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    


    public function paymentSuccess()
    {
        return view('success');
    }

    public function paymentCancel()
    {
        return view('cancel');
    }

    public function showPaymentPage(Request $request)
    {
        $orderId = $request->query('orderId');
    
        // Example: Fetch the order
        $order = Order::find($orderId);
    
        return view('pay', compact('order'));
    }
// coinbase payment for crypto

public function index()
{
    return view('cryptoPay');
}



public function makePayment(Request $request)
{
// Validate request input
$validated = $request->validate([
    'amount' => 'required|numeric',      // Amount to pay
    'currency' => 'required|string|size:3', // Currency code (e.g., USD, EUR)
]);

$apiKey = env('COINBASE_API_KEY');
$apiUrl = 'https://api.commerce.coinbase.com/charges';

if (!$apiKey) {
    return response()->json(['success' => false, 'message' => 'Coinbase API key is not configured.'], 500);
}

try {
    // Send request to Coinbase API with only price and currency
    $response = \Http::withHeaders([
        'X-CC-Api-Key' => $apiKey,
        'X-CC-Version' => '2018-03-22',
        'Content-Type' => 'application/json',
    ])
    // Optional: Uncomment if facing SSL issues
    // ->withOptions(['verify' => false])
    ->post($apiUrl, [
        'local_price' => [
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
        ],
        'pricing_type' => 'fixed_price',
    ]);

    if ($response->successful()) {
        // Extract the hosted URL from the response
        $data = $response->json();
        $hostedUrl = $data['data']['hosted_url']; // Get the hosted payment URL
        
        return response()->json([
            'success' => true,
            'hosted_url' => $hostedUrl  // Return only the hosted URL
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Failed to create charge.',
        'error' => $response->body()
    ], 500);

} catch (\Exception $e) {
    return response()->json([
        'success' => false,
        'message' => 'Exception occurred: ' . $e->getMessage()
    ], 500);
}
}

public function markAsPaidById($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json([
            'message' => 'Order not found.'
        ], 404);
    }

    $order->paid = true;
    $order->save();

    return response()->json([
        'message' => 'Order marked as paid successfully.',
        'order' => $order
    ]);
}

}
