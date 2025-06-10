@can('view comments')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Комментарии ({{ $comments->count() }})</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body card-comments">
            @foreach ($comments as $comment)
                <div class="card-comment" id="comment-{{ $comment->id }}">
                    <!-- User image -->
                    <img class="img-circle img-sm" src="{{ $comment->user->ava }}" alt="User Image">
                    <div class="comment-text">
                        <span class="username">
                            @include('components.user-link', ['user' => $comment->user])
                            <span class="text-muted">
                                &middot; {{ $comment->created_at }}
                                &middot; <a href="#comment-{{ $comment->id }}">#{{ $comment->id }}</a>
                                @if ($comment->parent_id)
                                    &middot; в ответ
                                    <a href="#comment-{{ $comment->parent_id }}">#{{ $comment->parent_id }}</a>
                                @endif
                                @if ($external = App\Helpers\CommentHelper::getExternal($comment, $commentable))
                                    &middot; {{ $external['preamble'] }}
                                    <a href="{{ $external['href'] }}">{{ $external['text'] }}</a>
                                @endif
                            </span>
                            <span class="float-right">
                                @can('create comments')
                                    <button type="button" class="btn btn-link" onclick="selectReply({{ $comment->id }})">
                                        <i class="fas fa-reply"></i>
                                    </button>
                                @endcan
                                @if (App\Helpers\CommentHelper::canEdit($comment))
                                    <a href="{{ route('comments.edit', $comment->id) }}" class="btn btn-link">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endif
                                @if (App\Helpers\CommentHelper::canDelete($comment))
                                    <button type="submit" class="btn btn-link btn-delete"
                                        form="destroy-comment-{{ $comment->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <form method="POST" action="{{ route('comments.destroy', $comment->id) }}"
                                        id="destroy-comment-{{ $comment->id }}" hidden>
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @endif
                            </span>
                        </span><!-- /.username -->
                        {{ $comment->text }}
                    </div>
                    <!-- /.comment-text -->
                </div>
                <!-- /.card-comment -->
            @endforeach
            @if ($comments->isEmpty())
                <div class="card-comment text-center">Комментариев нет.</div>
            @endif
            {{ $comments->links('vendor.pagination.bootstrap-4') }}
            <!-- /.card-body -->
            @can('create comments')
                <div class="card-footer">
                    <form method="POST" action="{{ route('comments.store') }}">
                        @csrf
                        <input type="hidden" name="commentable_type" value="{{ get_class($commentable) }}">
                        <input type="hidden" name="commentable_id" value="{{ $commentable->id }}">
                        <input type="hidden" name="parent_id" id="comment-reply-id" value="">
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control form-control-sm" name="text"
                                placeholder="Введите текст комментария" minlength="2" required>
                            <span class="input-group-append">
                                <button type="button" class="btn btn-warning btn-flat" id="comment-reply-btn"
                                    onclick="cancelReply()" hidden>
                                    В ответ
                                    <i class="fas fa-times"></i>
                                </button>
                                <button type="submit" class="btn btn-info btn-flat">Отправить</button>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- /.card-footer -->
            @endcan
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <script>
        let selectReply = (commentId) => {
            cancelReply();
            Elem.id(`comment-${commentId}`).classList.add('bg-warning');
            Elem.id(`comment-reply-id`).value = commentId;
            Elem.id('comment-reply-btn').hidden = false;
        };

        let cancelReply = () => {
            let commentId = Elem.id(`comment-reply-id`).value;
            if (!commentId)
                return;
            Elem.id(`comment-${commentId}`).classList.remove('bg-warning');
            Elem.id(`comment-reply-id`).value = '';
            Elem.id('comment-reply-btn').hidden = true;
        };
    </script>
@endcan
