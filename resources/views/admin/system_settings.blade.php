@extends('layout.admin.list_master')

@section('content')
    <style>
        .imageUpload{
            display: none;
        }

        .profileImage{
            cursor: pointer;
            width: 100%;
        }

        #profile-container {
            margin: 20px auto;
            color: white;
            justify-content: center;
            overflow: hidden;
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
                        <span class="ml-2">Settings</span>
                        @endsection               
                    </ol>
                </div>
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    @include('layout.admin.settings')
                    <div class="card">
                        <div class="card-body">
                            <div class="basic-form">
                                <form class="form-horizontal bordered-row" enctype="multipart/form-data" method="post" action="{{url('/admin/system_settings_edit')}}">
                                    @csrf
                                    <div class="col-xl-12 form-group">
                                        <label class="col-sm-12 control-label">Invite text for app</label>
                                        <small class="col-sm-12 control-label">Add the text that will be forwarded when user invite others</small>
                                        <div class="col-sm-12">
                                            <textarea rows="5" class="input-mask form-control" name="{{ $system_settings[16]->type }}" required>{{ $system_settings[16]->description }}</textarea>
                                        </div>
                                    </div>

                                    <legend class="col-xl-12">Geneeral Settings</legend>
                                    <div class="row">
                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Commission Percentage</label>
                                            <div class="col-sm-12">
                                                <input type="number" min="0" max="100" class="input-mask form-control" name="{{ $system_settings[18]->type }}" value="{{ $system_settings[18]->description }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Contact Email</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[1]->type }}" value="{{ $system_settings[1]->description }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Contact Phone Number</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[2]->type }}" value="{{ $system_settings[2]->description }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">System Name</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[0]->type }}" value="{{ $system_settings[0]->description }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Address</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[4]->type}}" value="{{ $system_settings[4]->description }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Currency</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[11]->type }}" value="{{ $system_settings[11]->description }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Per Hour Rate</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[22]->type}}" value="{{ $system_settings[22]->description }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Service Charges</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[24]->type }}" value="{{ $system_settings[24]->description }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">Tax</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="input-mask form-control" name="{{ $system_settings[20]->type}}" value="{{ $system_settings[20]->description }}" required>
                                            </div>
                                        </div>

                                        <div class="col-xl-3 form-group">
                                            <label class="col-sm-12 control-label">App Social Login</label>
                                            <div class="col-sm-12">
                                                <select class="input-mask form-control" name="{{ $system_settings[15]->type }}" required>
                                                    <option value="Yes" <?php if($system_settings[15]->description == 'Yes') echo "selected"; ?>>Yes</option>
                                                    <option value="No" <?php if($system_settings[15]->description == 'No') echo "selected"; ?>>No</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xl-12 form-group">
                                            <label class="col-sm-12 control-label">Logo</label>
                                            <div class="col-sm-12">
                                                <div id="profile-container">
                                                    <image id="imagePreview" class="imagePreview" src="{{asset('uploads/system_image/'.$system_settings[5]->description)}}" />
                                                </div>
                                                <input id="imageUpload" class="imageUpload" type="file" name="image" placeholder="Image" onchange="loadFile(event)" capture>
                                                <label id="empty"></label>
                                            </div>
                                            <small class="col-sm-12 control-label"> Size Recommended (744 * 138)</small>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-12 form-group">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="input-mask form-control" name="page_name" value="system_settings" required>
                                            <input type="submit" class="btn btn-primary" value="Update" style="float: right;"></button>
                                        </div>
                                    </div>
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