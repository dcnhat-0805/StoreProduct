@if(count($comments))
<div class="comment__body sop__common_form sop__comment_list">
@foreach($comments as $key => $comment)
    @php
        $commentProducts = \App\Models\Comment::getCommentByUserIdAndProductId($comment->user_id, $comment->product_id);
        $user = \App\Models\User::showUser($comment->user_id);
    @endphp

    <div class="comment-item">
        <div class="comment-avatar">
            <div class="avatar">{{ $user->name[0] }}</div>
        </div>
        <div class="comment-info">
            <div class="comment-title">
                <div class="comment-name">
                    <div class="name">{{ $user->name }}</div>
                </div>
                @if(\App\Helpers\Helper::getPointRatingByUserIdAndProductId($comment->user_id, $comment->product_id))
                    <div class="comment-star">
                        <div class="jsStarsComment{{ $key }}" style="pointer-events: none"></div>
                    </div>
                @endif
            </div>
            @foreach($commentProducts as $key => $commentProduct)
                @php
                    $repComments = \App\Models\ReplyComment::getCommentReply($commentProduct->commentId);
                @endphp
                <div class="comment-content" data-id="{{ $commentProduct->commentId }}">{!! nl2br(e($commentProduct->comment_contents)) !!}</div>
                <div class="comment-footer">
                    <div class="comment-like">
                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                        <span class="value_like">0</span>
                        <span class="action">Like</span>
                    </div>
                    <div class="time">{{ App\Helpers\Helper::getTimeAgo($commentProduct->created_at) }}</div>
                </div>

                @if(count($repComments))
                    <div class="comment-child-list">
                        <div class="comment-child-item">
                            <div class="comment-avatar">
                                <div class="avatar">AD</div>
                            </div>
                            <div class="comment-info">
                                <div class="comment-title">
                                    <div class="comment-name">
                                        <div class="name">Admin</div>
                                    </div>
                                </div>
                                @foreach($repComments as $repComment)
                                    <div class="comment-content">{!! nl2br(e($repComment->comment_reply)) !!}</div>
                                @endforeach
                                <div class="comment-footer">
                                    <div class="comment-like" data-id="66539">
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <span class="value_like">0</span>
                                        <span class="action">Like</span>
                                    </div>
                                    <div class="time">{{ App\Helpers\Helper::getTimeAgo($repComment->created_at) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endforeach
<script>
    $(document).ready(function () {

        const MAX_RATE = 5;
        const MIN_RATE = 1;

        @if(!empty($comments))
            @for($i = 0; $i < count($comments); $i++)
                @if(App\Helpers\Helper::getPointRatingByUserIdAndProductId($comments[$i]->user_id, $comments[$i]->product_id))
                    $('.jsStarsComment' + {{ $i }}).stars({
                        stars : MAX_RATE,
                        value : {{ App\Helpers\Helper::getPointRatingByUserIdAndProductId($comments[$i]->user_id, $comments[$i]->product_id) }}
                    });
                @endif
            @endfor
        @endif
    });
</script>
</div>
@endif
