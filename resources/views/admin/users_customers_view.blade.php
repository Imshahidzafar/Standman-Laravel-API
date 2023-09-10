@extends('layout.admin.list_master')
@section('content')
    <style>
        .btn-light{
          padding-left:10px;
        }

        .heading{
            font-weight: bolder;
        }
    </style>

    <!--********************************** Content body start ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles mb-n5">
                <ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Manage Users</span>
                    @endsection
                </ol>
            </div>
            
            <!-- Content Heading Section -->
            <div class="page-titles">
				<div class="row">
                    <div class="col-7">
                        <ol class="breadcrumb">
        					<li class="breadcrumb-item"><a href="javascript:void(0)">Users</a></li>
        					<li class="breadcrumb-item active"><a href="javascript:void(0)">View Profile</a></li>
        				</ol>
                    </div>

                    <div class="col-5">
                        @if ($users_data[0]->status!='Deleted')
                        <a class="btn btn-danger pull-right right" style="margin: 10px;" href="{{url('/admin/users_customers_delete/' . $users_data[0]->users_customers_id)}}"> 
                            <i class="fa fa-trash"></i> 
                        </a>
                        @endif

                        @if ($users_data[0]->status=='Active')
                        <a class="btn btn-warning pull-right right" style="margin: 10px;" href="{{url('/admin/users_customers_update/' . $users_data[0]->users_customers_id.'/Inactive')}}"> 
                            <i class="fa fa-times"></i> 
                        </a>
                        @elseif ($users_data[0]->status=='Inactive')
                        <a class="btn btn-success pull-right right" style="margin: 10px;" href="{{url('/admin/users_customers_update/' . $users_data[0]->users_customers_id.'/Active')}}"> 
                            <i class="fa fa-check"></i> 
                        </a>
                        @endif

                        @if ($users_data[0]->status=='Pending' || $users_data[0]->status=='Deleted')
                        <a class="btn btn-warning pull-right right" style="margin: 10px;" href="{{url('/admin/users_customers_update/' . $users_data[0]->users_customers_id.'/Inactive')}}"> 
                            <i class="fa fa-times"></i> 
                        </a>

                        <a class="btn btn-success pull-right right" style="margin: 10px;" href="{{url('/admin/users_customers_update/' . $users_data[0]->users_customers_id.'/Active')}}"> 
                            <i class="fa fa-check"></i> 
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="profile card card-body px-3 pt-3 pb-0">
                        <div class="profile-head">

                            <div class="photo-content">
                                <div class="cover-photo">

                                	<!-- Cover Button -->
                                	<div class="d-flex cover_button">
										<a href="{{ url('/admin/users_customers/') }}" class="btn btn-primary shadow btn-xs sharp mr-1" id="btn_go_back"><i class="fa fa-arrow-left"></i></a>
                                    </div>
                                	<!-- Cover Logo -->
                                	<div class="cover_logo text-center">
                                		<img style="height: 300px;" src="{{ asset($users_data[0]->profile_pic) }}">
                                	</div> 

                                </div>
                            </div> 
                            
                            <!-- Profile Info -->
                            <div class="profile-info">
                            	@foreach($users_data as $users) 
								<div class="profile-photo">
									<img src="{{ asset($users->profile_pic) }}" class="img-fluid rounded-circle" alt="">
								</div>
								<div class="profile-details">
									<div class="profile-name px-2 pt-2">
										<?php if($users->users_customers_type == 'Company'){ ?>
                                        <h4 class="text-primary mb-0">
                                            {{ $users->company_name }} <br>
                                            <small>Representative: {{ $users->first_name }} {{ $users->last_name }}</small>
										</h4>
                                        <?php } else { ?>
                                        <h4 class="text-primary mb-0">
                                            {{ $users->first_name }} {{ $users->last_name }}
                                        </h4>
                                        <?php } ?>
										<p>{{ $users->location }}</p>
									</div>
									<div class="dropdown ml-auto mt-1">
										@if($users->status == 'Pending')
                                            <span class="badge badge-info" id="span_status_active">
                                            	 {{ $users->status }}
                                            </span>
                                        @elseif($users->status == 'Active') 
                                            <span class="badge badge-success" id="span_status_inactive">
                                                 {{ $users->status }}
                                            </span>
                                        @elseif($users->status == 'Inactive') 
                                            <span class="badge badge-warning" id="span_status_inactive">
                                                 {{ $users->status }}
                                            </span>
                                        @else
                                            <span class="badge badge-danger" id="span_status_deleted">
                                            	 {{ $users->status }}
                                            </span>
                                        @endif
									</div>
								</div>
								@endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-xl-12">
                    <!-- General Section -->
                    <section id="section_general">
                        <div class="card custom-tab-1">
                            <div class="card-header">
                                <ul class="nav nav-tabs align-items-end">
                                    <li class="nav-item mr-3">
                                        <a class="nav-link active bg-transparent px-2" data-toggle="tab" href="#general">
                                            General
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="general" role="tabpanel">
                                        <div class="post-details">
                                            <div class="row">
                                                <div class="col-lg-4 general_profile_info">
                                                    <?php if($users->users_customers_type == 'Company'){ ?>
                                                    <div class="heading">Company Name</div>
                                                    <div class="details">
                                                        {{ $users->company_name }}
                                                    </div>
                                                    <?php } ?>

                                                    <div class="heading">Account Type</div>
                                                    <div class="details">{{ $users->users_customers_type }}</div>
                                                </div>
                                                
                                                <div class="col-lg-4 general_profile_info">
                                                    <div class="heading">Full Name</div>
                                                    <div class="details">
                                                        {{ $users->first_name }} {{ $users->last_name }}
                                                    </div>
                                                    <div class="heading">Email</div>
                                                    <div class="details">{{ $users->email }}</div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="heading">Phone Number</div>
                                                    <div class="details">{{ $users->phone }}</div>
                                                    <div class="heading">Location</div>
                                                    <div class="details">{{ $users->location }}</div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12 about">
                                                    <div class="heading">Valid Document</div>
                                                    <div class="description"> 
                                                        <img style="height: 300px;" src="{{ asset($users_data[0]->valid_document) }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div> <!-- col end -->
            </div> <!-- row end -->
        </div>
    </div>
    <!--********************************** Content body end ***********************************-->
@endsection     