@extends('layouts.app')

@section('content')
<div class="container">
    <h3>My Todos</h3>
        
    <a href="{{ route('todos.create') }}" class="btn btn-primary mb-3">Create New Todo</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>User Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($todos as $index=> $todo)
                <tr>
                    <td>{{ $index+1}}</td>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->description }}</td>
                    <td>{{ Auth::id() === $todo->user_id ? 'Authorized' : 'Unauthorized' }}</td>
                    <td>{{ $todo->user->name ?? 'Unknown' }}</td>
                    <td>
                        @if(Auth::id() === $todo->user_id)
                            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @else
                            <button class="btn btn-warning btn-sm unauthorized-action">Edit</button>
                            <button class="btn btn-danger btn-sm unauthorized-action">Delete</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const unauthorizedButtons = document.querySelectorAll('.unauthorized-action');
        unauthorizedButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Unauthorized',
                    text: 'You are not authorized to perform this action.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });
    });
</script>
@endpush

@endsection
