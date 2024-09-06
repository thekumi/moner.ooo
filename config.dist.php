<?php
return [
    'attribution' => '', // Custom attribution HTML to show in the info text
    'footer_links' => [ // Custom links to show in the footer
        ['text' => 'Clearnet', 'url' => 'https://calc.revuo-xmr.com'],
        ['text' => 'Tor', 'url' => 'http://calc.revuo75joezkbeitqmas4ab6spbrkr4vzbhjmeuv75ovrfqfp47mtjid.onion'],
        ['text' => 'Revuo Monero', 'url' => 'https://www.revuo-xmr.com/']
    ],
    'preferred_currencies' => [ // Currencies that should be displayed at the top of the lists
        'usd', 'eur', 'gbp', 'cad', 'btc', 'eth', 'ltc'
    ],
    'github_url' => 'https://github.com/rottenwheel/moner.ooo/', // URL to the GitHub repository - replace if you forked the project
    'servers_guru' => false, // Show the "Servers Guru" attribution link in the info text - here for upstream compatibility
];
