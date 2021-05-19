<?php if (!empty($vendor)) { ?>
    <!-- Start Google Analytics -->
    <?php if ($vendor['googleAnalyticsCode']) { ?>
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo $vendor['googleAnalyticsCode']; ?>', 'auto');
        ga('send', 'pageview');
        </script>
    <?php } ?>
    <!-- End Google Analytics -->

    <!-- Start Google Tag Manager Code -->
    <?php if ($vendor['googleTagManagerCode']) { ?>
        <script>
            (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','<?php echo $vendor['googleTagManagerCode']; ?>');
        </script>
    <?php } ?>
    <!-- End Google Tag Manager Code -->

    <!-- Start Google Adwords Conversion Id -->
    <?php if ($vendor['googleAdwordsConversionId']) { ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $vendor['googleAdwordsConversionId']; ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?php echo $vendor['googleAdwordsConversionId']; ?>');
        </script>
    <?php } ?>
    <!-- End Google Adwords Conversion Id -->

    <!-- Start Google Adwords Conversion Label -->
    <?php if ($vendor['googleAdwordsConversionLabel'] && $vendor['googleAdwordsConversionId']) { ?>
        <script>
            gtag('event', 'conversion', {'send_to': '<?php echo $vendor['googleAdwordsConversionId']; ?>/<?php echo $vendor['googleAdwordsConversionLabel']; ?>',
                'value': 1.0,
                'currency': 'EUR'
            });
        </script>
    <?php } ?>
    <!-- End Google Adwords Conversion Label -->


    <!-- Start Facebook Pixed Id -->
    <?php if ($vendor['facebookPixelId']) { ?>
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '<?php echo $vendor['facebookPixelId']; ?>');
            fbq('track', 'PageView');
        </script>
    <?php } ?>
    <!-- End Facebook Pixed Id -->
<?php } ?>
