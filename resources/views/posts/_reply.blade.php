<div class="reply-card p-3 mb-2">
    <div class="d-flex justify-content-between align-items-start">
        <div class="d-flex gap-2">
            <div class="avatar sm">{{ strtoupper(mb_substr($reply->user->nom, 0, 1)) }}</div>
            <div>
                <strong class="d-block" style="color: var(--ink-900);">{{ $reply->user->nom }}</strong>
                <small class="text-muted">
                    <i class="bi bi-clock"></i> {{ $reply->created_at->diffForHumans() }}
                </small>
            </div>
        </div>

        @if(auth()->check() && auth()->user()->isAdmin())
        <form method="POST" action="{{ route('admin.comments.destroy', $reply) }}"
            class="d-inline" onsubmit="return confirm('Supprimer cette réponse ?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-outline-danger border-0"><i class="bi bi-trash"></i></button>
        </form>
        @endif
    </div>
    <p class="mb-0 mt-2 ms-1">{{ $reply->contenu }}</p>
</div>
