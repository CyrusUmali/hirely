@extends('layout.design')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Listings</h1>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">All Listings</h4>
        </div>
        <div class="card-body">
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($listings as $listing)
                    <tr>
                        <td>{{ $listing->id }}</td>
                        <td>{{ $listing->title }}</td>
                        <td>{{ $listing->description }}</td>
                        <td>
                            <!-- You can add Edit button here -->
                            <form action="{{ route('admin.deleteListing', $listing->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE') <!-- This makes the form treat it as a DELETE request -->
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $listings->links('pagination::bootstrap-4') }} <!-- Pagination links -->
        </div>
    </div>
</div>
@endsection
