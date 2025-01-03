@extends('layout.design') <!-- Assuming you have a base layout -->

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Comments</h1>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Comment List</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Author</th>
                        <th>Target User</th>
                        <th>Content</th>
                        <th>Posted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
    @foreach ($comments as $comment)
    <tr>
        <td>{{ $comment->id }}</td>
        <td>{{ $comment->author->name ?? 'Unknown User' }}</td> <!-- Author Name -->
        <td>{{ $comment->targetUser->name ?? 'Unknown User' }}</td> <!-- Target User Name -->
        <td>{{ $comment->content }}</td>
        <td>{{ $comment->created_at->format('M d, Y H:i') }}</td>
        <td>
            <form action="{{ url('/admin/comments/' . $comment->id) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</tbody>

            </table>
        </div>
        <div class="card-footer">
            {{ $comments->links('pagination::bootstrap-4') }} <!-- Bootstrap-styled pagination -->
        </div>
    </div>
</div>
@endsection
