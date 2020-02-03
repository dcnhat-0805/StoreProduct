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
            <!-- Contact -->
        </div>
        <div class="fab_field">
            <button id="fab_camera" class="fab__option">
                <i class="fa fa-camera" aria-hidden="true"></i>
            </button>
            <textarea id="chatSend" name="message" placeholder="Send a message"
                      class="chat_field chat_message"></textarea>
            <button id="fab_send" class="fab__option">
                <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <button id="prime" class="fab__chart">
        <i class="fa fa-commenting-o zmdi-comment-outline" aria-hidden="true"></i>
    </button>
</div>
