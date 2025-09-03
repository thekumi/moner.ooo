<?php
date_default_timezone_set('UTC');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");

$currencyGroups = [
    ['EUR', 'USD', 'GBP', 'CHF', 'JPY', 'AUD', 'CAD', 'CNY', 'RUB', 'BRL'],
    ['CZK', 'DKK', 'NOK', 'SEK', 'PLN', 'HUF', 'TRY', 'ILS', 'GEL', 'UAH'],
    ['IDR', 'KRW', 'SGD', 'TWD', 'THB', 'VND', 'HKD', 'PHP', 'MYR', 'INR'],
    ['AED', 'SAR', 'BHD', 'KWD', 'ZAR', 'NGN', 'MMK', 'BDT', 'LKR', 'PKR'],
    ['ARS', 'CLP', 'MXN', 'VEF', 'BMD', 'NZD'],
    ['BTC', 'LTC', 'ETH', 'XAG', 'XAU']
];

// API-Daten mit Fehlerbehandlung laden
$apiContent = @file_get_contents('./api/coingecko.json');
if ($apiContent === false) die("Error reading API data");

$api_cg = json_decode($apiContent);
if ($api_cg === null) die("Error decoding JSON");

// Zeitstempel verarbeiten
$api_time = $api_cg->time;

// Währungskurse extrahieren
$currencies = [];
foreach ($api_cg as $key => $value) {
    if ($key !== 'time') $currencies[$key] = $value->lastValue;
}

// Sprachauswahl optimiert
$lang = 'en';
$availableLangs = require 'lang/available.php';

if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $fullLang = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
    
    // Spezialbehandlung für Sprachen
    if ($browserLang === 'zh' && str_contains($fullLang, 'zh-hant')) {
        $lang = 'zh-hant';
    } elseif ($browserLang === 'pt' && str_contains($fullLang, 'pt-br')) {
        $lang = 'pt-br';
    } elseif (isset($availableLangs[$browserLang])) {
        $lang = $browserLang;
    }
}

// Sprachdatei laden
$langFile = "lang/$lang.php";
if (!file_exists($langFile)) $langFile = 'lang/en.php';
$translations = require $langFile;

// Währungsumrechnung vorbereiten
$xmr_in = strtoupper($_GET["in"] ?? 'EUR');
$xmr_in_fiat_value = $currencies[strtolower($xmr_in)] ?? $currencies['eur'];

// XMR Stückelungen
$xmrDenominations = [
    'Piconero'  => 1e-12,
    'Nanonero'  => 1e-9,
    'Micronero' => 1e-6,
    'Millinero' => 1e-3,
    'Centinero' => 1e-2,
    'Decinero'  => 1e-1,
    'Monero'    => 1,
    'Decanero'  => 1e1,
    'Hectonero' => 1e2,
    'Kilonero'  => 1e3,
    'Meganero'  => 1e6,
];
?>
<!DOCTYPE html>
<html lang="<?= $translations['meta']['lang'] ?>" <?= $translations['meta']['rtl'] ? 'dir="rtl"' : '' ?>>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title><?= $translations['meta']['title'] ?></title>
    <meta name="description" content="<?= $translations['meta']['description'] ?>"/>
    
    <link rel="icon" href="images/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
    
    <link href="css/bootstrap/bootstrap.<?= $translations['meta']['rtl'] ? 'rtl.' : '' ?>min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/custom.css" media="all">
    
    <style>
        html {
            width: 100%;
            height: 100%;
            background-image: linear-gradient(to bottom right, #013c4a 0, #193e4c 44%, #004b5b 100%)!important;
            color: #fff;
            font-style: normal;
            background-attachment: fixed;
        }
        body {
            background-color: transparent;
        }
        table {
            --bs-table-bg: none!important;
        }
        .top-banner {
            background-color: #ffb876b3;
            width: 100%;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1000;
            text-transform: uppercase;
        }
        .top-banner a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            display: block;
            padding: 5px 15px;
        }
        .top-banner a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 5px;
        }
        .gold {
            border-color: #ff6600;
            opacity: 0.8;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .cursor-default {
            cursor: default;
        }
        .clipboard-copy {
            transition: all 0.3s ease;
        }
        .input-group-lg > .form-control,
        .input-group-lg > .form-select,
        .input-group-lg > .input-group-text,
        .input-group-lg > .btn {
            font-size: 32px;
        }
        input[type="text"] {
            spellcheck: false;
        }
        @media (max-width: 768px) {
            .input-group-lg > .form-control,
            .input-group-lg > .form-select,
            .input-group-lg > .input-group-text,
            .input-group-lg > .btn {
                font-size: 1.5rem;
                padding: 0.5rem;
            }
            .fiat-btns .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.85rem;
            }
        }
        .xmr-highlight {
            color: #ff6600;
        }
        .equals-box {
            margin: 1rem 0;
        }
        .equals-text {
            font-size: 2.5rem;
            color: #fff;
        }
        #xmrValueDisplayContainer {
            position: absolute;
            right: 0;
            width: auto;
            max-width: 250px;
        }
    </style>
</head>

<body>
    <div class="top-banner">
        <a href="/reto">RetoSwap</a>
    </div>
    
    <div class="container pt-4">
        <div class="row">           
            <div class="col-12">
                <div class="text-center text-white" style="position: relative;">
                    <h1>
                        <span style="color:#4d4d4d;">↓</span>
                        <span class="xmr-highlight" title="Monero">XMR</span>
                        <?= $translations['content']['title_h1'] ?>
                        <span style="color:#4d4d4d;">↓</span>
                    </h1>
                    
                    <div class="fiat-btns table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <?php foreach ($currencyGroups as $group): ?>
                                <tr>
                                    <?php foreach ($group as $currency): ?>
                                    <td>
                                        <button type="button" class="btn btn-light"
                                                data-currency="<?= $currency ?>"
                                                title="<?= htmlspecialchars($translations['currencies'][$currency]) ?>">
                                            <?= $currency ?>
                                        </button>
                                    </td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <hr class="gold">
                    
                    <!-- XMR Input Group -->
                    <div class="input-group input-group-lg my-3">
                        <button class="btn btn-outline-secondary clipboard-copy" type="button"
                            data-target="xmrInput">
                            &#128203;
                        </button>
                        <input type="text" class="form-control" id="xmrInput" value="1" 
                               spellcheck="false" autocorrect="off" inputmode="decimal"
                               aria-label="<?= $translations['form']['xmr_input'] ?>">
                        <select class="form-select cursor-pointer" id="xmrSelectBox">
                            <?php foreach ($xmrDenominations as $name => $value): ?>
                                <option value="<?= $value ?>" <?= $name === 'Monero' ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- XMR Value Display -->
                    <div class="input-group input-group-sm my-1 d-none" id="xmrValueDisplayContainer">
                        <button class="btn btn-outline-secondary clipboard-copy" type="button"
                            data-target="xmrValueDisplay">
                            &#128203;
                        </button>
                        <input type="text" class="form-control" id="xmrValueDisplay" disabled>
                        <span class="input-group-text">XMR</span>
                    </div>
                    
                    <div class="equals-box">
                        <span class="equals-text cursor-default">=</span>
                    </div>
                    
                    <!-- Fiat Input Group -->
                    <div class="input-group input-group-lg my-3">
                        <button class="btn btn-outline-secondary clipboard-copy" type="button"
                            data-target="fiatInput">
                            &#128203;
                        </button>
                        <input type="text" class="form-control" id="fiatInput" 
                               spellcheck="false" autocorrect="off" inputmode="decimal"
                               aria-label="<?= $translations['form']['fiat_input'] ?>">
                        <select class="form-select cursor-pointer" id="selectBox">
                            <?php foreach ($currencyGroups as $group): ?>
                                <?php foreach ($group as $currency): ?>
                                    <option value="<?= $currency ?>" <?= $currency === $xmr_in ? 'selected' : '' ?>>
                                        <?= $translations['currencies'][$currency] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <hr class="gold">
                    
                    <div class="mt-4" style="text-align:justify;">
                        <?= str_replace(':time', '<span id="api-time"></span>', $translations['footer']['info']) ?>
                        <div class="mt-2">
                            <?= implode(' | ', $translations['footer']['links']) ?>
                        </div>
                        <hr style="color:#ff6600;">
                        <div class="mt-2">
                            <?= implode(' | ', $translations['footer']['monero_links']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialisierung
        const allCurrencies = <?= json_encode($currencies) ?>;
        const initialFiatValue = <?= json_encode($xmr_in_fiat_value) ?>;
        const apiTimestamp = <?= $api_time ?>;
        const translations = <?= json_encode($translations) ?>;
        
        const elements = {
            xmrInput: document.getElementById('xmrInput'),
            fiatInput: document.getElementById('fiatInput'),
            xmrSelectBox: document.getElementById('xmrSelectBox'),
            selectBox: document.getElementById('selectBox'),
            xmrValueDisplay: document.getElementById('xmrValueDisplay'),
            xmrValueDisplayContainer: document.getElementById('xmrValueDisplayContainer')
        };
        
        // Tooltips initialisieren
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltips = tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        
        // Event Delegation für Währungsbuttons
        document.querySelector('.fiat-btns').addEventListener('click', function(e) {
            if (e.target.matches('button[data-currency]')) {
                elements.selectBox.value = e.target.dataset.currency;
                convert('fiat');
            }
        });
        
        // Event-Listener für Clipboard-Buttons
        document.querySelectorAll('.clipboard-copy').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.dataset.target;
                copyToClipboard(targetId, this);
            });
        });
        
        // Event-Listener für Eingabefelder
        elements.xmrInput.addEventListener('input', () => processInput(elements.xmrInput, true));
        elements.fiatInput.addEventListener('input', () => processInput(elements.fiatInput, false));
        
        // Event-Listener für Select-Boxen
        elements.xmrSelectBox.addEventListener('change', () => convert('xmr'));
        elements.selectBox.addEventListener('change', () => convert('fiat'));
        
        // Initiale Werte setzen
        elements.xmrInput.dataset.rawValue = '1';
        elements.fiatInput.dataset.rawValue = initialFiatValue;
        
        // Initiale Umrechnung
        convert('xmr');
        
        // API-Zeit anzeigen
        const apiDate = new Date(apiTimestamp * 1000);
        document.getElementById('api-time').textContent = apiDate.toLocaleTimeString();
        
        // Hilfsfunktionen
        function formatNumber(value, currency) {
            if (isNaN(value)) return "0";
            
            const options = {
                minimumFractionDigits: 0,
                maximumFractionDigits: 
                    currency === 'XMR' ? 12 : 
                    ['BTC', 'LTC', 'ETH'].includes(currency) ? 8 :
                    ['XAG', 'XAU'].includes(currency) ? 6 : 2
            };
            
            return new Intl.NumberFormat('de-DE', options).format(value);
        }
        
        function processInput(input, isXmrInput) {
            const cursorPos = input.selectionStart;
            const originalValue = input.value;
            
            // Bereinigung der Eingabe
            let cleanValue = input.value.replace(/[^\d,]/g, '');
            cleanValue = cleanValue.replace(',', '.');
            
            // Numerischen Wert speichern
            const numericValue = parseFloat(cleanValue) || 0;
            input.dataset.rawValue = numericValue;
            
            // Formatierte Anzeige
            const formattedValue = formatNumber(numericValue, isXmrInput ? 'XMR' : elements.selectBox.value);
            input.value = formattedValue;
            
            // Cursor-Position anpassen
            const diff = input.value.length - originalValue.length;
            input.setSelectionRange(cursorPos + diff, cursorPos + diff);
            
            // Umrechnung auslösen
            convert(isXmrInput ? 'xmr' : 'fiat');
        }
        
        function convert(direction) {
            const xmrValue = parseFloat(elements.xmrInput.dataset.rawValue);
            const fiatValue = parseFloat(elements.fiatInput.dataset.rawValue);
            const denomination = parseFloat(elements.xmrSelectBox.value);
            const currency = elements.selectBox.value;
            const rate = allCurrencies[currency.toLowerCase()] || 1;
            
            if (direction === 'xmr') {
                // XMR zu Fiat
                const totalXmr = xmrValue * denomination;
                const result = totalXmr * rate;
                
                elements.fiatInput.dataset.rawValue = result;
                elements.fiatInput.value = formatNumber(result, currency);
                
                // XMR Display aktualisieren
                updateXmrDisplay(totalXmr);
            } else {
                // Fiat zu XMR
                const totalXmr = fiatValue / rate;
                const result = totalXmr / denomination;
                
                elements.xmrInput.dataset.rawValue = result;
                elements.xmrInput.value = formatNumber(result, 'XMR');
                
                // XMR Display aktualisieren
                updateXmrDisplay(totalXmr);
            }
        }
        
        function updateXmrDisplay(totalXmr) {
            const denomination = parseFloat(elements.xmrSelectBox.value);
            
            if (denomination === 1) {
                elements.xmrValueDisplayContainer.classList.add('d-none');
            } else {
                elements.xmrValueDisplayContainer.classList.remove('d-none');
                elements.xmrValueDisplay.value = formatXmrValue(totalXmr);
                elements.xmrValueDisplay.dataset.rawValue = totalXmr;
            }
        }
        
        function formatXmrValue(value) {
            if (isNaN(value)) return "0";
            
            // Sehr kleine Werte behandeln
            if (value < 0.000001) {
                return value.toExponential(6).replace('e-', 'e-');
            }
            
            // Standard-Formatierung
            const [integerPart, decimalPart = ''] = value.toFixed(12).split('.');
            const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
            
            if (!decimalPart) return formattedInteger;
            
            // Dezimalteil formatieren
            const significantDecimals = decimalPart.replace(/0+$/, '');
            return significantDecimals ? 
                `${formattedInteger}.${significantDecimals}` : 
                formattedInteger;
        }
        
        async function copyToClipboard(elementId, button) {
            try {
                const element = document.getElementById(elementId);
                const rawValue = element.dataset.rawValue || element.value;
                const cleanValue = String(rawValue).replace(/\s/g, '');
                
                await navigator.clipboard.writeText(cleanValue);
                
                // Visuelles Feedback
                const originalHTML = button.innerHTML;
                button.innerHTML = '✓';
                
                setTimeout(() => {
                    button.innerHTML = originalHTML;
                }, 2000);
                
            } catch (err) {
                console.error('Copy failed:', err);
            }
        }
    });
    </script>
</body>
</html>