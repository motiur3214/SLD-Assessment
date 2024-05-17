<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
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
</x-guest-layout>
