<?php
date_default_timezone_set('Europe/Berlin');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Get currency data from JSON
$api_cg = json_decode(file_get_contents('coingecko.json'), true);

// Configuration file
$config = [];
if (file_exists('config.php')) {
    $config = require 'config.php';
}

$display_servers_guru = isset($config['servers_guru']) && $config['servers_guru'] === true;
$attribution = isset($config['attribution']) ? $config['attribution'] : '';
$preferred_currencies = isset($config['preferred_currencies']) ? $config['preferred_currencies'] : [];
$github_url = isset($config['github_url']) ? $config['github_url'] : 'https://github.com/rottenwheel/moner.ooo/';

// Extract the keys
$currencies = array_map('strtoupper', array_keys($api_cg));

// Fetch the time of the last API data update
$time_cg = date("H:i:s", $api_cg['time']);
$time = $time_cg;
unset($currencies[array_search('TIME', $currencies)]);

// Populate exchange rates
$exchangeRates = [];
foreach ($currencies as $currency) {
    $exchangeRates[$currency] = $api_cg[strtolower($currency)]['lastValue'];
}

// Get the browser language
$lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : "en";
if ($lang == 'zh' || $lang == 'pt') {
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
}

// Scan the lang/ directory for available language files
$langFiles = glob('lang/*.php');
$acceptLang = [];
foreach ($langFiles as $file) {
    $langCode = basename($file, '.php');
    $acceptLang[] = strtolower($langCode);
}

// Check if the browser language is available, otherwise use English
$lang = in_array($lang, $acceptLang) ? $lang : 'en';
$lang = strtolower($lang);
require_once "lang/{$lang}.php";

$xmr_in = isset($_GET["in"]) ? strtoupper(htmlspecialchars($_GET["in"])) : 'EUR';
$xmr_in_fiat = number_format($exchangeRates[$xmr_in], $xmr_in == 'BTC' || $xmr_in == 'LTC' || $xmr_in == 'ETH' || $xmr_in == 'XAG' || $xmr_in == 'XAU' ? 8 : 2);

$xmr_in_fiat = strtr($xmr_in_fiat, ",", " ");

// Order preferred currencies to the top
foreach (array_reverse($preferred_currencies) as $currency) {
    $currency = strtoupper($currency);
    if (($key = array_search($currency, $currencies)) !== false) {
        unset($currencies[$key]);
        array_unshift($currencies, $currency);
    }
}
?>

<!DOCTYPE html>
<html lang="<?php echo $lang_meta; ?>">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />

    <title lang="<?php echo $lang_meta; ?>"><?php echo $page_title; ?></title>
    <meta name="description" lang="<?php echo $lang_meta; ?>" content="<?php echo $meta_description; ?>" />
    <meta name="keywords" lang="<?php echo $lang_meta; ?>" content="<?php echo $meta_keywords; ?>" />

    <meta property="og:title" content="<?php echo $page_title; ?>" />
    <meta property="og:description" content="<?php echo $meta_description; ?>" />
    <meta property="og:image" content="img/mstile-310x150.png" />
    <meta property="og:type" content="website" />

    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="img/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="img/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="img/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="img/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="img/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-startup-image" href="img/favicon-196x196.png" />
    <link rel="icon" type="image/png" href="img/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="img/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="img/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="img/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="img/favicon-128.png" sizes="128x128" />
    <meta name="application-name" content="Moner.ooo" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="msapplication-TileImage" content="img/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="img/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="img/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="img/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="img/mstile-310x310.png" />
    <meta name="theme-color" content="#193e4c" />
    <meta name="apple-mobile-web-app-title" content="Moner.ooo" />
    <meta name="apple-mobile-web-app-status-bar-style" content="#193e4c" />

    <link href="css/main.css" rel="stylesheet" />
</head>

<body>
    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <div class="cursor-default text-center text-white">
                    <h1 lang="<?php echo $lang_meta; ?>"><span style="color:#4d4d4d;">&darr;</span>&nbsp;<span style="color:#ff6600;" title="Monero">XMR</span>&nbsp;<?php echo $title_h1; ?>&nbsp;<span style="color:#4d4d4d;">&darr;</span></h1>
                    <div class="fiat-btns table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <?php
                                $chunks = array_chunk($currencies, 10);
                                foreach ($chunks as $chunk) {
                                    echo "<tr>";
                                    foreach ($chunk as $currency) {
                                        $currencyName = isset(${"l_" . strtolower($currency)}) ? ${"l_" . strtolower($currency)} : $currency;
                                        echo "<td><a href=\"/?in={$currency}\" class=\"btn btn-light\" title=\"{$currencyName}\" data-toggle=\"tooltip\" data-bs-html=\"true\" data-placement=\"top\">{$currency}</a></td>";
                                    }
                                    echo "</tr>";
                                    echo "<tr style=\"display:none;\">";
                                    foreach ($chunk as $currency) {
                                        echo "<td>" . str_replace(".", ",", $exchangeRates[$currency]) . "</td>";
                                    }
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="gold" />

                <div class="input-group">
                    <button id="copyXMRBtn" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                    <input class="form-control" id="xmrInput" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_xmrInput; ?>" aria-describedby="basic-addon-xmr" value="1">
                    <input class="input-group-text" id="basic-addon-xmr" type="text" value="XMR" aria-label="Monero" disabled>
                </div>

                <div class="equals-box">
                    <span class="equals-text cursor-default">=</span>
                </div>

                <div class="fiatDiv input-group">
                    <button id="copyFiatBtn" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                    <input class="form-control" id="fiatInput" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_fiatInput; ?>" value="<?php echo $xmr_in_fiat; ?>">
                    <select class="input-group-text cursor-pointer" id="selectBox" aria-label="<?php echo $l_fiatSelect; ?>">
                        <?php
                        foreach ($currencies as $currency) {
                            $selected = $currency == $xmr_in ? 'selected' : '';
                            $currencyName = isset(${"l_" . strtolower($currency)}) ? ${"l_" . strtolower($currency)} : $currency;
                            echo "<option {$selected} value=\"{$currency}\">{$currencyName}</option>";
                        }
                        ?>
                    </select>
                </div>

                <hr class="gold" />
                <small class="cursor-default text-white text-info" lang="<?php echo $lang_meta; ?>">
                    <?php echo $info;
                    if ($display_servers_guru) {
                        echo $servers_guru;
                    };
                    echo $attribution; ?>
                </small>
                <hr />

                <?php
                $footer_links = "";

                if (isset($config['footer_links']) && !empty($config['footer_links'])) {
                    foreach ($config['footer_links'] as $link) {
                        $footer_links .= '<a href="' . $link['url'] . '" class="text-white" target="_blank" rel="noopener noreferrer">' . $link['text'] . '</a> | ';
                    }
                }
                ?>

                <small class="cursor-default text-white" lang="<?php echo $lang_meta; ?>">
                    <?php echo $footer_links . $getmonero . $countrymonero; ?>
                </small>
            </div>

        </div>
    </div>

    <script>
        var exchangeRates = <?php echo json_encode($exchangeRates); ?>;
    </script>
    <script src="js/main.js"></script>

</body>

</html>