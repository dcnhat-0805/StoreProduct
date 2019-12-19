<div class="chat__comment">
    <div class="chat-history">
        <ul>
            @if(!empty($comments))
                @foreach($comments as $comment)
                    @if($comment->type == CUSTOMER_ASK)
                        @php
                            $repComments = \App\Models\ReplyComment::getCommentReply($comment->commentId);
                        @endphp
                            <li class="comment__customer">
                                <div class="message-data">
                                    <span class="message-data-name"><i class="fa fa-circle online"></i> {{ $comment->name }}</span>
                                    <span class="message-data-time">{{ \App\Helpers\Helper::getTimeAgo($comment->created_at) }}</span>
                                </div>
                                <div class="message other-message">
                                    <div class="message__body">
                                        {!! nl2br(e($comment->comment_contents)) !!}
                                    </div>
                                    <div class="col-sm-2 btn__rep-comment">
                                        <button type="button" class="btn btn-custon-three btn-primary btn__reply__comment"
                                                data-user_id="{{ $comment->userId }}"
                                                data-product_id="{{ $comment->productId }}"
                                                data-id="{{ $comment->commentId }}">
                                            <i class="fa fa-reply" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-custon-three btn-danger btn__remove__comment"
                                                data-user_id="{{ $comment->userId }}"
                                                data-product_id="{{ $comment->productId }}"
                                                data-id="{{ $comment->commentId }}">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>

                        @if($repComments)
                            @foreach($repComments as $repComment)
                            <li class="clearfix comment__admin">
                                <div class="message-data align-right">
                                    <span class="message-data-name">Admin</span> <i class="fa fa-circle me"></i>
                                    <span class="message-data-time">{{ \App\Helpers\Helper::getTimeAgo($repComment->created_at) }}</span> &nbsp; &nbsp;
                                </div>
                                <div class="message my-message float-right">
                                    <div class="col-sm-10">
                                        {!! nl2br(e($repComment->comment_reply)) !!}
                                    </div>
                                    <div class="col-sm-2 btn__rep-comment">
                                        <button type="button" class="btn btn-custon-three btn-success btn__edit__comment__admin"
                                                data-id="{{ $repComment->id }}"
                                                data-comment_id="{{ $repComment->comment_id }}"
                                                data-comment_reply="{{ $repComment->comment_reply }}"
                                                data-product_id="{{ $repComment->product_id }}"
                                                data-user_id="{{ $repComment->user_id }}">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-custon-three btn-danger btn__remove__comment__admin"
                                                data-id="{{ $repComment->id }}"
                                                data-product_id="{{ $repComment->product_id }}"
                                                data-user_id="{{ $repComment->user_id }}">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        @endif
                    @endif
                @endforeach
            @endif
        </ul>
    </div>
</div>
