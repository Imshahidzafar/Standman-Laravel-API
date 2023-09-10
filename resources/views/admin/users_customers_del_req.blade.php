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
                    <span class="ml-2">Manage Users Delete Requests</span>
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
                                            <th>Email</th>
                                            <th>Delete Reason</th>
                                            <th>Comments</th>
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
                fetch();
            $(document).on('click', '#filter_data', function() {
                var filter = '';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Pending', function() {
                var filter = 'Pending';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Approved', function() {
                var filter = 'Approved';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Declined', function() {
                var filter = 'Declined';
                fetch(filter);
            });
            function fetch(filter) {

                var settings = {
                    "url":  "/admin/users_customers_del_req_fetch",
                    "method": "GET",
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
                                '<button id="filter_data_Approved" class="btn ' + (filter === 'Approved' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Approved</button>' +
                                '<button id="filter_data_Declined" class="btn ' + (filter === 'Declined' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Declined</button>';

                                    
                                    $('#filter_d').append(filterButtons);
                                $.each(response.usersCustomers, function (key, item) { 
    
                                    var statusHtml = '';
                                    if (item.status == "Pending") {
                                        statusHtml = '<span class="btn m-1 btn-info">Pending</span>';
                                    } else if (item.status == "Approved") {
                                        statusHtml = '<span class="btn m-1 btn-success">Approved</span>';
                                    } else {
                                        statusHtml = '<span class="btn m-1 btn-danger">Declined</span>';
                                    }

                                    var actionHtml = '';
                                        
                                    if (item.status == "Approved") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.users_customers_delete_id + '" data-info="Declined">';
                                        actionHtml += '<i class="fa fa-times"></i>';
                                        actionHtml += '</button>';
                                        
                                    } else if (item.status == "Declined") {
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.users_customers_delete_id + '" data-info="Approved" >';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                    }

                                    if (item.status == "Pending") {
                                        actionHtml += '<button class="btn m-1 btn-warning update_data" value="' + item.users_customers_delete_id + '" data-info="Approved">';
                                        actionHtml += '<i class="fa fa-check"></i>';
                                        actionHtml += '</button>';
                                        actionHtml += '<button class="btn m-1 btn-success update_data" value="' + item.users_customers_delete_id + '" data-info="Declined">';
                                            actionHtml += '<i class="fa fa-times"></i>';
                                            actionHtml += '</button>';
                                    }

                                    $('tbody').append('\
                                        <tr class="odd gradeX">\
                                        <td>' + (key+1) + '</td>\
                                        <td>' + item.email + '</td>\
                                        <td>' + item.delete_reason + '</td>\
                                        <td>' + item.comments + '</td>\
                                        <td>' + statusHtml + '</td>\
                                        <td>' + actionHtml + '</td>\
                                        </tr>\
                                    ');
                                });
                });
            }

            $(document).on("click",'.update_data', function (e) {
                    e.preventDefault();
                    var users_customers_delete_id=$(this).val();
                    var status=$(this).data("info");
                    var settings = {
                    "url": "/admin/users_customer_update_del_req",
                    "method": "GET",
                    "data": {
                        'users_customers_delete_id':users_customers_delete_id,
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
        });
    </script>
@endsection