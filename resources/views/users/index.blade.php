@extends('layouts.app')

@section('content')
    <div class="container-xxl"> 
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">                      
                                <h4 class="card-title">Users</h4>                      
                            </div><!--end col-->
                            <div class="col-auto"> 
                                <form class="row g-2">
                                    <div class="col-auto">
                                        <a class="btn bg-primary-subtle text-primary dropdown-toggle d-flex align-items-center arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" data-bs-auto-close="outside">
                                            <i class="iconoir-filter-alt me-1"></i> Filter
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-start">
                                            <div class="p-2">
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-all">
                                                    <label class="form-check-label" for="filter-all">
                                                      All 
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-one">
                                                    <label class="form-check-label" for="filter-one">
                                                        New
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-two">
                                                    <label class="form-check-label" for="filter-two">
                                                        VIP
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-three">
                                                    <label class="form-check-label" for="filter-three">
                                                        Repeat
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-four">
                                                    <label class="form-check-label" for="filter-four">
                                                        Referral
                                                    </label>
                                                </div>
                                                <div class="form-check mb-2">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-five">
                                                    <label class="form-check-label" for="filter-five">
                                                        Inactive
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" checked id="filter-six">
                                                    <label class="form-check-label" for="filter-six">
                                                        Loyal
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    
                                    <div class="col-auto">
                                        @can('create users')
                                            <a class="btn btn-primary" href="{{ route('user.create') }}">
                                                <i class="fa-solid fa-plus me-1"></i> Add Users
                                            </a>
                                        @endcan
                                    </div><!--end col-->
                                </form>    
                            </div><!--end col-->
                        </div><!--end row-->                                  
                    </div><!--end card-header-->
                    <div class="card-body pt-0">
                        
                        <div class="table-responsive">
                            <table class="table mb-0 checkbox-all" id="datatable_1">
                                <thead class="table-light">
                                  <tr>
                                    <th>No</th>
                                    <th class="ps-2">Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    @can('edit users')
                                        <th class="text-end">Action</th>
                                    @endcan
                                  </tr>
                                </thead>
                                <tbody>
                                    @if ($rows)
                                    @php($i = 1)
                                        @foreach ( $rows as $user )
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $user['name'] }}</td>
                                                <td>{{ $user['email'] }}</td>
                                                <td>{{ $user['password'] }}</td>
                                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                                <td class="text-end">
                                                    @can('edit users')
                                                        <a href="{{ route('user.edit', $user -> id) }}"><i class="las la-pen text-secondary fs-18"></i></a>
                                                    @endcan
                                                    @can('delete users')
                                                        <a href="{{ route('user.delete', $user -> id) }}"><i class="las la-trash-alt text-secondary fs-18"></i></a>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->                                     
    </div><!-- container -->
@endsection