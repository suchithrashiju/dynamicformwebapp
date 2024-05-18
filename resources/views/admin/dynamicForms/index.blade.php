@extends('layouts.admin-dashboard')

@section('content')
    <div class="container">
        <h1>Dynamic Forms List</h1>
        <a href="{{ route('admin.dynamicForms.create') }}" class="btn btn-primary">Create New Form</a>
        <br>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Form Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                    <tr>
                        <td>{{ $form->form_name }}</td>
                        <td>{{ $form->description }}</td>
                        <td>
                            <a href="{{ route('admin.dynamicForms.edit', $form->id) }}" class="btn btn-warning">Edit</a>
                            <form id="deleteForm{{ $form->id }}"
                                action="{{ route('admin.dynamicForms.destroy', $form->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger"
                                    onclick="confirmDelete({{ $form->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function confirmDelete(formId) {
            if (confirm('Are you sure you want to delete this form?')) {
                document.getElementById('deleteForm' + formId).submit();
            }
        }
    </script>
@endsection
