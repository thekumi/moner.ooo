import Tooltip from "bootstrap/js/dist/tooltip";
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-toggle="tooltip"]')
);
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new Tooltip(tooltipTriggerEl, { placement: "top" });
});
console.log(tooltipList);

import 'bootstrap/dist/css/bootstrap.min.css';
import '../css/custom.css';

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