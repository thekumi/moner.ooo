<?php
return [
    // Meta-Angaben
    'meta' => [
        'lang' => 'de',
        'title' => 'XMR Umrechnung nach EUR/BTC/CHF/USD und viele mehr',
        'description' => 'Der Monero live Wechselkurs in vielen verschiedenen Währungen, kostenlos für jeden.',
        'keywords' => 'Monero, XMR, Fiat, Wert, Kurs, Live, Wechsel, Umrechnung',
        'rtl' => false
    ],
    
    // Seiteninhalte
    'content' => [
        'title_h1' => 'Umrechnung nach',
        'monerooo_table' => 'Service bereitgestellt von <a href="https://moner.ooo/">Moner.ooo</a>, Daten bereitgestellt von <a href="https://www.coingecko.com/de/coins/monero" hreflang="de" rel="external">CoinGecko</a>',
        'unix_time' => 'Unix Zeit:',
        'clipboard_tooltip' => 'In die Zwischenablage kopieren'
    ],
    
    // Währungsbezeichnungen
    'currencies' => [
        'EUR' => 'Euro',
        'USD' => 'US-Dollar',
        'GBP' => 'Pfund Sterling',
        'CHF' => 'Schweizer Franken',
        'RUB' => 'Russischer Rubel',
        'CNY' => 'Chinesischer Yuan',
        'JPY' => 'Japanischer Yen',
        'IDR' => 'Indonesische Rupiah',
        'KRW' => 'Südkoreanischer Won',
        'TRY' => 'Türkische Lira',
        'AUD' => 'Australischer Dollar',
        'BMD' => 'Bermuda-Dollar',
        'CAD' => 'Kanadischer Dollar',
        'HKD' => 'Hongkong-Dollar',
        'NZD' => 'Neuseeland-Dollar',
        'SGD' => 'Singapur-Dollar',
        'TWD' => 'Neuer Taiwan-Dollar',
        'ILS' => 'Israelischer Schekel',
        'PLN' => 'Polnischer Złoty',
        'ZAR' => 'Südafrikanischer Rand',
        'CZK' => 'Tschechische Krone',
        'DKK' => 'Dänische Krone',
        'NOK' => 'Norwegische Krone',
        'SEK' => 'Schwedische Krone',
        'ARS' => 'Argentinischer Peso',
        'CLP' => 'Chilenischer Peso',
        'PHP' => 'Philippinischer Peso',
        'MXN' => 'Mexikanischer Peso',
        'BHD' => 'Bahrain-Dinar',
        'KWD' => 'Kuwait-Dinar',
        'BRL' => 'Brasilianischer Real',
        'MYR' => 'Malaysischer Ringgit',
        'VEF' => 'Venezolanischer Bolívar',
        'UAH' => 'Ukrainische Hrywnja',
        'VND' => 'Vietnamesischer Đồng',
        'BDT' => 'Bangladesch-Taka',
        'HUF' => 'Ungarischer Forint',
        'MMK' => 'Myanmarischer Kyat',
        'NGN' => 'Nigerianischer Naira',
        'THB' => 'Thailändischer Baht',
        'AED' => 'VAE-Dirham',
        'SAR' => 'Saudi-Riyal',
        'PKR' => 'Pakistanische Rupie',
        'LKR' => 'Sri-Lanka-Rupie',
        'INR' => 'Indische Rupie',
        'GEL' => 'Georgischer Lari',
        'BTC' => 'Bitcoin',
        'LTC' => 'Litecoin',
        'ETH' => 'Ethereum',
        'XAG' => 'Silber (Feinunze)',
        'XAU' => 'Gold (Feinunze)'
    ],
    
    // Formular-Labels
    'form' => [
        'fiat_select' => 'Währungsauswahl',
        'fiat_input' => 'Fiat-Wert Eingabefeld',
        'xmr_input' => 'Monero-Wert Eingabefeld'
    ],
    
    // Footer-Informationen
    'footer' => [
        'info' => 'Die Werte auf dieser Webseite dienen nur der Information. Der Wert ist nicht garantiert und wird ohne vorherige Ankündigung geändert. Die Werte werden alle 5 Minuten aktualisiert. Zuletzt um <u title="Stunden:Minuten:Sekunden (hh:mm:ss)">:time</u> Uhr, Europe/Berlin. Daten bereitgestellt von <a class="text-white" href="https://www.coingecko.com/de/munze/monero" hreflang="de" rel="external" target="_blank">CoinGecko</a>.',
        'links' => [
            '<a target="_blank" href="https://kuno.anne.media/donate/onml/" rel="external" hreflang="en"><img loading="lazy" src="./images/kuno-monero-26x26.png" style="vertical-align:text-bottom;" width="17" height="17" alt="Kuno - Moner.ooo Spendenseite"></a> <a target="_blank" href="https://kuno.anne.media/donate/onml/" class="text-white" rel="external" hreflang="de">Kuno – Mit Monero Spenden sammeln</a>',
            '<a class="text-white" href="https://github.com/nice42q/moner.ooo" hreflang="en" rel="external" target="_blank">GitHub</a>',
            '<a style="text-decoration:none; font-weight:bold;" class="text-white" href="https://servers.guru/" hreflang="en" rel="external" target="_blank">Webhosting bereitgestellt von<img loading="lazy" src="./images/servers-guru.svg" style="vertical-align:top;" height="23" alt="Servers Guru" title="Servers Guru"></a>'
        ],
        'monero_links' => [
            '<a class="text-white" href="https://www.getmonero.org/de/" hreflang="de" target="_blank" rel="external">Offizielle Webseite</a>',
            '<a class="text-white" href="https://ccs.getmonero.org/" hreflang="en" target="_blank" rel="external">Community Crowdfunding System (CCS)</a>',
            '<a class="text-white" href="https://www.monero.observer/resources/" hreflang="en" target="_blank" rel="external">Monero Observer</a>',
            '<a class="text-white" href="https://www.monerotalk.live/" hreflang="en" target="_blank" rel="external">Monero Talk</a>',
            '<a class="text-white" href="https://t.me/moneroger" hreflang="en" target="_blank" rel="external">Telegram - Monero Germany</a>'
        ]
    ]
];