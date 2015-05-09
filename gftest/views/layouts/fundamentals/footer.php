    <footer class="text-center">
        <p class="bttop" id="1@#%^-bottom">
            <a data-scroll data-options='{ "easing": "easeOutCubic" }' href="#top"><img src="<?= $this->prefix; ?>/img/btt.png" alt=""></a>
        </p>
        <span>&copy; dbonev.com 2015</span>
    </footer>
    <!-- END CONTACT SECTION -->
    <!-- END ABOUT ME SECTION -->
    <script src="<?= $this->prefix; ?>/js/libs/jQuery2.1.4.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?= $this->prefix; ?>/js/libs/bootstrap.min.js"></script>
    <!-- Any other custom JS -->
    <script src='<?= $this->prefix; ?>/js/libs/bind-polyfill.js'></script>
    <script src='<?= $this->prefix; ?>/js/libs/smooth-scroll.js'></script>
    <script src='<?= $this->prefix; ?>/js/actions.js'></script>
    <script src='<?= $this->prefix; ?>/js/analitycs.min.js'></script>
    <script>
        smoothScroll.init({
            speed: 1000,
            easing: 'easeInOutCubic',
            offset: 0,
            updateURL: true,
            callbackBefore: function ( toggle, anchor ) {},
            callbackAfter: function ( toggle, anchor ) {}
        });
    </script>  
</body>
</html>