@extends('admin.layout')
@section('title', 'Commentaires')

@section('content')
<h3 class="mb-4">Modération des commentaires</h3>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>Auteur</th><th>Article</th><th>Commentaire</th><th>Date</th><th>Action</th></tr>
    </thead>
    <tbody>
        @forelse($comments as $comment)
        <tr>
            <td>{{ $comment->user->name }}</td>
            <td>
                <a href="{{ route('posts.show', $comment->post->slug) }}" target="_blank">
                    {{ Str::limit($comment->post->title, 40) }}
                </a>
            </td>
            <td>{{ Str::limit($comment->body, 80) }}</td>
            <td>{{ $comment->created_at->format('d/m/Y H:i') }}</td>
            <td>
                <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                    onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center text-muted">Aucun commentaire.</td></tr>
        @endforelse
    </tbody>
</table>
{{ $comments->links() }}
@endsection
