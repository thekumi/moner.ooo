<?php
date_default_timezone_set('Europe/Berlin');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$array = array("EUR",
	"USD",
	"GBP",
	"CHF",
	"RUB",
	"CNY",
	"TRY",
	"AUD",
	"CAD",
	"NZD",
	"PLN",
	"CZK",
	"SEK",
	"PHP",
	"BRL",
	"THB",
	"INR",
	"GEL",
	"BTC",
	"LTC",
	"ETH");

include('haveno-markets.php');

// Holt die API Daten
$api_hm = json_decode(file_get_contents('haveno-markets.json'));

// Holt die Zeit der letzten Abfrage
$time_hm = date("H:i:s", $api_hm->time);
$time = $time_hm;

// Holt die einzelnen Werte für die Berechnung
$BTC = $api_hm->btc->lastValue;
$EUR = $api_hm->eur->lastValue;
$USD = $api_hm->usd->lastValue;
$CHF = $api_hm->chf->lastValue;
$LTC = $api_hm->ltc->lastValue;
$CAD = $api_hm->cad->lastValue;
$AUD = $api_hm->aud->lastValue;
$GBP = $api_hm->gbp->lastValue;
$RUB = $api_hm->rub->lastValue;
$TRY = $api_hm->try->lastValue;
$PLN = $api_hm->pln->lastValue;
$INR = $api_hm->inr->lastValue;
$ETH = $api_hm->eth->lastValue;
$BRL = $api_hm->brl->lastValue;
$CNY = $api_hm->cny->lastValue;
$THB = $api_hm->thb->lastValue;
$SEK = $api_hm->sek->lastValue;
$NZD = $api_hm->nzd->lastValue;
$PHP = $api_hm->php->lastValue;
$CZK = $api_hm->czk->lastValue;

// Lädt die Sprachdatei, nach der Sprache die im Browser eingestellt wurde
if(array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)){
    $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
}else{
    $lang = "en";
}
// https://www.alchemysoftware.com/livedocs/ezscript/Topics/Catalyst/Language.htm
if($lang == 'zh' || $lang == 'pt'){
	$relang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
        if(substr($relang, 2, 1) == '-'){
                if($relang == 'zh-Hans' || 'zh-CN' || 'zh-SG'){
                        $lang = 'zh';
                }elseif($relang == 'zh-Hant' || 'zh-HK' || 'zh-MO' || 'zh-TW'){
                        $lang = 'zh-Hant';
                }elseif($relang == 'pt-BR'){
                        $lang = 'pt';
                }
        }
}

$acceptLang = ['de','es','it','zh','zh-Hant','nl','pl','el','pt','ru','cs','fa','tr','fr','da','ar','ta'];
$lang = in_array($lang, $acceptLang) ? $lang : 'en';
$lang = strtolower($lang);
require_once "lang/{$lang}.php"; 

if(isset($_GET["in"])) {
    $xmr_in = strtoupper(htmlspecialchars($_GET["in"]));

    if($xmr_in == 'USD'){
        $xmr_in_fiat = number_format($USD, 2);
    }elseif($xmr_in == 'GBP'){
        $xmr_in_fiat = number_format($GBP, 2);
    }elseif($xmr_in == 'CHF'){
        $xmr_in_fiat = number_format($CHF, 2);
    }elseif($xmr_in == 'RUB'){
        $xmr_in_fiat = number_format($RUB, 2);
    }elseif($xmr_in == 'CNY'){
        $xmr_in_fiat = number_format($CNY, 2);
    }elseif($xmr_in == 'AUD'){
        $xmr_in_fiat = number_format($AUD, 2);
    }elseif($xmr_in == 'CAD'){
        $xmr_in_fiat = number_format($CAD, 2);
    }elseif($xmr_in == 'NZD'){
        $xmr_in_fiat = number_format($NZD, 2);
    }elseif($xmr_in == 'CZK'){
        $xmr_in_fiat = number_format($CZK, 2);
    }elseif($xmr_in == 'PLN'){
        $xmr_in_fiat = number_format($PLN, 2);
    }elseif($xmr_in == 'SEK'){
        $xmr_in_fiat = number_format($SEK, 2);
    }elseif($xmr_in == 'TRY'){
        $xmr_in_fiat = number_format($TRY, 2);
    }elseif($xmr_in == 'PHP'){
        $xmr_in_fiat = number_format($PHP, 2);
    }elseif($xmr_in == 'BRL'){
        $xmr_in_fiat = number_format($BRL, 2);
    }elseif($xmr_in == 'THB'){
        $xmr_in_fiat = number_format($THB, 2);
    }elseif($xmr_in == 'INR'){
        $xmr_in_fiat = number_format($INR, 2);
    }elseif($xmr_in == 'BTC'){
        $xmr_in_fiat = number_format($BTC, 8);
    }elseif($xmr_in == 'LTC'){
        $xmr_in_fiat = number_format($LTC, 8);
    }elseif($xmr_in == 'ETH'){
        $xmr_in_fiat = number_format($ETH, 8);
    }else{
        $xmr_in_fiat = number_format($EUR, 2);
    }

}else{
    $xmr_in_fiat = number_format($EUR, 2);
}

$xmr_in_fiat = strtr($xmr_in_fiat, ",", " ");
?>
<!DOCTYPE html>
<html lang="<?php echo $lang_meta; ?>"<?php if($rtl == 'true'){echo ' dir="rtl"';} ?>>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="true" /> 
    <meta name="MobileOptimized" content="320" /> 
    
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>"/>
    <meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
    
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
    </style>

    <link href="css/custom.css" rel="stylesheet" />
</head>

<body>
	<div class="top-banner">
		<a href="/"><span>CoinGecko</span></a>
    </div>
    <div class="container pt-4">
        <div class="row">            
            <div class="col-12">
                <div class="cursor-default text-center text-white">
                    <h1><span style="color:#4d4d4d;">&darr;</span>&nbsp;<span style="color:#ff6600;" title="Monero">XMR</span>&nbsp;<?php echo $title_h1; ?>&nbsp;<span style="color:#4d4d4d;">&darr;</span></h1>
                    <div class="fiat-btns table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto'><b><?php echo $l_eur; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">EUR</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=USD'><b><?php echo $l_usd; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">USD</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=GBP'><b><?php echo $l_gbp; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">GBP</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=CHF'><b><?php echo $l_chf; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">CHF</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=RUB'><b><?php echo $l_rub; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">RUB</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=CNY'><b><?php echo $l_cny; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">CNY</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=TRY'><b><?php echo $l_try; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">TRY</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=AUD'><b><?php echo $l_aud; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">AUD</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=CAD'><b><?php echo $l_cad; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">CAD</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=NZD'><b><?php echo $l_nzd; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">NZD</button></td>
                                </tr>
                                <tr style="display:none;">
                                    <td><?php echo str_replace(".", ",", $EUR); ?></td>
                                    <td><?php echo str_replace(".", ",", $USD); ?></td>
                                    <td><?php echo str_replace(".", ",", $GBP); ?></td>
                                    <td><?php echo str_replace(".", ",", $CHF); ?></td>
                                    <td><?php echo str_replace(".", ",", $RUB); ?></td>
                                    <td><?php echo str_replace(".", ",", $CNY); ?></td>
                                    <td><?php echo str_replace(".", ",", $TRY); ?></td>
                                    <td><?php echo str_replace(".", ",", $AUD); ?></td>
                                    <td><?php echo str_replace(".", ",", $CAD); ?></td>
                                    <td><?php echo str_replace(".", ",", $NZD); ?></td>
                                </tr>
                                <tr>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=PLN'><b><?php echo $l_pln; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">PLN</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=CZK'><b><?php echo $l_czk; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">CZK</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=SEK'><b><?php echo $l_sek; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">SEK</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=PHP'><b><?php echo $l_php; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">PHP</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=BRL'><b><?php echo $l_brl; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">BRL</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=THB'><b><?php echo $l_thb; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">THB</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=INR'><b><?php echo $l_inr; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">INR</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=BTC'><b><?php echo $l_btc; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">BTC</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=LTC'><b><?php echo $l_ltc; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">LTC</button></td>
                                    <td><button type="button" class="btn btn-light" title="<a class='text-decoration-none fiat-tooltip' href='/reto?in=ETH'><b><?php echo $l_eth; ?></b></a>" data-toggle="tooltip" data-bs-html="true" data-placement="top">ETH</button></td>
                                </tr>
                                <tr style="display:none;">
                                    <td><?php echo str_replace(".", ",", $PLN); ?></td>
                                    <td><?php echo str_replace(".", ",", $CZK); ?></td>
                                    <td><?php echo str_replace(".", ",", $SEK); ?></td>
                                    <td><?php echo str_replace(".", ",", $PHP); ?></td>
                                    <td><?php echo str_replace(".", ",", $BRL); ?></td>
                                    <td><?php echo str_replace(".", ",", $THB); ?></td>
                                    <td><?php echo str_replace(".", ",", $INR); ?></td>
                                    <td><?php echo str_replace(".", ",", $BTC); ?></td>
                                    <td><?php echo str_replace(".", ",", $LTC); ?></td>
                                    <td><?php echo str_replace(".", ",", $ETH); ?></td>
                                </tr>
				<tr style="display:none;">
                                    <td colspan="7"><?php echo $moneroooTable; ?></td>
                                    <td>Unix Time:</td>
				    <td colspan="2"><?php echo $api_hm->time; ?></td>
				</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="gold" />
                
                <div class="input-group">
                    <button onclick="copyToClipBoardXMR()" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                    <input class="form-control" id="xmrInput" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_xmrInput; ?>" aria-describedby="basic-addon-xmr" value="1" onchange="xmrConvert(this.value)" onkeyup="this.value = this.value.replace(/[^\.^,\d]/g, ''); this.value = this.value.replace(/\,/, '.'); if(this.value.split('.').length > 2){this.value = this.value.slice(0, -1);} xmrConvert(this.value)">
                    <input class="input-group-text" id="basic-addon-xmr" type="text" value="XMR" aria-label="Monero" disabled>
                </div>
                
                <div class="equals-box">
                    <span class="equals-text cursor-default">=</span>
                </div>
                
                <div class="fiatDiv input-group">
                    <button onclick="copyToClipBoardFiat()" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                    <input class="form-control" id="fiatInput" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_fiatInput; ?>" value="<?php echo $xmr_in_fiat; ?>" onchange="fiatConvert(this.value)" onkeyup="this.value = this.value.replace(/[^\.^,\d]/g, ''); this.value = this.value.replace(/\,/, '.'); if(this.value.split('.').length > 2){this.value = this.value.slice(0, -1);} fiatConvert(this.value)">
                    <select class="input-group-text cursor-pointer" id="selectBox" onchange="xmrConvert(this.value)" aria-label="<?php echo $l_fiatSelect; ?>">
                        <?php
                        if(isset($xmr_in)){
                            echo '<option value="'.$xmr_in.'">'.$xmr_in.'</option>';
                        }
                        ?>
                        <option value="EUR" label="<?php echo $l_eur; ?>">EUR</option>
                        <option value="USD" label="<?php echo $l_usd; ?>">USD</option>
                        <option value="GBP" label="<?php echo $l_gbp; ?>">GBP</option>
                        <option value="CHF" label="<?php echo $l_chf; ?>">CHF</option>
                        <option value="RUB" label="<?php echo $l_rub; ?>">RUB</option>
                        <option value="CNY" label="<?php echo $l_cny; ?>">CNY</option>
                        <option value="JPY" label="<?php echo $l_jpy; ?>">JPY</option>
                        <option value="TRY" label="<?php echo $l_try; ?>">TRY</option>
                        <option value="AUD" label="<?php echo $l_aud; ?>">AUD</option>
                        <option value="CAD" label="<?php echo $l_cad; ?>">CAD</option>
                        <option value="NZD" label="<?php echo $l_nzd; ?>">NZD</option>
                        <option value="PLN" label="<?php echo $l_pln; ?>">PLN</option>
                        <option value="CZK" label="<?php echo $l_czk; ?>">CZK</option>
                        <option value="SEK" label="<?php echo $l_sek; ?>">SEK</option>
                        <option value="PHP" label="<?php echo $l_php; ?>">PHP</option>
                        <option value="BRL" label="<?php echo $l_brl; ?>">BRL</option>
                        <option value="THB" label="<?php echo $l_thb; ?>">THB</option>
                        <option value="INR" label="<?php echo $l_inr; ?>">INR</option>
                        <option value="BTC" label="<?php echo $l_btc; ?>">BTC</option>
                        <option value="LTC" label="<?php echo $l_ltc; ?>">LTC</option>
                        <option value="ETH" label="<?php echo $l_eth; ?>">ETH</option>
                    </select>
                </div>
                
                <hr class="gold" />
                <small class="cursor-default text-white text-info">
                    <?php echo $info; ?>
                </small>
                <hr />
                <small class="cursor-default text-white">
                    <?php echo $getmonero."&nbsp;".$countrymonero; ?>
                </small>
            </div>
            
        </div>
    </div>


<script type="text/javascript">
    function fiatConvert(value)
    {
        let fiatAmount = document.getElementById("fiatInput").value;
        let xmrValue = document.getElementById("xmrInput");
        let selectBox = document.getElementById("selectBox").value;

        if (selectBox == "BTC") {
                let value = fiatAmount / <?php echo $BTC; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "EUR") {
                let value = fiatAmount / <?php echo $EUR; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "USD") {
                let value = fiatAmount / <?php echo $USD; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "CHF") {
                let value = fiatAmount / <?php echo $CHF; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "LTC") {
                let value = fiatAmount / <?php echo $LTC; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "CAD") {
                let value = fiatAmount / <?php echo $CAD; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "AUD") {
                let value = fiatAmount / <?php echo $AUD; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "GBP") {
                let value = fiatAmount / <?php echo $GBP; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "RUB") {
                let value = fiatAmount / <?php echo $RUB; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "TRY") {
                let value = fiatAmount / <?php echo $TRY; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "PLN") {
                let value = fiatAmount / <?php echo $PLN; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "INR") {
                let value = fiatAmount / <?php echo $INR; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "ETH") {
                let value = fiatAmount / <?php echo $ETH; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "BRL") {
                let value = fiatAmount / <?php echo $BRL; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "CNY") {
                let value = fiatAmount / <?php echo $CNY; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "THB") {
                let value = fiatAmount / <?php echo $THB; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "SEK") {
                let value = fiatAmount / <?php echo $SEK; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "NZD") {
                let value = fiatAmount / <?php echo $NZD; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "PHP") {
                let value = fiatAmount / <?php echo $PHP; ?>;
                xmrValue.value = value.toFixed(12);
        } else if (selectBox == "CZK") {
                let value = fiatAmount / <?php echo $CZK; ?>;
                xmrValue.value = value.toFixed(12);
        }
    }
</script>

<script type="text/javascript">
    function xmrConvert(value)
    {
        let xmrAmount = document.getElementById("xmrInput").value;
        let fiatValue = document.getElementById("fiatInput");
        let selectBox = document.getElementById("selectBox").value;

        if (selectBox == "BTC") {
                let value = xmrAmount * <?php echo $BTC; ?>;
                fiatValue.value = value.toFixed(8);
        } else if (selectBox == "EUR") {
                let value = xmrAmount * <?php echo $EUR; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "USD") {
                let value = xmrAmount * <?php echo $USD; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "CHF") {
                let value = xmrAmount * <?php echo $CHF; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "LTC") {
                let value = xmrAmount * <?php echo $LTC; ?>;
                fiatValue.value = value.toFixed(8);
        } else if (selectBox == "CAD") {
                let value = xmrAmount * <?php echo $CAD; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "AUD") {
                let value = xmrAmount * <?php echo $AUD; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "GBP") {
                let value = xmrAmount * <?php echo $GBP; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "RUB") {
                let value = xmrAmount * <?php echo $RUB; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "TRY") {
                let value = xmrAmount * <?php echo $TRY; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "PLN") {
                let value = xmrAmount * <?php echo $PLN; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "INR") {
                let value = xmrAmount * <?php echo $INR; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "ETH") {
                let value = xmrAmount * <?php echo $ETH; ?>;
                fiatValue.value = value.toFixed(8);
        } else if (selectBox == "BRL") {
                let value = xmrAmount * <?php echo $BRL; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "CNY") {
                let value = xmrAmount * <?php echo $CNY; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "THB") {
                let value = xmrAmount * <?php echo $THB; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "SEK") {
                let value = xmrAmount * <?php echo $SEK; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "NZD") {
                let value = xmrAmount * <?php echo $NZD; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "PHP") {
                let value = xmrAmount * <?php echo $PHP; ?>;
                fiatValue.value = value.toFixed(2);
        } else if (selectBox == "CZK") {
                let value = xmrAmount * <?php echo $CZK; ?>;
                fiatValue.value = value.toFixed(2);
        }
    }
</script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
    function copyToClipBoardXMR() {
        var content = document.getElementById('xmrInput');
        content.select();
        document.execCommand('copy');
    }

    function copyToClipBoardFiat() {
        var content = document.getElementById('fiatInput');
        content.select();
        document.execCommand('copy');
    }
		
	document.addEventListener('DOMContentLoaded', () => {
    const allLinks = document.querySelectorAll('a');

    allLinks.forEach(link => {
        // Prüfe, ob der 'href'-Wert des Links mit 'https://www.coingecko.com/' beginnt
        if (link.href.startsWith('https://www.coingecko.com/')) {
            // Ändere den 'href'-Attributwert
            link.href = 'https://haveno.markets/';

            // Ändere den sichtbaren Text des Links
            link.textContent = 'Haveno Markets';

            // Setze das 'hreflang'-Attribut auf 'en'
            link.setAttribute('hreflang', 'en');
        }
    });
});
    </script>
</body>
</html>
