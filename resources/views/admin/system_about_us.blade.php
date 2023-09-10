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
                                        <label class="col-sm-12 control-label">About Us</label>
                                        <div class="col-sm-12">
                                            <textarea rows="5" class="input-mask form-control" name="{{ $system_settings[18]->type }}" required>{{ $system_settings[18]->description }}</textarea>
                                        </div>
                                    </div>
                                   
                                    <div class="col-xl-12 form-group">
                                        <div class="col-sm-12">
                                            <input type="hidden" class="input-mask form-control" name="page_name" value="system_about_us" required>
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