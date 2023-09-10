<!DOCTYPE html>
<html lang="en" class="h-100">
    <head>
        <?php 
            $system_image=DB::table('system_settings')->select('description')->where('type', 'system_image')->get(); 
            $system_name=DB::table('system_settings')->select('description')->where('type', 'system_name')->get(); 
        ?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title><?php echo $system_name[0]->description; ?> :: Admin Portal</title>
        <!-- Favicon icon -->
        <link rel="icon" type="image" sizes="24x24" href="/public/uploads/system_image/{{$system_image[0]->description}}">
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
        <style>
            body{
               background-color: #33d17b;
            }
        </style>
    </head>
    <body class="h-100">
        <div class="authincation h-100">
            <div class="container h-100">
                <div class="row justify-content-center h-100 align-items-center">
                    <div class="col-md-6">
                        <div class="authincation-content">
                            <div class="row no-gutters">
                                <div class="col-xl-12">
                                    <div class="auth-form">
                                        <div class="text-center mb-4 logo">
                                            <img class="text-center mb-4" style="width: 25%;" src="/public/uploads/system_image/{{$system_image[0]->description}}" alt="image">
                                        </div>

                                        <h4 class="text-center mb-4">Sign in your account</h4>
                                        <form  method="POST" action="{{url('/admin/login')}}">
                                            @csrf
                                            <div class="form-group">
                                                <label class="mb-1"><strong>Email</strong></label>
                                                <input type="email" class="form-control"  id="email" name="email" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label class="mb-1"><strong>Password</strong></label>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                            </div>
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-primary btn-block">Sign Me In</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Scripts
        ***********************************-->
        <!-- Required vendors -->
        <script src="{{asset('vendor/global/global.min.js')}}"></script>
    	<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
        <script src="{{asset('js/custom.min.js')}}"></script>
        <script src="{{asset('js/deznav-init.js')}}"></script>

        <link href="{{asset('toasters/toastr.min.css')}}" rel="stylesheet" type="text/css" />   
        <script src="{{asset('toasters/toastr.min.js')}}" type="text/javascript"></script>
        <script>
            toastr.options = {
              "closeButton": true,
              "debug": false,
              "positionClass": "toast-top-right",
              "onclick": null,
              "showDuration": "1000",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }
            //Command: toastr['success']("hello");

            <?php if(Session::has('success')){ ?> Command: toastr['success']("<?php echo Session('success'); ?>"); <?php } ?>
            <?php if(Session::has('error')){ ?> Command: toastr['error']("<?php echo Session('error'); ?>"); <?php } ?>
            <?php if(Session::has('warning')){ ?> Command: toastr['warning']("<?php echo Session('warning'); ?>"); <?php } ?>
            <?php if(Session::has('info')){ ?> Command: toastr['info']("<?php echo Session('info'); ?>"); <?php } ?>
        </script>
    </body>
</html>