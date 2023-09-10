@extends('layout.admin.list_master')

@section('content')
    <?php $system_currency    = DB::table('system_settings')->select('description')->where('type', 'system_currency')->get()->first(); ?>

    <style>
        input{
           border-radius: 20px;
        }
        .avatar {
          vertical-align: middle;
          width: 50px;
          height: 50px;
          border-radius: 50%;
        }
        .imageUpload
        {
            display: none;
        }

        .profileImage
        {
            /* margin-top: -40px; */
            cursor: pointer;
            width: 100%;
        }

        #profile-container {
            margin: 20px auto;
            width: 130px;
            height: 130px;
            color: white;
            justify-content: center;
            border: 1px solid #8f8989;
            overflow: hidden;
        }

        #profile-container img {
            width: 150px;
            height: 150px;
           
        }
    </style>
    <!--**********************************
        Chat box End
    ***********************************-->
    
    <div class="content-body">
        <div class="container-fluid">
            <div class="col-md-12 mb-n5">
                <div class="col-sm-12 p-md-0">
                    <div class="col-sm-12 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        @section('titleBar')
                        <span class="ml-2">Manage Users System</span>
                        @endsection
                    </div>
                </div>

                <!-- row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="basic-form" style="width: 100%;">
                                    <legend style="float: right;"><a style="float: right;" class="btn btn-primary" href="{{url('/admin/users_system_add')}}"> Add Users </a></legend>
                                    <div class="table-responsive">
                                        <table id="example" class="table dt-responsive nowrap display min-w850">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Action</th>
                                                    <th>Status</th>
                                                    <th>ID</th>
                                                    <th>Role</th>
                                                    <th>Name</th>
                                                    <th>Mobile</th>
                                                    <th>Email</th>
                                                    <th>City</th>
                                                    <th>Address</th>
                                                    <th>Image</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($users as $key => $items)
                                                <tr class="odd gradeX">
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>
                                                        <?php if($items->users_system_id != session('id')){ ?>
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                                <button class="dropdown-item" type="button">
                                                                    <a href="{{url('/admin/users_system_edit/' . $items->users_system_id)}}"> Edit </a>
                                                                </button> 

                                                                <button class="dropdown-item" type="button">
                                                                    <a href="{{url('/admin/users_system_update/' . $items->users_system_id.'/Active')}}"> Active </a>
                                                                </button> 
                                                                
                                                                <button class="dropdown-item" type="button">
                                                                    <a href="{{url('/admin/users_system_update/' . $items->users_system_id.'/Inactive')}}"> Inactive </a>
                                                                </button>         

                                                                <button class="dropdown-item" type="button">
                                                                    <a href="{{url('/admin/users_system_delete/' . $items->users_system_id)}}"> Delete </a>
                                                                </button>                                      
                                                            </div>
                                                        </div>
                                                        <?php } else { ?>
                                                            N/A
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                        @if ($items->status=='Active')
                                                        <span class="btn btn-success">Active</span>
                                                        @elseif ($items->status=='Deleted')
                                                        <span class="btn btn-danger">Deleted</span>
                                                        @else 
                                                        <span class="btn btn-warning">In Active</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $items->users_system_id }}</td>
                                                    <td>
                                                        <?php $permissions = DB::table('users_system_roles')->where('users_system_roles_id', $items->users_system_roles_id)->get()->first(); ?>
                                                        {{ $permissions->name }}
                                                    </td>
                                                    <td>{{ $items->first_name }}</td>
                                                    <td>{{ $items->mobile }}</td>
                                                    <td>{{ $items->email }}</td>
                                                    <td>{{ $items->city }}</td>
                                                    <td>{{ $items->address }}</td>
                                                    <td> @if($items->user_image)  
                                                        <img src="{{ asset($items->user_image)}}" width="80px" height="80px">
                                                        @else
                                                        <img src="{{asset('uploads/placeholder/default.png')}}" height="80px" width="80px">
                                                        @endif
                                                    </td>
                                                    <td>{{ $items->created_at }}</td>
                                                    <td>{{ $items->updated_at }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection