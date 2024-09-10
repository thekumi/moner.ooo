<?php

// Set default timezone
date_default_timezone_set('Europe/Berlin');

// Define currencies that should *not* be included in the list
$excludedCurrencies = ['bits', 'sats'];

// Fetch the previously stored data
$previousData = json_decode(file_get_contents("coingecko.json"), true);
$output = $previousData;

$currentTime = time();

// Check if five seconds have passed since the last update
if (($currentTime - $previousData['time']) >= 5) {
    // Fetch the available currencies from CoinGecko API
    $availableCurrenciesApi = "https://api.coingecko.com/api/v3/simple/supported_vs_currencies";

    $currenciesCh = curl_init($availableCurrenciesApi);
    curl_setopt($currenciesCh, CURLOPT_RETURNTRANSFER, true);
    $availableCurrenciesJson = curl_exec($currenciesCh);

    $currenciesHttpCode = curl_getinfo($currenciesCh, CURLINFO_HTTP_CODE);

    curl_close($currenciesCh);

    if ($currenciesHttpCode == 200) {
        $availableCurrencies = json_decode($availableCurrenciesJson, true);
    } else {
        $availableCurrencies = array_keys($previousData);
        unset($availableCurrencies[array_search('time', $availableCurrencies)]);
    }

    // Remove excluded currencies
    $availableCurrencies = array_diff($availableCurrencies, $excludedCurrencies);

    $currencies = array_map('strtoupper', $availableCurrencies);

    // Fetch the latest data from CoinGecko API
    $apiUrl = 'https://api.coingecko.com/api/v3/simple/price?ids=monero&vs_currencies=' . implode('%2C', array_map('strtolower', $currencies)) . '&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true';

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // If the request worked and was not rate-limited
    if ($httpCode == 200) {
        // Decode the fetched data
        $fetchedData = json_decode($json, true);
        $moneroData = $fetchedData['monero'];
        
        // Initialize new data array
        $newData = ['time' => $currentTime];
        
        // Update the data for each currency
        foreach ($currencies as $currency) {
            $currencyLower = strtolower($currency);
            if (isset($moneroData[$currencyLower])) {
                $newData[$currencyLower] = [
                    'lastValue' => $moneroData[$currencyLower],
                    'lastDate' => $currentTime
                ];
            } else {
                $newData[$currencyLower] = [
                    'lastValue' => $previousData[$currencyLower]['lastValue'] ?? null,
                    'lastDate' => $previousData[$currencyLower]['lastDate'] ?? null
                ];
            }
        }
        
        // Save the new data to JSON files
        file_put_contents("coingecko.json", json_encode($newData, JSON_PRETTY_PRINT));
        file_put_contents("coingecko-original.json", json_encode($moneroData, JSON_PRETTY_PRINT));
        
        $output = $newData;
    } 
}

// Output the data
header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);