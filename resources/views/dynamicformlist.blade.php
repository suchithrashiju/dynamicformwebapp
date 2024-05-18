@extends('layouts.home')

@section('content')
    <div class="container">
        <a href="{{ route('admin.login') }}" class="btn btn-primary">Admin Login</a>

        <h1>Dynamic Forms</h1>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($forms as $form)
                    <tr>
                        <td>{{ $form->form_name }}</td>
                        <td>{{ $form->description }}</td>
                        <td>
                            <a href="{{ route('show', $form->id) }}" class="btn btn-warning">View & Submit</a>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
