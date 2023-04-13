<?php
    require_once 'libraries/autoload.php';  
    include_once $autoload->getFile();
?>

<!DOCTYPE html>
<html>
    <head>    
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?=$config_url_http?>"/>
        <title>Comingsoon !!</title>

        <link href="<?=ASSETS?>plugins/lock/lock.css?v=<?=time()?>" rel="stylesheet"> 
        <script type="text/javascript" src="<?=LIB?>jquery.min.js"></script>
    </head>
    <body>
        <div class="cover-coming">
            <div class="container">
                <div class="box-coming">
                    <div class="title">
                        <h2>We're coming soon !!!</h2>
                    </div>
                    <div class="timer">
                        <p id="count-down" data-date="<?=date("h-m-s", time())?>"></p>
                    </div>
                    <a class="trial" href="index.php">Trial</a>
                </div>
            </div>
        </div>

        <script src="<?=ASSETS?>plugins/lock/countdown.js"></script>
        <script>
            $("#count-down").TimeCircles({   
                circle_bg_color: "#fff",
                bg_width: .2,
                fg_width: 0.013,
                time:
                {
                    Days:{show:false,color:"#fff"},
                    Hours:{color:"#fff"},
                    Minutes:{color:"#fff"},
                    Seconds:{color:"#fff"}
                }
            });
        </script>
    </body>
</html>