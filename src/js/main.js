import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min';

import '../css/custom.css';

import Tooltip from "bootstrap/js/dist/tooltip";
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new Tooltip(tooltipTriggerEl, { placement: "top" });
});
console.log(tooltipList);

let lastModifiedField = 'xmr';

document.addEventListener('DOMContentLoaded', function () {
  // Add event listeners to track the last modified input field
  document.getElementById("xmrInput").addEventListener('input', function () {
    lastModifiedField = 'xmr';
  });

  document.getElementById("fiatInput").addEventListener('input', function () {
    lastModifiedField = 'fiat';
  });

  // Fetch updated exchange rates every 5 seconds
  setInterval(fetchUpdatedExchangeRates, 5000);
});

function fetchUpdatedExchangeRates() {
  fetch('/coingecko.php')
    .then(response => response.json())
    .then(data => {
      // Update the exchangeRates object with the new values
      for (const [currency, value] of Object.entries(data)) {
        exchangeRates[currency.toUpperCase()] = value.lastValue;
      }

      updateTimeElement(data.time);

      // Re-execute the appropriate conversion function
      if (lastModifiedField === 'xmr') {
        xmrConvert();
      } else {
        fiatConvert();
      }
    })
    .catch(error => console.error('Error fetching exchange rates:', error));
}

function updateTimeElement(unixTimestamp) {
  const date = new Date(unixTimestamp * 1000);
  const hours = String(date.getHours()).padStart(2, '0');
  const minutes = String(date.getMinutes()).padStart(2, '0');
  const seconds = String(date.getSeconds()).padStart(2, '0');
  const formattedTime = `${hours}:${minutes}:${seconds}`;

  const u = document.querySelector('u');
  u.textContent = formattedTime;
  u.parentElement.innerHTML = u.parentElement.innerHTML.replace('Europe/Berlin', Intl.DateTimeFormat().resolvedOptions().timeZone);
}

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

function fiatConvert(value) {
  let fiatAmount = document.getElementById("fiatInput").value;
  let xmrValue = document.getElementById("xmrInput");
  let selectBox = document.getElementById("selectBox").value;

  if (exchangeRates[selectBox]) {
    let value = fiatAmount / exchangeRates[selectBox];
    xmrValue.value = value.toFixed(selectBox == 'BTC' || selectBox == 'LTC' || selectBox == 'ETH' || selectBox == 'XAG' || selectBox == 'XAU' ? 8 : 2);
  }
}

function xmrConvert(value) {
  let xmrAmount = document.getElementById("xmrInput").value;
  let fiatValue = document.getElementById("fiatInput");
  let selectBox = document.getElementById("selectBox").value;

  if (exchangeRates[selectBox]) {
    let value = xmrAmount * exchangeRates[selectBox];
    fiatValue.value = value.toFixed(selectBox == 'BTC' || selectBox == 'LTC' || selectBox == 'ETH' || selectBox == 'XAG' || selectBox == 'XAU' ? 8 : 2);
  }
}

window.copyToClipBoardXMR = copyToClipBoardXMR;
window.copyToClipBoardFiat = copyToClipBoardFiat;
window.fiatConvert = fiatConvert;
window.xmrConvert = xmrConvert;