<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Management</title>
    <style>
        #customers {
          font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }
        
        #customers td, #customers th {
          border: 1px solid #ddd;
          padding: 8px;
        }
        
        #customers tr:nth-child(even){background-color: #f2f2f2;}
        
        #customers tr:hover {background-color: #ddd;}
        
        #customers th {
          padding-top: 12px;
          padding-bottom: 12px;
          text-align: left;
          background-color: #4b5971;
          color: white;
        }
        </style>
</head>
<body>
    <table id="customers">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Role</th>
          <th>Status</th>
        </tr>

        @foreach ($users as $user)
            <tr>
                <td> {{$user->name}} </td>
                <td> {{$user->email}} </td>
                <td> {{Utils::getRoleText($user->role)}} </td>
                <td> {{$user->active==1?"Active":"Inactive"}} </td>
            </tr>
        @endforeach
      </table>
</body>
</html>