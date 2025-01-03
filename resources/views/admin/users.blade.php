@extends('layout.design') <!-- Assuming you have a base layout -->

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Users</h1>
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">User List</h4>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <!-- <a href="{{ url('/users/' . $user->id . '/edit') }}" class="btn btn-sm btn-primary">Edit</a> -->
                            <form action="{{ url('/admin/users/' . $user->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE') <!-- This tells Laravel to treat this form as a DELETE request -->
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links('pagination::bootstrap-4') }} <!-- Bootstrap-styled pagination -->
        </div>
    </div>
</div>
@endsection