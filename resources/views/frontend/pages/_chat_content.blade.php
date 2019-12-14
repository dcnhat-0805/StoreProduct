@if(count($contacts))
    @php($spaceDate = null)
    @foreach($contacts as $contact)
        @php($isNewSpaceDate = false)
        @if($spaceDate != \App\Helpers\Helper::formatDateWeekday($contact->created_at))
            @php($spaceDate = \App\Helpers\Helper::formatDateWeekday($contact->created_at))
            @php($isNewSpaceDate = true)
        @endif
        @if($isNewSpaceDate)
            <div class="status">{{ $spaceDate }}</div>
        @endif
        @if($contact->type == CUSTOMER_SEND)
            <div class="chat_msg_item chat_msg_item_user">
                {!! nl2br(e($contact->message)) !!}
            </div>
        @else
            <div class="chat_msg_item chat_msg_item_admin">
                <div class="chat_avatar">
                    <div class="chat__avatar">
                        <div class="chat__text">
                            <span>AD</span>
                        </div>
                    </div>
                </div>
                {!! nl2br(e($contact->message)) !!}
            </div>
        @endif
    @endforeach
@endif

