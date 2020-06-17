
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Echo from 'laravel-echo'

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});


window.Echo.channel('test')
.listen('Test', (e) => {
    console.log('tét event');
    console.log(e.request.chat_id)
    if ($('#body-chat').attr('data-chat') == e.request.chat_id) {
        if (e.request.user_id != $('#user_id').val()) {
            
            $('#all-message').append(`
                <div class="row"> 
                    <div style="float: left; width: 100%;"> 
                        <p class="mess" style="background-color: lightgray; padding: 12px;text-align: left; width: auto;max-width: 233px; float: left;border-radius: 12px;">
                            `+e.request.content+`
                        </p>
                    </div>
                </div>
            `);
        } else {
            $('#all-message').append(`
                <div class="row"> 
                    <div style="float: right; width: 100%;"> 
                        <p class="mess" style="background-color: lightblue; padding: 12px;text-align: right; width: auto;max-width: 233px; float: right;border-radius: 12px;">
                            `+e.request.content+`
                        </p>
                    </div>
                </div>
            `);
            
        }
    }

    var element = document.getElementById("all-message");
    element.scrollTop = element.scrollHeight;

});


