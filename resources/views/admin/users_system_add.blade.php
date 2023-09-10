@extends('layout.admin.list_master')

@section('content')
    <style>
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
        .error{
            color: red;
        }

        .errorto{
            color: red;
            background-color: rgb(244, 198, 198);
            padding-top: 15px;
            padding-bottom: 15px; 
            text-align: center;
        }

        .bootstrap-select {
            border: 10px solid red;
        }
    </style>
	<!--**********************************
           Chat box End
    ***********************************-->
    
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mb-n5">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <!-- <h4>Hi, welcome back!</h4> -->
                     
                        {{-- <p class="mb-0">Validation</p> --}}
                    </div>
                </div>
                <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                    <ol class="breadcrumb">
                        @section('titleBar')
                        <span class="ml-2">Add System Users</span>
                        @endsection               
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="basic-form">
                                <form action="/admin/users_system_add_data" method="POST" id="myform" name="myform" onsubmit="return validation()" enctype="multipart/form-data">
                                    @csrf
                                    <legend class="row col-md-12"> Add System Users</legend>

                                    <div class="row col-md-12"> 
                                        <div class="form-group col-md-6">
                                            <b>Select Roles</b>
                                            <b>
                                                <select style="border:1px solid" name="users_system_roles_id" class="form-control" required>
                                                    <?php foreach($roles as $role){ ?>
                                                    <option value="{{$role->users_system_roles_id}}">{{$role->name}}</option>
                                                    <?php } ?>
                                                </select>
                                            </b>
                                        </div>
                                    </div>

                                    <div class="row col-md-12"> 
                                        <div class="form-group col-md-6">
                                            <b>First Name</b>
                                            <b><input style="border:1px solid" type="text" name="first_name" class="form-control" placeholder="Enter Name" required></b>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <b>Email</b>
                                            <b><input style="border:1px solid" type="email" name="email" class="form-control" placeholder="Enter Email" required></b>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <b>Password</b>
                                            <b><input style="border:1px solid" type="password" name="password" class="form-control" placeholder="Enter Password" required></b>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <b>Mobile</b>
                                            <b><input style="border:1px solid" type="text" name="mobile" class="form-control" placeholder="Enter Mobile" required></b>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <b>City</b>
                                            <b><input style="border:1px solid" type="text" name="city" class="form-control" placeholder="Enter City" required></b>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <b>Address</b>
                                            <b><textarea style="border:1px solid" name="address" class="form-control" placeholder="Enter Address" required></textarea></b>
                                        </div>
                                    </div>

                                    <div class="row col-md-12"> 
                                        <div class="form-group col-md-6">
                                            <b>Status</b>
                                            <b>
                                                <select style="border:1px solid" name="status" class="form-control" required>
                                                    <option value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </b>
                                        </div>
                                        
                                        <div class="row col-md-6"> 
                                            <div id="profile-container">
                                                <image id="imagePreview" class="imagePreview" src="{{asset('images/otp.png')}}" />
                                            </div>
                                            <input id="imageUpload" class="imageUpload" type="file" name="image" placeholder="Image" onchange="loadFile(event)" capture>
                                            <label id="empty"></label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary px-5 float-right mt-4">Save</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
		    </div>
        </div>
    </div>
					
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $("#imagePreview").click(function(e) {
            $("#imageUpload").click();
        });

        function loadFile(event) {
        	var image = document.getElementById('imagePreview');
        	image.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection