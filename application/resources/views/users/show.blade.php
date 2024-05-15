<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .user-details {
            margin: 0 auto;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;  /* Add rounded corners (optional) */
        }

        .user-details img {
            display: block;  /* Display photo as a block element */
            margin: 0 auto 20px auto;  /* Center photo horizontally and add bottom margin */
            max-width: 300px;  /* Increase photo width */
            max-height: 300px;  /* Increase photo height */
            /* Removed border-radius: 50%; to remove rounded corners */
        }

        .user-details ul {
            margin: 0;  /* Remove default list margins */
            padding: 0;  /* Remove default list padding */
        }

        .user-details li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .user-details li strong {
            font-weight: bold;
            width: 120px;
        }

        .edit-link {
            background-color: #4CAF50; /* Green */
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            position: absolute;
            top: 10px;
            right: 10px; /* Positions the button at top right */
        }

        .edit-link:hover {
            background-color: #45A049; /* Green Hover */
        }
    </style>
</head>
<body>

<h1>User Details</h1>

<div class="user-details">
    @if (@$user->filemanager)
        <img src="{{ url($user->filemanager->file_link) }}" alt="{{ $user->firstname }} profile photo">
    @else
        <p>No photo available</p>
    @endif

    <ul>
        <li>
            <strong>Prefix Name:</strong> {{ $user->prefixname }}
        </li>
        <li>
            <strong>First Name:</strong> {{ $user->firstname }}
        </li>
        <li>
            <strong>Middle Name:</strong> {{ $user->middlename }}
        </li>
        <li>
            <strong>Last Name:</strong> {{ $user->lastname }}
        </li>
        <li>
            <strong>Suffix Name:</strong> {{ $user->suffixname }}
        </li>
        <li>
            <strong>Username:</strong> {{ $user->username }}
        </li>
        <li>
            <strong>Email:</strong> {{ $user->email }}
        </li>
        <li>
            <strong>Type:</strong> {{ $user->type }}
        </li>
    </ul>
</div>

<a href="{{ route('users.edit', $user->id) }}" class="edit-link">Edit User</a>

</body>
</html>
