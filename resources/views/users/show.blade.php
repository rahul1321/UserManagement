@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header">{{$user->name}}</div>

                <div class="card-body" style="font-size: 20px">
                    <div class="row" style="margin: 20px">
                        <div>Email:</div>
                        <div style="margin-left: 10px">{{$user->email}}</div>
                    </div>
                    <div class="row" style="margin: 20px">
                        <div>Status:</div>
                        <div style="margin-left: 10px">{{$user->active==0?"Inactive":"Active"}}</div>
                    </div>
                    <div class="row" style="margin: 20px">
                        <div>Customer:</div>
                        <div style="margin-left: 10px">{{$user->customer->name}}</div>
                    </div>
                    <div class="row" style="margin: 20px">
                        <div>Phone:</div>
                        <div style="margin-left: 10px">{{$user->phone_number}}</div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
</div>
@endsection