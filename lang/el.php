<?php
// For the HTML meta specification, e.g. <!DOCTYPE html><html lang="en">
$lang_meta = "el"; // https://www.w3schools.com/tags/ref_language_codes.asp

$page_title = "Μετατροπή XMR σε EUR/BTC/CHF/USD και πολλά άλλα"; // The browser tab title or search engine title
$meta_description = "Η ζωντανή συναλλαγματική ισοτιμία του Monero σε πολλά διαφορετικά νομίσματα, δωρεάν για όλους."; // Search engine description / text
$meta_keywords = "Monero, XMR, fiat, αξία, ισοτιμία, ζωντανή, μετατροπή"; // Search engine keywords

$title_h1 = "μετατροπή σε"; // ↓ XMR [...] ↓

$moneroooTable = "Service provided by <a href='https://moner.ooo/'>Moner.ooo</a>, Data provided by <a href='https://www.coingecko.com/en/coins/monero' hreflang='en' rel='external'>CoinGecko</a>";

// Info Text
$info = "Οι συναλλαγματικές ισοτιμίες σε αυτόν τον ιστότοπο είναι μόνο για ενημερωτικούς σκοπούς. Δεν εγγυώνται την ακρίβεια τους και υπόκεινται σε αλλαγές χωρίς προειδοποίηση. Οι συναλλαγματικές ισοτιμίες ενημερώνονται περίπου μία φορά το λεπτό. Τελευταία ενημέρωση στις <u title='Ώρες:Λεπτά:Δευτερόλεπτα (hh:mm:ss)'>".$time."</u>, Europe/Berlin. Δεδομένα παρέχονται από <a class='text-white' href='https://www.coingecko.com/el/coins/monero' hreflang='el' rel='external' target='_blank'>CoinGecko</a>.<br/><a target='_blank' href='https://kuno.anne.media/donate/onml/' rel='external' hreflang='en'><img loading='lazy' src='./img/kuno-monero-26x26.png' width='17' height='17' alt='Kuno - Moner.ooo donation page'></a>&nbsp;<a target='_blank' href='https://kuno.anne.media/' class='text-white' rel='external' hreflang='en'>Kuno – Fundraise with Monero</a> | <a class='text-white' href='{$github_url}' hreflang='en' rel='external' target='_blank'>GitHub</a>";
$servers_guru = " | <a style='text-decoration:none; font-weight:bold;' class='text-white' href='https://servers.guru/' hreflang='en' rel='external' target='_blank'>Webhosting provided by<img loading='lazy' src='./img/servers-guru.svg' height='19' alt='Servers Guru' title='Servers Guru' /></a>";

$clipboard_copy_tooltip = "Αντιγραφή στο πρόχειρο";

$l_fiatSelect = "Currency choice";
$l_fiatInput = "Fiat value input field";
$l_xmrInput = "Monero value input field";

// Tooltip Titel
$l_eur = "Ευρώ";
$l_btc = "Bitcoin";
$l_chf = "Ελβετικό Φράγκο";
$l_usd = "Δολάριο ΗΠΑ";
$l_ltc = "Litecoin";
$l_gbp = "Λίρα στερλίνα";
$l_rub = "Ρωσικό Ρούβλι";
$l_jpy = "Γιεν";
$l_try = "Τουρκική Λίρα";
$l_cad = "Δολάριο Καναδά";
$l_aud = "Δολάριο Αυστραλίας";
$l_hkd = "Δολάριο Χονγκ Κονγκ";
$l_sgd = "Δολάριο Σιγκαπούρης";
$l_pln = "Ζλότι";
$l_zar = "Ραντ Νότιας Αφρικής";
$l_inr = "Ρουπία Ινδίας";
$l_aed = "Ντιρχάμ ΗΑΕ";
$l_eth = "Ethereum";
$l_uah = "Γρίβνα";
$l_krw = "Γουόν Νότιας Κορέας";
$l_brl = "Ρεάλ Βραζιλίας";
$l_myr = "Ρινγκίτ Μαλαισίας";
$l_cny = "Ρενμίνμπι";
$l_xag = "Ασήμι (τροία ουγγιά)";
$l_xau = "Χρυσός (τροία ουγγιά)";
$l_vnd = "Ντονγκ Βιετνάμ";
$l_vef = "Μπολιβάρ Βενεζουέλας";
$l_thb = "Μπατ";
$l_sar = "Ριάλ Σαουδικής Αραβίας";
$l_sek = "Κορώνα Σουηδίας";
$l_pkr = "Ρουπία Πακιστάν";
$l_nzd = "Δολάριο Νέας Ζηλανδίας";
$l_php = "Πέσο Φιλιππίνων";
$l_nok = "Κορώνα Νορβηγίας";
$l_lkr = "Ρουπία Σρι Λάνκα";
$l_mmk = "Κυάτ Μιανμάρ";
$l_huf = "Φιορίνι Ουγγαρίας";
$l_ils = "Νέο Σέκελ Ισραήλ";
$l_kwd = "Δηνάριο Κουβέιτ";
$l_ngn = "Νάιρα Νιγηρίας";
$l_idr = "Ρουπία Ινδονησίας";
$l_twd = "Νέο Δολάριο Ταϊβάν";
$l_ars = "Πέσο Αργεντινής";
$l_bdt = "Τάκα Μπαγκλαντές";
$l_bhd = "Δηνάριο Μπαχρέιν";
$l_bmd = "Δολάριο Βερμούδων";
$l_czk = "Κορώνα Τσεχίας";
$l_dkk = "Κορώνα Δανίας";
$l_clp = "Πέσο Χιλής";
$l_mxn = "Πέσο Μεξικού";
$l_bch = "Bitcoin Cash";
$l_bnb = "Binance Coin";
$l_eos = "EOS.IO";
$l_xrp = "Ripple";
$l_xlm = "Stellar Lumens";
$l_link = "Chainlink";
$l_dot = "Polkadot";
$l_yfi = "Yearn.Finance";
$l_gel = "Λάρι Γεωργίας";
$l_xdr = "Ειδικά Τραβηκτικά Δικαιώματα";

// More Monero links
$getmonero = '<a class="text-white" href="https://www.getmonero.org/el/" hreflang="el" target="_blank" rel="external">Επίσημος ιστότοπος</a> | <a class="text-white" href="https://ccs.getmonero.org/" hreflang="en" target="_blank" rel="external">Community Crowdfunding System (CCS)</a> | <a class="text-white" href="https://www.monero.observer/resources/" hreflang="en" target="_blank" rel="external">Monero Observer</a> | <a class="text-white" href="https://www.monerotalk.live/" hreflang="en" target="_blank" rel="external">Monero Talk</a>';
$countrymonero = ' | <a class="text-white" href="https://t.me/monerogr" hreflang="en" target="_blank" rel="external">Telegram - Monero Greece</a>';

?>
