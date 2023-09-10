<!DOCTYPE html>
<html lang="en">
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
	    <!-- Datatable -->
	    <link href="{{asset('vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
	    <!-- Custom Stylesheet -->
	    <link href="{{asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
	    <link href="{{asset('css/style.css')}}" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="{{asset('/icons/flaticon/flaticon.css')}}">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

	</head>

	<body>

	    <!--*******************
	        Preloader start
	    ********************-->
	    <div id="preloader">
	        <div class="sk-three-bounce">
	            <div class="sk-child sk-bounce1"></div>
	            <div class="sk-child sk-bounce2"></div>
	            <div class="sk-child sk-bounce3"></div>
	        </div>
	    </div>
	    <!--*******************
	        Preloader end
	    ********************-->


	    <!--**********************************
	        Main wrapper start
	    ***********************************-->
	    <div id="main-wrapper">

	        <!--**********************************
	            Nav header start
	        ***********************************-->
	        <div class="nav-header">
				<div style="display: flex; justify-content: space-evenly; align-items:baseline;">
					<img style="width: 25%; margin-top: 30px;" src="/public/uploads/system_image/{{$system_image[0]->description}}" alt="image">
					
					<!-- <div class="nav-control"> -->
						<!-- <div class="hamburger">
							<span class="line"></span><span class="line"></span><span class="line"></span>
						</div> -->
					<!-- </div>	 -->
				</div>
			</div>
	        <!--**********************************
	            Nav header end
	        ***********************************-->
			
			<!--**********************************
	            Header start
	        ***********************************-->
			@include('layout.admin.header');

	        <!--**********************************
	            Header end ti-comment-alt
	        ***********************************-->

	        <!--**********************************
	            Sidebar start
	        ***********************************-->
			@include('layout.admin.sidebar');
	       
	        <!--**********************************
	            Sidebar end
	        ***********************************-->
			
			<!--**********************************
	            Content body start
	        ***********************************-->

			@yield('content')
				
			<i class="flaticon-airplane49"></i>  <span class="flaticon-airplane49"></span>
	        <!--**********************************
	            Sidebar end
	        ***********************************-->

	        <!--**********************************
	            Content body end
	        ***********************************-->

	        <!--**********************************
	            Footer start
	        ***********************************-->
	        <div class="footer">
			    <div class="copyright">
			        <p>Copyright © <?php echo date('Y'); ?></p>
			    </div>
			</div>
	        <!--**********************************
	            Footer end
	        ***********************************-->

	        <!--**********************************
	           Support ticket button start
	        ***********************************-->

	        <!--**********************************
	           Support ticket button end
	        ***********************************-->
   	 	</div>
	    <!--**********************************
	        Main wrapper end
	    ***********************************-->

	    <!--**********************************
	        Scripts
	    ***********************************-->
	    <!-- Required vendors -->
	    <script src="{{asset('vendor/global/global.min.js')}}"></script>
		<script src="{{asset('vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
	    <script src="{{asset('js/custom.min.js')}}"></script>
		<script src="{{asset('js/deznav-init.js')}}"></script>
		
	    <!-- Datatable -->
	    <script src="{{asset('vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
	    <script src="{{asset('js/plugins-init/datatables.init.js')}}"></script>
	    <!-- Datatable -->
		<script src="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
		<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
		<script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
		<script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
		<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
		<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
		<script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
		
		@yield('script')
		
	    <script>
	       	$(document).ready(function() {
			  	var table = $('#example').DataTable({
					  "dom": 'Blfrtip',
			    	"initComplete": function() {
			      		$("#example").show();
			    	},
			    	"buttons": ['copy', 'excel', 'pdf', 'print', 'colvis']
			  	});
			  	table.buttons().container().appendTo('#example_wrapper .col-md-6:eq(0)');
			});
		</script> 	
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