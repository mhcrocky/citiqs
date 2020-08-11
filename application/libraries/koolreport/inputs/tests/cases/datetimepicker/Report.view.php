<?php
    use \koolreport\inputs\DateTimePicker;
?>

<html>
    <head>
        <title>DateTimePicker</title>
    </head>
    <body>
        <h1>DateTimePicker</h1>
        <p class="lead">
            Should display timepicker
        </p>
        <div class="row">
            <div class="col-md-4">
                <?php
                DateTimePicker::create(array(
                    "name"=>"myDateTime",
                    "format"=>"YYYY-MM-DD H:m:s",
                    "options"=>array(
                        "icons"=>array(
                            "time"=>"far fa-clock",
                        )
                    )
                ));
                ?>            
            </div>
        </div>
    </body>
</html>