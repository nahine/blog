<div class="comment-card p-3 p-md-4 mb-3" id="comment-{{ $comment->id }}">
    <div class="d-flex justify-content-between align-items-start mb-2">
        <div class="d-flex gap-3">
            <div class="avatar">{{ strtoupper(mb_substr($comment->user->name, 0, 1)) }}</div>
            <div>
                <strong class="d-block" style="color: var(--ink-900);">{{ $comment->user->name }}</strong>
                <small class="text-muted">
                    <i class="bi bi-clock"></i> {{ $comment->created_at->diffForHumans() }}
                </small>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
            class="d-inline" onsubmit="return confirm('Supprimer ce commentaire ?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
        </form>
        @endif
    </div>

    <p class="mb-3 ms-1">{{ $comment->body }}</p>

    @auth
    <button class="btn btn-sm btn-outline-brand" type="button" onclick="toggleReply({{ $comment->id }})">
        <i class="bi bi-reply"></i> Répondre
    </button>

    <div class="mt-3" id="reply-{{ $comment->id }}" style="display: none;">
        <form method="POST" action="{{ route('comments.reply', $comment) }}"
            class="reply-form" data-comment="{{ $comment->id }}">
            @csrf
            <div class="mb-2">
                <textarea name="body" class="form-control" rows="2"
                    placeholder="Votre réponse..." required minlength="2"></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-brand">
                    <i class="bi bi-send"></i> Envoyer
                </button>
                <button type="button" class="btn btn-sm btn-light border"
                    onclick="toggleReply({{ $comment->id }})">Annuler</button>
            </div>
        </form>
    </div>
    @endauth

    <div class="mt-3 ms-md-4" id="replies-{{ $comment->id }}">
        @foreach($comment->replies as $reply)
            @include('posts._reply', ['reply' => $reply])
        @endforeach
    </div>
</div>
