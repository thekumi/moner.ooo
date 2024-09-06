<?php
return [
    'attribution' => '', // Custom attribution HTML to show in the info text
    'footer_links' => [ // Custom links to show in the footer
        ['text' => 'Clearnet', 'url' => 'https://monerooo.private.coffee/'],
        ['text' => 'Tor', 'url' => 'http://monerooo.coffee2m3bjsrrqqycx6ghkxrnejl2q6nl7pjw2j4clchjj6uk5zozad.onion'],
        ['text' => 'Private.coffee', 'url' => 'https://private.coffee']
    ],
    'preferred_currencies' => [ // Currencies that should be displayed at the top of the lists
        'usd', 'eur', 'gbp', 'cad', 'btc', 'eth', 'ltc'
    ],
    'github_url' => 'https://git.private.coffee/kumi/moner.ooo/', // URL to the GitHub repository - replace if you forked the project
    'servers_guru' => false, // Show the "Servers Guru" attribution link in the info text - here for upstream compatibility
];