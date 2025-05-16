<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class CurrencyController extends Controller
{
    public function convertCurrency(Request $request)
    {
        // Retrieve parameters from the request (using POST body)
        $baseCurrency = $request->input('base_currency', 'USD');
        $targetCurrency = $request->input('target_currency', 'EUR');
        $amount = $request->input('amount', 1);

        // Your API key and base URL
        $apiKey = env('CURRENCY_API_KEY');
        $baseUrl = 'https://v6.exchangerate-api.com/v6/';

        $client = new Client();

        try {
            // Make the API request to get exchange rates for the base currency
            $response = $client->get($baseUrl . $apiKey . '/latest/' . $baseCurrency);

            // Parse the response
            $data = json_decode($response->getBody()->getContents(), true);

            // Check if the response is successful
            if ($data['result'] === 'success') {
                // If the target currency exists in the response, perform the conversion
                if (isset($data['conversion_rates'][$targetCurrency])) {
                    $conversionRate = $data['conversion_rates'][$targetCurrency];
                    $convertedAmount = $amount * $conversionRate;

                    // Return the response
                    return response()->json([
                        'success' => true,
                        'base_currency' => $baseCurrency,
                        'target_currency' => $targetCurrency,
                        'amount' => $amount,
                        'converted_amount' => $convertedAmount,
                        'conversion_rate' => $conversionRate
                    ]);
                }

                return response()->json(['success' => false, 'message' => 'Invalid target currency.']);
            }

            return response()->json(['success' => false, 'message' => 'Unable to fetch rates from the API.']);
        } catch (\Exception $e) {
            // Handle errors (e.g., network issues, invalid API response)
            return response()->json(['success' => false, 'message' => 'Error occurred: ' . $e->getMessage()]);
        }
    }
}
