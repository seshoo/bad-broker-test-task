<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title>Hello, world!</title>

    <script>
        $(document).on('submit', '.js-ajax-form', function(e) {
            e.preventDefault();
            var form = $(this);
            var data = form.serializeArray();
            var url = form.attr("action");

            $.ajax({
                url: url,
                type: "POST",
                data: data,
                dataType: "json",
                success: function(responce) {
                    console.log(responce);
                },
                error: function(responce) {
                    console.log(responce);
                }
            });

        });
        $(document).on('click', '.js-close-toast', function() {
            $(this).closest('.toast').remove();
        });

        function addErrorMessage(str) {
            var container = $('.js-message-contaner');
            if (container === undefined) {
                return;
            }
            var html = `<div class="show toast align-items-center text-white bg-danger border-0" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ` + str + `
                        </div>
                        <button type="button" class="js-close-toast btn-close btn-close-white me-2 m-auto"
                            data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>`;

            container.prepend(html);
        }
    </script>
</head>

<body>
    <div class="container  pt-4">
        @yield('content')
    </div>
    <div aria-live="polite" aria-atomic="true" class="position-absolute position-relative top-0 end-0 "
        style='width: 600px;'>
        <div class="toast-container position-absolute top-0 end-0 p-3 js-message-contaner">
        </div>
    </div>
</body>

</html>
