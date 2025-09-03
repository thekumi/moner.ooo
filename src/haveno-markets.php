<?php
//include('cg_api_key.php'); // Stellen Sie sicher, dass diese Datei existiert und zugänglich ist, falls benötigt.

$new_array = array();
// BTC war doppelt, habe es einmal entfernt. Wenn Sie es absichtlich doppelt haben, lassen Sie es.
$array = array("EUR", "BTC", "USD", "GBP", "CHF", "RUB", "CNY", "JPY", "IDR", "KRW", "TRY", "AUD", "BMD", "CAD", "HKD", "NZD", "SGD", "TWD", "ILS", "PLN", "ZAR", "CZK", "DKK", "NOK", "SEK", "ARS", "CLP", "PHP", "MXN", "BHD", "KWD", "BRL", "MYR", "VEF", "UAH", "VND", "BDT", "HUF", "MMK", "NGN", "THB", "AED", "SAR", "PKR", "LKR", "INR", "GEL", "LTC", "ETH", "XAG", "XAU");

// Setzt die Standard-Zeitzone, die verwendet werden soll.
date_default_timezone_set('Europe/Berlin');

// Holt den letzten Wert für die if Abfrage
$xmrdatas = json_decode(file_get_contents("haveno-markets.json"), true);

// Liefert den aktuellen Unix-Zeitstempel
$zeit = time();

// Sind ~5 Minuten vergangen? (300 Sekunden = 5 Minuten)
if (($zeit - ($xmrdatas['time'] ?? 0)) >= 300) { // Nutze ?? 0 für den ersten Durchlauf oder wenn 'time' fehlt
    // CURL initialisieren
    $ch = curl_init('https://haveno.markets/api/v1/tickers');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Daten speichern:
    $json = curl_exec($ch);

    // Fehlerbehandlung für cURL
    if (curl_errno($ch)) {
        // Hier können Sie Fehler protokollieren oder behandeln
        error_log('cURL-Fehler beim Abrufen der Haveno Markets API: ' . curl_error($ch));
        // Beenden oder Standardwerte beibehalten
        curl_close($ch);
        // Da der API-Aufruf fehlgeschlagen ist, behalten wir die alten Daten bei und brechen ab.
        // Sie können hier entscheiden, ob Sie die Seite dennoch anzeigen wollen
        // oder eine Fehlermeldung ausgeben.
        // Für den Zweck dieses Skripts, das in eine Datei schreibt, ist es am besten,
        // entweder die alten Daten zu behalten oder leere Daten zu schreiben,
        // wenn der Aufruf fehlschlägt.
        if (empty($xmrdatas)) {
            // Wenn es noch keine alten Daten gibt, initialisieren Sie new_array
            $new_array['time'] = $zeit;
            foreach ($array as $currencyCode) {
                $new_array[strtolower($currencyCode)]['lastValue'] = null;
                $new_array[strtolower($currencyCode)]['lastDate'] = null;
            }
            file_put_contents("haveno-markets.json", json_encode($new_array));
        }
        exit; // Skript beenden, da keine neuen Daten abgerufen werden konnten
    }

    curl_close($ch);

    // Die neue JSON-Struktur dekodieren
    $sort_array = json_decode($json, true);

    // Überprüfen, ob das JSON-Dekodieren erfolgreich war und Daten vorhanden sind
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($sort_array) || empty($sort_array)) {
        error_log('Fehler beim Dekodieren der Haveno Markets API JSON oder leere Antwort.');
        // Wenn ungültige Daten, behalten Sie die alten Daten bei
        // Oder initialisieren Sie new_array mit Nullen, wenn keine alten Daten vorhanden sind
        if (empty($xmrdatas)) {
            $new_array['time'] = $zeit;
            foreach ($array as $currencyCode) {
                $new_array[strtolower($currencyCode)]['lastValue'] = null;
                $new_array[strtolower($currencyCode)]['lastDate'] = null;
            }
            file_put_contents("haveno-markets.json", json_encode($new_array));
        }
        exit;
    }


    // new_array mit aktueller Zeit initialisieren
    $new_array['time'] = $zeit;

    // Wir iterieren durch die bekannten Währungen und versuchen, deren Preise zu finden.
    foreach ($array as $currencyCode) {
        // Währungscode in Kleinbuchstaben für den Schlüssel in $new_array
        $lowerCaseCurrencyCode = strtolower($currencyCode);
        // Währungscode in Großbuchstaben, um mit den Top-Level-Schlüsseln der API-Antwort zu matchen
        $upperCaseCurrencyCode = strtoupper($currencyCode);

        // Prüfen, ob der Währungscode direkt als Schlüssel in $sort_array existiert
        if (isset($sort_array[$upperCaseCurrencyCode]) && isset($sort_array[$upperCaseCurrencyCode]['last_price'])) {
            $new_array[$lowerCaseCurrencyCode]['lastValue'] = $sort_array[$upperCaseCurrencyCode]['last_price'];
            $new_array[$lowerCaseCurrencyCode]['lastDate'] = $zeit;
        } else {
            // Wenn in den NEUEN API-Daten nicht gefunden, auf die ALTEN Daten zurückgreifen (falls vorhanden)
            if (isset($xmrdatas[$lowerCaseCurrencyCode]['lastValue'])) {
                $new_array[$lowerCaseCurrencyCode]['lastValue'] = $xmrdatas[$lowerCaseCurrencyCode]['lastValue'];
                $new_array[$lowerCaseCurrencyCode]['lastDate'] = $xmrdatas[$lowerCaseCurrencyCode]['lastDate'];
            } else {
                // Wenn weder neue noch alte Daten verfügbar sind, auf null setzen
                $new_array[$lowerCaseCurrencyCode]['lastValue'] = null;
                $new_array[$lowerCaseCurrencyCode]['lastDate'] = null;
            }
        }
    }

    // new_array in haveno-markets.json speichern
    file_put_contents("haveno-markets.json", json_encode($new_array, JSON_PRETTY_PRINT)); // JSON_PRETTY_PRINT für bessere Lesbarkeit

    // Für haveno-markets-original.json speichern wir die rohe abgerufene Daten.
    file_put_contents("haveno-markets-original.json", json_encode($sort_array, JSON_PRETTY_PRINT)); // JSON_PRETTY_PRINT für bessere Lesbarkeit
}
?>