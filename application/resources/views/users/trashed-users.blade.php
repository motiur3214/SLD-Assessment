<!DOCTYPE html>
<html lang="en">
<head>
    <title>Trashed Users List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            font-family: sans-serif;
        }

        /* Action buttons styling */
        .action-buttons {
            display: flex; /* Make buttons appear side-by-side */
        }

        .action-buttons button {
            margin-right: 5px; /* Add some spacing between buttons */
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
                    <td><img src="{{url($user->avatar)}}" alt="{{ $user->firstname }} profile photo"
                             width="50" height="50"></td>
                @else
                    <td>No photo available</td>
                @endif
                <td>
                    <div class="action-buttons">
                        <form action="{{ route('users.restore', $user->id) }}" method="POST">
                            @csrf  @method('PATCH')  <button type="submit" class="btn btn-success">Restore</button>
                        </form>
                        <form action="{{ route('users.delete', $user->id) }}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user? (This action is reversible)');">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
