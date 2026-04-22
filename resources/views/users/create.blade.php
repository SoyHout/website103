@extends('layouts.app')
@section('content')
    <div class="container-xxl">   
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Create Users</h4>                      
                            </div><!--end col-->
                        </div>  <!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        <form enctype="multipart/form-data" id="form-validation-2" class="form" method ="POST" action = "{{  route('user.store')  }}">
                            @csrf
                            <div class="mb-2">
                                <label for="name" class="form-label">User Name</label>
                                <input name="name" class="form-control" type="text" rows="2" placeholder="Name">
                                {{-- <small>Error Message</small> --}}
                            </div>
                            <div class="mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input name = "email" class = "form-control" type="email" placeholder="Email" required>
                            </div>
                            <div class="mb-2">
                                <label for="roles" class="form-label">Roles</label>
                                <select name="roles">
                                        <option value="">Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input name = "password" class = "form-control" type="password" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form><!--end form-->            
                    </div><!--end card-body--> 
                </div><!--end card--> 
            </div> <!--end col-->                                                                                
        </div><!--end row-->
    </div><!-- container -->
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif