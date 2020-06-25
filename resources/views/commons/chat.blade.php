<div class="khung-ban-chat" style="background-color: white;position: fixed;right: 456px;width: 327px;bottom: 0px;height: auto;border-top-left-radius: 12px;border-right: 1px solid lightgray; z-index: 999999; border: 1px solid lightgray;" >
    <div class="body-chat" id="body-chat-partner" style="width: 100%; height: 438px; padding: 0px 12px;overflow: auto; display: none;">
        
    </div>
</div>
<div class="khung-chat" style="background-color: white;position: fixed;right: 129px;width: 327px;bottom: 0px;height: auto; border-top-right-radius: 12px; border-top-left-radius: 12px; z-index: 999999; border: 1px solid lightgray;"> 
    <button class="header-chat btn btn-info" style="width: 100%; border-bottom-right-radius: 0px;border-bottom-left-radius: 0px;border-top-right-radius: 9.5px;border-top-left-radius: 9.5px;" data-flag="0" 
    @if (Auth::check())
    data-route="{{ route('chatPartner', Auth::user()->id) }}"
    @endif
    data-id="@if(Auth::check()){{ Auth::user()->id }}@endif">Chat </button>
    <div class="body-chat" id="body-chat" data-chat="" style="width: 100%; height: 400px; padding: 12px;display: none;"> 
        <div class="container" id="all-message" style="width: 100%; height: 80%;overflow: auto;">
        </div>
        <div class="container" style="width: 100%;height: 20%;padding-top: 2%;border-top: 1px solid lightgray;">
            <form action="" method="post" class="row">
                @csrf
                <input type="hidden" name="user_id" id="user_id" @if(Auth::check()) value="{{ Auth::user()->id }}" @endif>
                <input type="hidden" name="stall_manager_id" id="partner_id">
                <div class="col-md-9 col-sm-9" style="padding: 0px;">
                    <textarea cols="30" rows="3" id="content" disabled="disabled">

                    </textarea>
                </div>
                <div class="col-md-2 col-sm-2">
                    <button type="submit" class="btn btn-info" id="testSubmit">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>