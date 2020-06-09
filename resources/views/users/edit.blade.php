@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Update User</div>
                <div class="card-body">
                    <form action={{route('users.update',[$user->id])}} method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"  placeholder="Enter Full Name" value="{{old('name', $user->name)}}"
                            ">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          
                        <div class="form-group">
                          <label>Email address</label>
                          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="name@example.com" value="{{ old('email',$user->email) }}">
                          @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                          @enderror
                        </div>
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="+8801674248402" value="{{ old('phone_number',$user->phone_number) }}">
                        </div>
                        <input type="hidden" name="customer_id" value={{Auth::user()->customer->id}}>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" value="1" {{ old('active', $user->active)== 1 ? 'checked' : '' }} />

                                <label class="form-check-label">Active</label>
                              </div>
                              <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="active" value="0" {{ old('active', $user->active)== 0 ? 'checked' : '' }} />
                                <label class="form-check-label">Inactive</label>
                              </div>
                        </div>
                        {{-- <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" value="{{ old('password') }}">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" @error('password_confirmation') is-invalid @enderror name="password_confirmation" placeholder="Confirm Password">
                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> --}}

                        <button type="submit" class="btn btn-primary" style="width:100%;">Update</button>
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection