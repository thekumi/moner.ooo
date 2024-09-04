import 'bootstrap/dist/css/bootstrap.css';
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

var exchangeRates = {};

document.addEventListener('DOMContentLoaded', function () {
  const copyXMRBtn = document.getElementById('copyXMRBtn');
  const copyFiatBtn = document.getElementById('copyFiatBtn');
  const xmrInput = document.getElementById('xmrInput');
  const fiatInput = document.getElementById('fiatInput');
  const selectBox = document.getElementById('selectBox');
  const convertXMRToFiatBtn = document.getElementById('convertXMRToFiat');
  const convertFiatToXMRBtn = document.getElementById('convertFiatToXMR');
  const fiatButtons = document.querySelectorAll('.fiat-btn');

  // Add event listeners for the currency buttons
  fiatButtons.forEach(button => {
    button.addEventListener('click', (e) => {
      e.preventDefault();
      selectBox.value = button.textContent;
      if (lastModifiedField === 'xmr') {
        xmrConvert();
      } else {
        fiatConvert();
      }
      history.pushState(null, '', `?in=${button.textContent}`);
    });
  });

  // Add event listeners for the copy buttons
  copyXMRBtn.addEventListener('click', copyToClipBoardXMR);
  copyFiatBtn.addEventListener('click', copyToClipBoardFiat);

  // Add event listeners for the XMR input field
  xmrInput.addEventListener('change', () => xmrConvert(xmrInput.value));
  xmrInput.addEventListener('keyup', () => {
    xmrInput.value = xmrInput.value.replace(/[^\.^,\d]/g, '');
    xmrInput.value = xmrInput.value.replace(/\,/, '.');
    if (xmrInput.value.split('.').length > 2) {
      xmrInput.value = xmrInput.value.slice(0, -1);
    }
    xmrConvert(xmrInput.value);
  });
  xmrInput.addEventListener('input', () => {
    lastModifiedField = 'xmr';
  });

  // Add event listeners for the fiat input field
  fiatInput.addEventListener('change', () => fiatConvert(fiatInput.value));
  fiatInput.addEventListener('keyup', () => {
    fiatInput.value = fiatInput.value.replace(/[^\.^,\d]/g, '');
    fiatInput.value = fiatInput.value.replace(/\,/, '.');
    if (fiatInput.value.split('.').length > 2) {
      fiatInput.value = fiatInput.value.slice(0, -1);
    }
    fiatConvert(fiatInput.value);
  });
  fiatInput.addEventListener('input', () => {
    lastModifiedField = 'fiat';
  });

  // Add event listener for the select box to change the conversion
  selectBox.addEventListener('change', () => {
    if (lastModifiedField === 'xmr') {
      xmrConvert(selectBox.value)
    } else {
      fiatConvert(selectBox.value)
    }
  });

  // Hide the conversion buttons if JavaScript is enabled
  convertXMRToFiatBtn.style.display = 'none';
  convertFiatToXMRBtn.style.display = 'none';

  // Fetch updated exchange rates immediately, then every 5 seconds
  fetchUpdatedExchangeRates();
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
    xmrValue.value = value.toFixed(12);
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