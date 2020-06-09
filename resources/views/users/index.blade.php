@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header"><b> Customer Name: </b>{{auth()->user()->customer->name}}</div>
                @can('create',\App\Entities\User::class)
                    <div style="width: 100%;text-align:center; padding:5px;"><a href="{{route('users.create')}}"><button class="btn add-button">Add User</button></a></div>
                @endcan
                <div class="card-body">
                    <table class="table">
                        <thead class="thead">
                          <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td><a class="username" href={{route('users.show',[$user->id])}}>{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>{{Utils::getRoleText($user->role)}}</td>
                                    <td>{{$user->active==1?"Active":"Inactive"}}</td>
                                    <td class="row">
                                        @can('update', $user)
                                        <a style="color:#fff;" href={{route('users.edit',[$user->id])}}><button style="background: #1b3d58;color:#fff;" class="btn btn-info btn-sm">Edit</button></a> 
                                        @endcan
                                        
                                        @can('delete',\App\Entities\User::class)
                                        <form action="{{route('users.destroy',[$user->id])}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" style="margin-left: 5px;">Delete</button>
                                        </form>
                                        @endcan
                                        @if (Auth::user()->id !== $user->id)
                                            <a style="color:#fff;" href={{route('chats.show',[$user->id])}}><button style="background: #1b3d58;color:#fff;" class="btn btn-info btn-sm">Chat</button></a> 
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                          
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection