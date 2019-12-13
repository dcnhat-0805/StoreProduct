@php
    $user = Auth::user();
@endphp
<div class="fabs">
    <div class="chat">
        <div class="chat_header">
            <div class="chat_option">
                <div class="header_img">
                    @if(isset($user->avatar) && $user->avatar)
                        <img src="{{ $user->avatar }}"/>
                    @else
                        <div class="chat__avatar">
                            <div class="chat__text">
                                <span>{{ $user->name[0] }}</span>
                            </div>
                        </div>
                    @endif
                </div>
                <span id="chat_head">{{ $user->name }}</span>
                <span class="online">(Online)</span>
            </div>

        </div>
        <div id="chat_converse" class="chat_conversion chat_converse">
            <span class="chat_msg_item chat_msg_item_admin">
            <div class="chat_avatar">
            @if(isset($user->avatar) && $user->avatar)
                <img src="{{ $user->avatar }}"/>
            @else
                <div class="chat__avatar">
                    <div class="chat__text">
                        <span>{{ $user->name[0] }}</span>
                    </div>
                </div>
            @endif
            </div>Hey there! Any question?</span>
            <span class="chat_msg_item chat_msg_item_user">
            Hello!</span>
            <span class="status">20m ago</span>
            <span class="chat_msg_item chat_msg_item_admin">
            <div class="chat_avatar">
            @if(isset($user->avatar) && $user->avatar)
                <img src="{{ $user->avatar }}"/>
            @else
                <div class="chat__avatar">
                    <div class="chat__text">
                        <span>{{ $user->name[0] }}</span>
                    </div>
                </div>
            @endif
            </div>Hey! Would you like to talk sales, support, or anyone?</span>
            <span class="chat_msg_item chat_msg_item_user">
            Lorem Ipsum is simply dummy text of the printing and typesetting industry.</span>
            <span class="status2">Just now. Not seen yet</span>
        </div>
        <div class="fab_field">
            <a id="fab_camera" class="fab__option">
                <i class="fa fa-camera" aria-hidden="true"></i>
            </a>
            <a id="fab_send" class="fab__option">
                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
            </a>
            <textarea id="chatSend" name="chat_message" placeholder="Send a message"
                      class="chat_field chat_message"></textarea>
        </div>
    </div>
    <a id="prime" class="fab__chart">
        <i class="fa fa-commenting-o zmdi-comment-outline" aria-hidden="true"></i>
    </a>
</div>
