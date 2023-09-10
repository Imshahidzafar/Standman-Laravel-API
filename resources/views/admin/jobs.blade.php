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
    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles mb-n5">
				<ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Manage Jobs</span>
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
                                            <th>Job</th>
                                            <th>Location</th>
                                            <th>Start Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Price</th>
                                            <th>Service Charges</th>
                                            <th>Tax</th>
                                            <th>Estimated Price</th>
                                            <th>Status</th>
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
            fetch('');
            $(document).on('click', '#filter_data', function() {
                var filter = '';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Pending', function() {
                var filter = 'Pending';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Ongoing', function() {
                var filter = 'Ongoing';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Accepted', function() {
                var filter = 'Accepted';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Rejected', function() {
                var filter = 'Rejected';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Cancelled', function() {
                var filter = 'Cancelled';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Completed', function() {
                var filter = 'Completed';
                fetch(filter);
            });

            $(document).on('click', '#filter_data_Deleted', function() {
                var filter = 'Deleted';
                fetch(filter);
            });
            function fetch(filter) {

                var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/jobs_fetch",
                    "url":  "jobs_fetch",
                    "method": "GET",
                    "timeout": 0,
                    "data": {
                        'filter':filter,
                    },
                };

                $.ajax(settings).done(function (response) {
                                $('tbody').html("");
                                $('#filter_d').html("");
                                var filterButtons = '<button id="filter_data"class="btn ' + (filter === '' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px;">All</button>' +
                                '<button id="filter_data_Pending" class="btn ' + (filter === 'Pending' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Pending</button>' +
                                '<button id="filter_data_Ongoing" class="btn ' + (filter === 'Ongoing' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Ongoing</button>' +
                                '<button id="filter_data_Accepted" class="btn ' + (filter === 'Accepted' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Accepted</button>' +
                                '<button id="filter_data_Rejected" class="btn ' + (filter === 'Rejected' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Rejected</button>' +
                                '<button id="filter_data_Cancelled" class="btn ' + (filter === 'Cancelled' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Cancelled</button>' +
                                '<button id="filter_data_Completed" class="btn ' + (filter === 'Completed' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Completed</button>' +
                                '<button id="filter_data_Deleted" class="btn ' + (filter === 'Deleted' ? 'btn-primary' : 'btn-info') + '" style="color: white; margin-bottom:20px; margin-left:1px;">Deleted</button>';

                                    $('#filter_d').append(filterButtons);
                                $.each(response.jobs, function (key, item) { 
    
                                    var statusHtml = '';
                                    if (item.status == "Pending") {
                                        statusHtml = '<span class="btn m-1 btn-info">Pending</span>';
                                    } else if (item.status == "Accepted") {
                                        statusHtml = '<span class="btn m-1 btn-success">Accepted</span>';
                                    } else if (item.status == "Completed") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Completed</span>';
                                    } else if (item.status == "Ongoing") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Ongoing</span>';
                                    } else if (item.status == "Rejected") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Rejected</span>';
                                    } else if (item.status == "Cancelled") {
                                        statusHtml = '<span class="btn m-1 btn-warning">Cancelled</span>';
                                    } else {
                                        statusHtml = '<span class="btn m-1 btn-danger">Deleted</span>';
                                    } 
                                    var profile_image = "{{ url('/public') }}" + "/" +item.image;
                                    $('tbody').append('\
                                        <tr class="odd gradeX">\
                                        <td>' + (key+1) + '</td>\
                                        <td><img src="'+profile_image+'" width="80px" height="80px"><span class="space">\
                                            ' + item.name + '</td>\
                                        <td>' + item.location + '</td>\
                                        <td>' + item.start_date + '</td>\
                                        <td>' + item.start_time + '</td>\
                                        <td>' + item.end_time + '</td>\
                                        <td>' + item.price + '</td>\
                                        <td>' + item.service_charges+ '</td>\
                                        <td>' + item.tax + '</td>\
                                        <td>' + item.total_price + '</td>\
                                        <td>' + statusHtml + '</td>\
                                        </tr>\
                                    ');
                                });
                });
            }
            $(document).on("click",'.delete_data', function (e) {
                    e.preventDefault();
                    var jobs_id=$(this).val();;
                    var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/job_delete",
                    "url": "job_delete",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'jobs_id':jobs_id,
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
                    var jobs_id=$(this).val();
                    var status=$(this).data("info");
                    var settings = {
                    // "url": "{{ env('APP_URL') }}" + "admin/job_update",
                    "url": "job_update",
                    "method": "POST",
                    "timeout": 0,
                    "data": {
                        'jobs_id':jobs_id,
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