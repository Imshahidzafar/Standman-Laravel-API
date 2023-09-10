@extends('layout.admin.list_master')
@section('content')
    <style>
        .btn-light{
          padding-left:10px;
        }
        .space {
         margin-left: 5px; 
        }
    </style>
    <!-- View User -->
    
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body p-0">
                {{-- <a href="javascript:void(0);" class="bg-primary text-white text-center p-4 fs-20 d-block rounded" data-toggle="modal" data-target="#addMoreTraining">+ Add more training</a> --}}
                <!-- Modal -->
                <div class="modal   fade" id="viewUsersCustomersModal">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h2>User Detail</h2>
                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                
                                <br>
                                <div class="row">
                                    <div class="col-3 first_name">
                                        <b>First Name: </b>
                                        <br> 
                                        <!-- $event_posts.event_post_id -->
                                        <label id="first_name"></label>
                                    </div>
                                    <div class=" col-3 last_name">
                                     
                                        <b>Last Name: </b>
                                        <br> 
                                        <!-- $event_posts.event_post_id -->
                                        <label id="last_name"></label>
                                    </div>
                                    <div class="col-sm-3 users_customers_type">
                                   
                                        <b>User Customer Type: </b>
                                        <br> 
                                        <label id="users_customers_type"></label>
                                    </div>
                                </div>
                                   
                                <div class="row">
                                    <div class="col-sm-3 phone">
                                    <br>
                                        <b>User Phone: </b>
                                        <br> 
                                        <!-- $event_posts.event_post_id -->
                                        <label id="phone"></label>
                                    </div>
                                    <div class="col-sm-3 email">
                                    <br>
                                        <b>Email:</b>
                                        <br> 
                                        <label  id="email"></label>
                                    </div>
                                    <div class="col-sm-3 notifications">
                                    <br>
                                        <b>Notifications:</b>
                                        <br> 
                                        <label  id="notifications"></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 account_type">
                                    <br>
                                    <b>Account Type:</b>
                                    <br> 
                                        <label id="account_type"></label>
                                    </div>
                                    <div class="col-sm-3 social_acc_type">
                                    <b>Social Account Type:</b>
                                    <br> 
                                        <label id="social_acc_type"></label>
                                    </div>
                                </div>
                                    <br>
                                <div class="row">
                                    <div class="col-sm-3 profile_pic">
                                        <b>profile_pic:</b>  
                                  
                                        <br>
                                        <br>
    
                                            <img src="" style="height: 290px; width: 55%; border:rounded;" class="rounded" id="profile_pic">
                                    </div> 
                                    <div class="col-sm-3 proof_document">
                                        <b>proof_document:</b>  
                                  
                                        <br>
                                        <br>
    
                                            <img src="" style="height: 290px; width: 55%; border:rounded;" class="rounded" id="proof_document">
                                    </div> 
                                   
                                    <div class="col-sm-3 valid_document">
                                        <b>valid_document:</b>  
                                  
                                        <br>
                                        <br>
    
                                            <img src="" style="height: 290px; width: 55%; border:rounded;" class="rounded" id="valid_document">
                                    </div> 
                                </div>
                                    <br>
                                    <br>
                                <div class="row pb-4">
                                    <div class="col-sm-3 date_added">
                               
                                     <b>Date Added:</b>
                                 <br>
                                    <label id="date_added"></label>
                                  

                                    </div>
                                    <div class="col-sm-4 one_signal_id">
                                   
                                   <b>One Signal Id:</b>
                                   <br>
                                   
                                  <label id="one_signal_id"></label>
                                  </div>   
                                    
                                    <br>
                                    <div class="col-3 status">
                                     <b>Status:</b>
                                    <br>
                                    <label id="status"></label>
                                    </div>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
    </div>
    <!-- View User -->

    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles mb-n5">
				<ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Manage Users</span>
                    @endsection
				</ol>
            </div>
            <!-- row -->

            <div class="row">
                <div class="col-12">
                    <span id="filter_d"></span>    
                    <br>

                    <div class="card">
                        <div class="card-body">             
                            <div class="table-responsive">
                                <table id="example" class="table dt-responsive nowrap display min-w850">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Account Type</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
          	</div>
        </div>
    </div>
    <script src="{{ url('/public/users/assets/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.ui.min.js') }}"></script>
    <script src="{{ url('/public/users/assets/js/jquery.additional.methods.js') }}"></script>
    <script>
        $(document).ready(function(){
            var filter = '';
                console.log(filter);
                fetch();
            $(document).on('click', '#filter_data', function() {
                var filter = '';
                console.log(filter);
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Pending', function() {
                var filter = 'Pending';
                console.log(filter);
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Active', function() {
                var filter = 'Active';
                console.log(filter);
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Inactive', function() {
                var filter = 'Inactive';
                console.log(filter);
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Deleted', function() {
                var filter = 'Deleted';
                console.log(filter);
                fetch(filter);
            });
            function fetch(filter) {

                var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/users_customers_fetch",
                    "url":  "users_customers_fetch",
                    "method": "GET",
                    "timeout": 0,
                    "data": {
                        'filter':filter,
                    },
                };

                $.ajax(settings).done(function (response) {
                                $('tbody').html("");
                                $('#filter_d').html("");
                                var filter = response.filter;                                    // Update the filter buttons
                                var filterButtons = '<button id="filter_data"class="btn ' + (filter === '' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px;">All</button>' +
                                '<button id="filter_data_Pending" class="btn ' + (filter === 'Pending' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Pending</button>' +
                                '<button id="filter_data_Active" class="btn ' + (filter === 'Active' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Active</button>' +
                                '<button id="filter_data_Inactive" class="btn ' + (filter === 'Inactive' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Inactive</button>' +
                                '<button id="filter_data_Deleted" class="btn ' + (filter === 'Deleted' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Deleted</button>';

                                    
                                    $('#filter_d').append(filterButtons);
                                $.each(response.usersCustomers, function (key, item) { 
    
                                    var statusHtml = '';
                                    if (item.status == "Pending") {
                                        statusHtml = '<span class="btn m-1 btn-info">Pending</span>';
                                    } else if (item.status == "Active") {
                                        statusHtml = '<span class="btn m-1 btn-success">Active</span>';
                                    } else if (item.status == "Inactive") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Inactive</span>';
                                    } else {
                                        statusHtml = '<span class="btn m-1 btn-danger">Deleted</span>';
                                    }

                                    var actionHtml = '';
                                    
                                        actionHtml += '<button class="btn m-1 btn-primary view_users_customer" value="' + item.users_customers_id + '">';
                                        actionHtml += '<i class="fa fa-eye"></i>';
                                        actionHtml += '</button>';
                                        
                                    if (item.status == "Active") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.users_customers_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        
                                    } else if (item.status == "Inactive") {
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.users_customers_id + '" data-info="Active" >';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status == "Pending" || item.status == "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.users_customers_id + '" data-info="Inactive">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.users_customers_id + '" data-info="Active">';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status != "Deleted") {
                                        actionHtml += '<button class="btn m-1 btn-danger delete_data" value="' + item.users_customers_id + '" data-info="Deleted">';
                                        actionHtml += '<i class="fa fa-trash"></i>';
                                        actionHtml += '</button>';
                                    }
                                    var profile_image = "{{ url('/public') }}" + "/" +item.profile_pic;
                                    $('tbody').append('\
                                        <tr class="odd gradeX">\
                                        <td>' + (key+1) + '</td>\
                                        <td>' + item.users_customers_type + '</td>\
                                        <td><img src="'+profile_image+'" width="80px" height="80px"><span class="space">\
                                            '+ item.first_name + '</span>\
                                            <span class="space">'+ item.last_name + '</span></td>\
                                        <td>' + item.email + '</td>\
                                        <td>' + item.phone + '</td>\
                                        <td>' + statusHtml + '</td>\
                                        <td>' + actionHtml + '</td>\
                                        </tr>\
                                    ');
                                });
                });
            }
            $(document).on("click",'.delete_data', function (e) {
                    e.preventDefault();
                    var users_customers_id=$(this).val();;
                    var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/users_customer_delete",
                    "url":"users_customer_delete",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'users_customers_id':users_customers_id,
                    },
                };
                $.ajax(settings).done(function (response) {
                    if(response.status == "success"){ 
                        fetch();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                });
            });

            $(document).on("click",'.update_data', function (e) {
                    e.preventDefault();
                    var users_customers_id=$(this).val();
                    var status=$(this).data("info");
                    var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/users_customer_update",
                    "url": "users_customer_update",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'users_customers_id':users_customers_id,
                        'status':status,
                    },
                };
                $.ajax(settings).done(function (response) {
                    if(response.status == "success"){ 
                        fetch();
                        toastr.success(response.message);
                    }else{
                        toastr.success(response.message);
                    }
                });
            });


            $(document).on("click",'.view_users_customer', function (e) {
                e.preventDefault();
                var users_customers_id=$(this).val();
                $('#viewUsersCustomersModal').modal('show');
                var settings = {
                // "url": "{{ env('APP_URL') }}" + "admin/users_customer_edit/"+users_customers_id,
                "url":  "users_customer_edit/"+users_customers_id,
                "method": "GET",
                "timeout": 0,
            };
            $.ajax(settings).done(function (response) {
                        $('#UsersCustomersViewModal').html("");
                        if ($('.profile_pic').hasClass('d-none')) {
                            $('.profile_pic').removeClass('d-none');
                        }
                        if ($('.proof_document').hasClass('d-none')) {
                            $('.proof_document').removeClass('d-none');
                        }
                        if ($('.valid_document').hasClass('d-none')) {
                            $('.valid_document').removeClass('d-none');
                        }
                        if ($('.social_acc_type').hasClass('d-none')) {
                            $('.social_acc_type').removeClass('d-none');
                        }
                        if ($('.one_signal_id').hasClass('d-none')) {
                            $('.one_signal_id').removeClass('d-none');
                        }
                        if(response.status == "success"){
                            // console.log(response);
                            $('#first_name').html(response.data.first_name);
                            $('#last_name').html(response.data.last_name);
                            $('#users_customers_type').html(response.data.users_customers_type);
                            $('#email').html(response.data.email);
                            $('#phone').html(response.data.phone);
                            $('#account_type').html(response.data.account_type);
                            if (!response.data.profile_pic) {
                                $('.profile_pic').addClass("d-none");
                            }else{
                                $('#profile_pic').attr("src", "{{ url('/public') }}" + "/"+response.data.profile_pic);
                            }

                            if (!response.data.proof_document) {
                                $('.proof_document').addClass("d-none");
                            }else{                        
                                $('#proof_document').attr("src", "{{ url('/public') }}" + "/"+response.data.proof_document);
                            }

                            if (!response.data.valid_document) {
                                $('.valid_document').addClass("d-none");
                            }else{                        
                                $('#valid_document').attr("src", "{{ url('/public') }}" + "/"+response.data.valid_document);
                            }

                            if (!response.data.social_acc_type) {
                                $('.social_acc_type').addClass("d-none");
                            }else{
                                $('#social_acc_type').html(response.data.social_acc_type);
                            }

                            if (!response.data.one_signal_id) {
                                $('.one_signal_id').addClass("d-none");
                            }else{
                                $('#one_signal_id').html(response.data.one_signal_id);
                            }

                            $('#date_added').html(response.data.date_added);
                            $('#status').html(response.data.status);

                        }else{
                            toastr.success(response.message);
                        }
                });
            });


        });
    </script>
@endsection