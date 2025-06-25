<!DOCTYPE html>
<html lang="<?php echo $lang_meta; ?>" <?php if ($rtl) {
                                            echo 'dir="rtl"';
                                        } ?>>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="true" />
    <meta name="MobileOptimized" content="320" />

    <title><?php echo $page_title; ?></title>
    <meta name="description" lang="<?php echo $lang_meta; ?>" content="<?php echo $meta_description; ?>" />
    <meta name="keywords" lang="<?php echo $lang_meta; ?>" content="<?php echo $meta_keywords; ?>" />

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
                                        echo "<td><a href=\"/?in={$currency}\" class=\"btn btn-light fiat-btn\" title=\"{$currencyName}\" data-toggle=\"tooltip\" data-bs-html=\"true\" data-placement=\"top\">{$currency}</a></td>";
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

                <form method="get" action="">
                    <div class="input-group mb-3">
                        <button id="copyXMRBtn" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                        <input class="form-control" id="xmrInput" name="xmr" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_xmrInput; ?>" aria-describedby="basic-addon-xmr" value="<?php echo $xmr_value; ?>">
                        <input class="input-group-text" id="basic-addon-xmr" type="text" value="XMR" aria-label="Monero" disabled>
                    </div>

                    <div class="equals-box mb-3">
                        <button id="convertXMRToFiat" type="submit" name="direction" value="0" class="btn btn-arrow">
                            <span class="equals-text">&darr;</span>
                        </button>
                        <button type="button" class="btn btn-equals">
                            <span class="equals-text cursor-default">=</span>
                        </button>
                        <button id="convertFiatToXMR" type="submit" name="direction" value="1" class="btn btn-arrow">
                            <span class="equals-text">&uarr;</span>
                        </button>
                    </div>

                    <div class="fiatDiv input-group mb-3">
                        <button id="copyFiatBtn" class="btn-outline-secondary input-group-text clipboard-copy" title="<?php echo $clipboard_copy_tooltip; ?>" data-toggle="tooltip" data-bs-html="true" data-placement="top">&#128203;</button>
                        <input class="form-control" id="fiatInput" name="fiat" type="text" spellcheck="false" autocorrect="off" inputmode="numeric" aria-label="<?php echo $l_fiatInput; ?>" value="<?php echo $fiat_value; ?>">
                        <select class="input-group-text cursor-pointer" id="selectBox" name="in" aria-label="<?php echo $l_fiatSelect; ?>">
                            <?php
                            foreach ($currencies as $currency) {
                                $selected = $currency == $xmr_in ? 'selected' : '';
                                $currencyName = isset(${"l_" . strtolower($currency)}) ? ${"l_" . strtolower($currency)} : $currency;
                                echo "<option {$selected} value=\"{$currency}\">{$currencyName}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </form>

                <noscript>
                    <div class="alert alert-warning" role="alert">
                        Looks like you have JavaScript disabled. You can still use this tool, but you won't be able to use the &#128203; buttons to automatically copy the results to your clipboard.<br />
                        Use the &darr; button to convert XMR to fiat, or the &uarr; button to convert fiat to XMR.
                    </div>
                </noscript>

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

    <script src="js/main.js"></script>
</body>

</html>
