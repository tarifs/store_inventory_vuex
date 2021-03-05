@extends('layouts.master')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">User List</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> Add User</a><br><br>
                            <h5 class="card-title">User List</h5><br>
                            <table class="table table-bordered datatable">
                                <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($users)
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $user->name ?? '' }}</td>
                                            <td>{{ $user->email ?? '' }} @if(auth()->id() == $user->id) (you) @endif</td>
                                            <td>{{ $user->created_at->format('yy-m-d') ?? '' }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                @if(auth()->id() != $user->id)
                                                    <a href="javascript:;" class="btn btn-sm btn-danger sa-delete" data-form-id="user-delete-{{ $user->id }}">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>

                                                    <form id="user-delete-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('DELETE')

                                                    </form>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                        </div>
                    </div><!-- /.card -->
                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection
