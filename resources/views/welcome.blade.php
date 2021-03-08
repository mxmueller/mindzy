<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Mindzy</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>Mindzy - Chat Prototype (Pre-Alpha)</h1>
        </div>

        <div class="container">
            <table class="table">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">Chat:</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody id="notification">

                </tbody>
              </table>
        </div>

        <div class="container mt-5">
            <form>
                @csrf
                <label for="pseudo_user">Absender:</label><br>
                <input type="tet" id="pseudo_user" name="pseudo_user"><br>
                <label for="text_message">Nachricht:</label><br>
                <textarea id="text_message" name="text_message" cols="40" rows="5"></textarea>
              </form> 

              <button type="button" class="mt-2 btn btn-warning"id="chat_submit">submit</button>
        </div>
    </body>
    <script>
            window.laravel_echo_port='{{env("LARAVEL_ECHO_PORT")}}';
    </script>
    <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script>
    <script src="{{ url('/js/socket.io.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        var i = 0;
        window.Echo.channel('user-channel')
         .listen('.UserEvent', (data) => {
            i++;
            $("#notification").append(
                '<tr><td>'+data.user+'</td><td>'+data.message+'</td></tr>');
                
        });
    </script>
    <script type="text/javascript">
        $(function () {
            const $submit_btn = $('#chat_submit');
            
            $submit_btn.on('click', function () {
                
                event.preventDefault();
                let $message = $('#text_message').val();
                let $user = $('#pseudo_user').val();
                
                $.ajax({
                    url: '/ajax-chat-submit',
                    type: 'POST',
                    data:{
                        "_token": "{{ csrf_token() }}",
                        message:$message,
                        user:$user,
                    },
                    success: function(data, textStatus, jqXHR) {
                        console.log('AJAX call successful');
                        console.log(data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('AJAX call failed');
                        console.log(textStatus + ': ' + errorThrown);
                    },
                    complete: function() {
                        console.log('AJAX call completed');
                    },
                });
            });
        });
    </script>
</html>
