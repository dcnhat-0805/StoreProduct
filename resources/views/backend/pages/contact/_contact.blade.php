<div class="chat__comment">
    <div class="chat-history">
        <ul>
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
                    <li class="comment__customer">
                        <div class="message-data">
                            <span class="message-data-name"><i class="fa fa-circle online"></i> {{ $contact->name }}</span>
                            <span class="message-data-time">{{ date('H:i', strtotime($contact->created_at)) }}</span>
                        </div>
                        <div class="message other-message">
                            <div class="message__body">
                                {!! $contact->message !!}
                            </div>
                        </div>
                    </li>
                    @else
                    <li class="clearfix comment__admin">
                        <div class="message-data align-right">
                            <span class="message-data-time">{{ date('H:i', strtotime($contact->created_at)) }}</span> &nbsp; &nbsp;
                            <span class="message-data-name">Admin</span> <i class="fa fa-circle me"></i>
                        </div>
                        <div class="message my-message float-right">
                            <div class="col-sm-10">
                                {!! $contact->message !!}
                            </div>
                        </div>
                    </li>
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>
