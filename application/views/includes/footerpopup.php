<script>

var popup_open = document.getElementById('iframe-popup-open');
var popup_close = document.getElementById('popup-close');
var iframe_popup = document.getElementById('iframe-popup');

popup_open.addEventListener('click', function(){
    iframe_popup.classList.add('show')
})

popup_close.addEventListener('click', function(){
    iframe_popup.classList.remove('show');
})

</script>
</body>
</html>