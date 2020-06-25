<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var url = "{{ URL::to('/') . '/' }}";

    $('.header-chat').on('click', function(e){
        e.preventDefault();

        if ($(this).attr('data-flag') == 0) {
            if ($(this).attr('data-id') != "") {
                $.ajax({
                    url: $(this).data('route'),
                    type: 'GET',
                    data: {
                        "user_id": $(this).attr('data-id'),
                    },
                    success: function(response){
                        $("#body-chat-partner").children().remove();
                        $('#body-chat-partner').html(`
                            <div class="row">
                                <div style="width: 100%;height: 38px;border-bottom: 1px solid lightgray;text-align: center;padding: 8px;">
                                    <p style="text-align: center;vertical-align: middle;"> Cuộc trò chuyện </p>
                                </div>
                            </div>
                        `);

                        $.each(response.data, function(key, value){
                            $.each(value, function(key, value){
                                $('#body-chat-partner').append(`
                                    <div class="row content-partner" style="margin-top: 12px;"> 
                                        <div class="col-md-3">
                                            <img src="`+url+`storage/`+value.thumbnail+`" alt="placeholder+image" style="width:50px;height:50px;border-radius:50%;">
                                        </div>
                                        <div class="col-md-9"> 
                                            <a data-chat="`+value.chat_id+`" data-partner="`+value.partner_id+`" class="reply-mess btn" style="background-color: lightgray; padding: 12px; border-radius: 12px; text-align: left; border: none;">
                                                `+value.name+`
                                            </a>
                                        </div>
                                    </div>
                                `);
                            })
                        });
                    },
                    error:  function(response){
                        console.log(response.message);
                    }
                })
            } else {
                toastr.warning('Bạn chưa đăng nhập để bắt đầu cuộc trò chuyện!');
            }
            $('.body-chat').css({'display':'block'});
            $('button.header-chat').css({'border-top-left-radius':'0px'});
            $(this).attr({'data-flag':'1'});
        } else {
            $('.body-chat').css({'display':'none'});
            $('button.header-chat').css({'border-top-left-radius':'9.5px'});
            $(this).attr({'data-flag':'0'});
        }
    });

    $('body').delegate('.reply-mess', 'click', function(e){
        e.preventDefault();
        var name_partner = $(this).html();
        $('button.header-chat').html($.trim(name_partner));
        $('#content').removeAttr('disabled');
        $('#body-chat').attr({'data-chat': $(this).attr('data-chat')});
        $('#partner_id').val($(this).attr('data-partner'));
        $.ajax({
            type: 'GET',
            url: url + 'getMess/' + $(this).attr('data-chat'),
            success: function(response){
                $("#all-message").children().remove();
                // setTimeout(function(){
                    $.each(response.data, function(key, value){
                        @if (Auth::check()) {
                            if (value.sender_id == {{ Auth::user()->id }}) {
                                $('#all-message').append(`
                                    <div class="row"> 
                                        <div style="float: right; width: 100%;"> 
                                            <p class="mess" style="background-color: lightblue; padding: 12px;text-align: right; margin: 5px 0px;width: auto; float: right;border-radius: 12px;">
                                                `+value.content+`
                                            </p>
                                        </div>
                                    </div>
                                `);
                            } else {
                                $('#all-message').append(`
                                    <div class="row"> 
                                        <div style="float: left; width: 100%;"> 
                                            <p class="mess" style="background-color: lightgray; padding: 12px;text-align: left; margin: 5px 0px;width: auto; float: left;border-radius: 12px;">
                                                `+value.content+`
                                            </p>
                                        </div>
                                    </div>
                                `);
                            }
                        }
                        @endif
                    });
                    updateScroll();
                // }, 500);

            },
            error:  function(response){
                console.log(response.message);
            }
        })
    });

    $('#testSubmit').on('click', function (e){
        e.preventDefault();
        console.log("join ajax");
        $.ajax({
            url: url + '/sendMess',
            type: 'POST',
            data: {
                "content": $('#content').val(),
                "user_id": $('#user_id').val(),
                "partner_id": $('#partner_id').val(),
                "chat_id": $('#body-chat').attr('data-chat')
            },
            success: function(data){
                console.log(data)
                $('#content').val('');
                updateScroll();
            },
            error:  function(error){
                console.log(error);
            }
        })
    })

    function updateScroll(){
        var element = document.getElementById("all-message");
        element.scrollTop = element.scrollHeight;
    }

    /* var socket = io(window.location.hostname + ":6001");

    socket.on('myweb_database_test:message', function(data){
        console.log('ok');
    }); */

    
</script>