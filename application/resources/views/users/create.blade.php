<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create New User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        /* Optional: Additional form styling (e.g., form width) */
        .form {
            width: 600px; /* Adjust as needed */
            margin: 0 auto; /* Center the form horizontally */
        }
    </style>
</head>
<body>

<h1 class="text-center mb-4">Create New User</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="form">
    @csrf

    <div class="form-group mb-3">
        <label for="prefixname">Prefix Name:</label>
        <input type="text" name="prefixname" id="prefixname" class="form-control" value="{{ old('prefixname') }}">
    </div>

    <div class="form-group mb-3">
        <label for="firstname">First Name:</label>
        <input type="text" name="firstname" id="firstname" class="form-control" required value="{{ old('firstname') }}">
    </div>

    <div class="form-group mb-3">
        <label for="middlename">Middle Name:</label>
        <input type="text" name="middlename" id="middlename" class="form-control" value="{{ old('middlename') }}">
    </div>

    <div class="form-group mb-3">
        <label for="lastname">Last Name:</label>
        <input type="text" name="lastname" id="lastname" class="form-control" required value="{{ old('lastname') }}">
    </div>

    <div class="form-group mb-3">
        <label for="suffixname">Suffix Name:</label>
        <input type="text" name="suffixname" id="suffixname" class="form-control" value="{{ old('suffixname') }}">
    </div>

    <div class="form-group mb-3">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" class="form-control" required value="{{ old('username') }}">
    </div>

    <div class="form-group mb-3">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
    </div>

    <div class="form-group mb-3">
        <label for="photo">Photo:</label>
        <input type="file" name="photo" id="photo" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="type">Type:</label>
        <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}">
    </div>

    <div class="form-group mb-3">
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Create User</button>

</form>


</body>
</html>
