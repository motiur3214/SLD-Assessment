<!DOCTYPE html>
<html lang="en">
<head>
    <title>Users List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {

            font-family: sans-serif;
        }

        .new-user-button, .trashed-user-button {
            background-color: #007bff; /* Blue */
            border: none;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            margin-right: 10px; /* Adjusted spacing between buttons */
        }

        .trashed-user-button {
            background-color: #6c757d; /* Gray for differentiation */
        }

        .new-user-button:hover, .trashed-user-button:hover {
            background-color: #0062cc; /* Blue Hover */
        }

        .container {
            position: relative;
            margin-top: 40px;
        }

        .new-user-button, .trashed-user-button {
            position: relative;
            top: 0;
        }

        .trashed-user-button {
            right: 0;
        }


    </style>
</head>
<body>
@include('layouts.navigation')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('users.create') }}" class="new-user-button">New User</a>
        <a href="{{ route('users.trashed') }}" class="trashed-user-button">Trashed Users</a>
    </div>

    <h1>Users List</h1>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>firstname</th>
            <th>lastname</th>
            <th>Email</th>
            <th>Photo</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->firstname }}</td>
                <td>{{ $user->lastname }}</td>
                <td>{{ $user->email }}</td>
                @if (@$user->filemanager)
                    <td><img src="{{url($user->avatar)}}" alt="{{ $user->firstname }} profile photo" width="50"
                             height="50"></td>
                @else
                    <td>No photo available</td>
                @endif
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-primary">Show Details</a>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('users.softDelete', ['id' => $user->id]) }}" method="POST"
                          style="display: inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user?')">Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
