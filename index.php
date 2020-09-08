<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CurrencyConverter</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="scripts/main.js"></script>
        <!-- JQUERY -->
        <script>
            $(function() {
                $('form').on('submit', function (e) {
                    e.preventDefault();

                    $.ajax({
                        type: 'post',
                        url: 'php/main.php',
                        data: $('form').serialize()
                    });
                });
            });
        </script>
    </head>
    <body>
        <div class="container">
            <div class="title">
                <h1>Currency Converter</h1>
            </div>
            <form class="from-container">
                <input type>
            </form>
        </div>
    </body>
</html>