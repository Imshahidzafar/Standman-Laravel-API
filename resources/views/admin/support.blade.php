@extends('layout.admin.list_master')
    @section('content')    
    <style>
        input{
           border-radius: 20px;
        }
        .avatar {
          vertical-align: middle;
          width: 50px;
          height: 50px;
          border-radius: 50%;
        }
        .imageUpload
        {
            display: none;
        }

        .profileImage
        {
            /* margin-top: -40px; */
            cursor: pointer;
            width: 100%;
        }

        #profile-container {
            margin: 20px auto;
            width: 130px;
            height: 130px;
            color: white;
            justify-content: center;
            border: 1px solid #8f8989;
            overflow: hidden;
        }

        #profile-container img {
            width: 150px;
            height: 150px;
           
        }
        .chat-row {
            display: flex;
            gap: 30px;
            padding: 0.4rem 2rem;
        }
        .chat-heads {
            flex-basis: 40%;
            height: 630px;
            overflow-y: auto;
            padding: 30px; 
            background-color: #fff;
            border-radius: 20px;
        }
        .chat-heads .chat-list {
            border-bottom: 1px solid #F5F5F5;
            border-radius: 0.5px;
        }
        .chat-heads .chat-img {
            height: 56px;
            width: 56px;
            background-color: black;
            border-radius: 20px;
        }
        .chat-heads .chat-list {
            display: flex;
            gap: 15px;
        }
        .chat-row .users {
            color: #fff !important;
            background: #8000FF !important;
            border-radius: 20px;
            width: 80%;
        }
        .chat-row .me {
            color: #000 !important;
            background: #F6F6F6 !important;
            border-radius: 20px;
            width: 80%;
            margin-left: auto;
        }
    </style>
    <!--**********************************
        Chat box End
    ***********************************-->
    <div class="content-body">
        @section('titleBar')
        <span class="ml-2">Customer Support</span>
        @endsection
        
        <?php 
            $logged_user = session('id');
            $chat_heads_count = DB::table('chat_list_live')->where('receiver_id', $logged_user)->count(); 
            if($chat_heads_count > 0){
        ?>
        <div class="chat-row">
            <!-- CHAT HEADS -->
            <div class="chat-heads">
                <?php
                $chat_heads = DB::table('chat_list_live')->where('receiver_id', $logged_user)->get();
                foreach ($chat_heads as $chat_head) {
                    $users_details = DB::table('users_customers')->where('users_customers_id', $chat_head->sender_id)->first();
                ?>
                    <div class="chat-list p-4" onclick="get_messages_list('<?php echo $chat_head->sender_id; ?>', '<?php echo $logged_user; ?>');">
                        @if ($users_details && $users_details->profile_pic)
                            <img class="chat-img rounded-xxl" src="{{ asset($users_details->profile_pic) }}" alt="">
                        @else
                            <img class="chat-img rounded-xxl" src="default-image.jpg" alt="image" width="100px">
                        @endif
                        <small>
                            <b>{{$users_details->first_name}} {{$users_details->last_name}}</b><br>
                            <i style="color:green;">{{$users_details->email}} </i>
                            <br>
                            <p class="mb-0">
                                <?php
                                $chat_message = DB::table('chat_messages_live')
                                    ->where([['sender_id', $chat_head->sender_id], ['receiver_id', $logged_user]])
                                    ->orWhere([['sender_id', $logged_user], ['receiver_id', $chat_head->sender_id]])
                                    ->get()->last();

                                if (!empty($chat_message)) {
                                    echo $chat_message->message;
                                } else {
                                    echo 'No Msg sent or recieved.';
                                }
                                ?>
                            </p>
                        </small>
                    </div>
                <?php } ?>
            </div>
            <!-- CHAT HEADS -->

            <!-- CHAT MESSAGES -->
            <div class="rounded-xxl" style="width:70%; padding:30px;background-color: white;position: relative;">
                <div id="messages_list" class="messages_list"><h1 style="text-align: center;">No Chat Selected.</h1></div>

                <div style="height:100px;"></div>
                
                <footer id="send_message"  class="mx-auto" style="position: absolute;bottom: 40px;right:0;left:0;width: 94%; display: none;">
                    <div class="d-flex rounded-xxl py-0" >
                        <input style="border:none;margin-left:10px;background-color:#F3F3F3;box-shadow: none;" type="text" class="form-control" placeholder="Enter message here.." id="message">
                        <button type="button" class="btn shadow-0" onclick="send_messages();"><img src="/public/images/card/email.svg" alt="image"></button>
                    </div>
                </footer>
            </div>
            <!-- CHAT MESSAGES -->
            <?php } else { ?>
            <div style="width:100%; padding:30px;background-color: white;position: relative;">
                <div id="messages_list"><h1 style="text-align: center;">No support inquiries.</h1></div>
            </div>
            <?php } ?>
        </div>
    </div>

    <input type="hidden" name="sender_id" id="sender_id" value="0">
    <input type="hidden" name="receiver_id" id="receiver_id" value="0">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();

            setInterval(function () { 
                sender_id = $('#sender_id').val();
                receiver_id = $('#receiver_id').val();
                if(sender_id != 0 && receiver_id != 0){
                    get_messages_list(sender_id, receiver_id); 
                }
            }, 3000);
        }); 

        function get_messages_list(sender_id, receiver_id){

            $('#sender_id').val(sender_id);
            $('#receiver_id').val(receiver_id);

            var settings = {
                "url": "/api/user_chat_live",
                "method": "POST",
                "timeout": 0,
                "headers": {
                   "Content-Type": "application/json"
                },
                
                "data": JSON.stringify({
                    "requestType": "getMessages",
                    "users_customers_id": sender_id,
                    "other_users_customers_id": receiver_id
                }),
            };

            $.ajax(settings).done(function (response) {
                displayText = '';
                chats = response.data;
                chats.forEach(myChats);

                $('#send_message').show();
                $('#messages_list').html(displayText);
            });
        }

        function myChats(item, index) {
            if(item.sender_type == "Users"){
                /* RECIEVED */
                displayText += '<div class="users p-3 mb-3">'+ item.message + '<br>' + item.date + '</div><div style="height:20px;"></div>';
                /* RECIEVED */
            } else {
                /* SENT */
                displayText += '<div class="me p-3 mb-3">'+ item.message + '<br>' + item.date + '</div><div style="height:20px;"></div>';
                /* SENT */
            }
        }

        function send_messages(){
            sender_id = $('#sender_id').val();
            receiver_id = $('#receiver_id').val();
            var message_string = $('#message').val();
            if(message_string != ''){
                var settings = {
                    "url": "/api/user_chat_live",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                       "Content-Type": "application/json"
                    },
                    
                    "data": JSON.stringify({
                        "requestType": "sendMessage",
                        "sender_type": "Admin",
                        "messageType": "1",
                        "users_customers_id": receiver_id,
                        "other_users_customers_id": sender_id,
                        "content": message_string,
                    }),
                };

                $.ajax(settings).done(function (response) {
                    get_messages_list(sender_id, receiver_id);
                    $('#message').reset();
                    Command: toastr['success']("Message sent!");
                });
            } else {
                Command: toastr['warning']("Please enter message!");
            }
        }
    </script>
@endsection