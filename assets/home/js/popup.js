(function(){
document.getElementById('iframe-popup-open').textContent = 'Click here to make reservation'; 
})();
var styleLoader = function(url) {
    var headID = document.getElementsByTagName('head')[0];
    var link = document.createElement('link');
    link.type = 'text/css';
    link.rel = 'stylesheet';

    headID.appendChild(link);

    link.href = url + 'assets/home/styles/popup-style.css';


};
 
styleLoader('https://tiqs.com/alfred/');


function popup() {
    var iframe_popup = document.getElementById('iframe-popup');
    if (iframe_popup.classList.contains("show")) {
        closeIframe();
      } else {
        openIframe();
      }
   
}

function openIframe() {
    var iframe_popup = document.getElementById('iframe-popup');
    iframe_popup.classList.add('show');
}

function closeIframe() {
    var iframe_popup = document.getElementById('iframe-popup');
    iframe_popup.classList.remove('show');
}