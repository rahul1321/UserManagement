@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Notifications</div>
                
                <div class="card-body">
                    <table class="table">
                        <thead class="thead">
                          <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Notification</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach(auth()->user()->notifications as $notification)
                                <tr>
                                    <td>{{$notification->created_at->diffForHumans()}}</td>
                                    <td>{{$notification->data['message']}}</td>
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