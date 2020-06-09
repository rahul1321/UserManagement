@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 chat">
            <div class="card">
                <div class="card-header msg_head">
                    <div class="d-flex bd-highlight">
                        <div class="img_cont">
                            <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img">
                            <span class="online_icon"></span>
                        </div>
                        <div class="user_info">
                            <span>Chat with {{$toUser->name}}</span>
                            <p>{{$chats->count()}} Messages</p>
                        </div>
                        <div class="video_cam">
                            <span><i class="fas fa-video"></i></span>
                            <span><i class="fas fa-phone"></i></span>
                        </div>
                    </div>
                    <span id="action_menu_btn"><i class="fas fa-ellipsis-v"></i></span>
                    <div class="action_menu">
                        <ul>
                            <li><i class="fas fa-user-circle"></i> View profile</li>
                            <li><i class="fas fa-users"></i> Add to close friends</li>
                            <li><i class="fas fa-plus"></i> Add to group</li>
                            <li><i class="fas fa-ban"></i> Block</li>
                        </ul>
                    </div>
                </div>
                <div id="chatBody" class="card-body msg_card_body">
                    @foreach ($chats as $chat)
                        @if ($chat->fromUser->id === Auth::user()->id)
                            <div class="d-flex justify-content-end mb-4">
                                <div class="msg_cotainer_send">
                                    {{$chat->message}}
                                    <span class="msg_time_send">{{$chat->created_at->diffForHumans()}}</span>
                                </div>
                                <div class="img_cont_msg">
                                    <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
                                </div>
                            </div>
                        @else
                        <div class="d-flex justify-content-start mb-4">
                            <div class="img_cont_msg">
                                <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">
                            </div>
                            <div class="msg_cotainer">
                                {{$chat->message}}
                                <span class="msg_time">{{$chat->created_at->diffForHumans()}}</span>
                            </div>
                        </div>
                        @endif
                    @endforeach
                    
                </div>
                <div class="card-footer">
                    <div class="input-group">
                        <form id="chatForm" style="width: 100%;">
                            <input type="hidden" name="from_user_id" value={{Auth::user()->id}}>
                            <input type="hidden" id="toUserField" name="to_user_id" value={{$toUser->id}}>
                            <input id="taMsg" type="textarea"  class="form-control type_msg" required name="message" placeholder="Type here....">
                            <button id="sendMessage" class="btn btn-info btn-sm mt-2" style="float:right">Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script type="text/javascript">
        $('#sendMessage').click(function(event){
            event.preventDefault(); 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: "/chats",
                    data: $('#chatForm').serialize() ,
                    dataType : 'json',
                    success: function(result){
                        var html = '<div class="d-flex justify-content-end mb-4">'+
                                '<div class="msg_cotainer_send">'+
                                    result.data.message
                                    +'<span class="msg_time_send">'+result.created_at+'</span>'+
                                '</div>'+
                                '<div class="img_cont_msg">'+
                                    '<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">'+
                                '</div>'+
                            '</div>';
                        $('#taMsg').val("");
                        $('#taMsg').focus();
                        $("#chatBody").append(html);
                        $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);

                    }});
        });

    var userId = $('meta[name="userId"]').attr('content');
    Echo.private('chat.broadcast.'+userId)
    .listen('ChatEvent', (e) => {
        
        if(e.chat.from_user_id == $('#toUserField').val()){
            var html = '<div class="d-flex justify-content-start mb-4">'+
                            '<div class="img_cont_msg">'+
                                '<img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg" class="rounded-circle user_img_msg">'+
                            '</div>'+
                            '<div class="msg_cotainer">'+
                                e.chat.message
                                +'<span class="msg_time">'+e.chat.created_at+'</span>'+
                            '</div>'+
                        '</div>';
        $("#chatBody").append(html);
        $('#chatBody').scrollTop($('#chatBody')[0].scrollHeight);
        }
        
    });

   /*  $('#taMsg').change(function(){
        console.log('asdasd');
        Echo.private('chat')
            .whisper('typing', {
            name: 'rahul'
        });
    });

    Echo.private('chat')
    .listenForWhisper('typing', (e) => {
        console.log(e.name);
    }); */

    </script>
@endsection