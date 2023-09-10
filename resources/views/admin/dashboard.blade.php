@extends('layout.admin.list_master')
@section('content')
	<!--**********************************
        Chat box End
    ***********************************-->
    <style>
        .donut-chart-sale small {
            font-size: 16px;
		    position: absolute;
		    width: 100%;
		    height: 100%;
		    left: 0;
		    display: flex;
		    align-items: center;
		    top: 0;
		    justify-content: center;
		    font-weight: 600;
        }
    </style>
 	
	<div class="content-body">
        <div style="padding-top:20px;" class="container-fluid">
        	<div class="page-titles mb-n5">
                <ol class="breadcrumb">
                    @section('titleBar')
                    <span class="ml-2">Dashboard</span>
                    @endsection
                </ol>
            </div>
            <!-- row -->

			<div class="row">
				<div class="col-xl col-md-6 col-sm-6">
					<div class="card">
						<div style="padding: 0.25rem !important;" class="card-body p-4">
							<img src="/public/images/users.svg" alt="image">
							<span class="donut1" data-peity="{ &quot;fill&quot;: [&quot;rgb(255, 195, 210)&quot;, &quot;rgba(255, 255, 255, 1)&quot;],   &quot;innerRadius&quot;: 45, &quot;radius&quot;: 10}" style="display: none;">3/8</span>
							<div style="padding-left: 20px;padding-bottom: 20px;">
								<h2 class="fs-24 text-black font-w600 mb-0">{{$total_users_customers}}</h2>
								<span class="fs-14">Total Users</span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl col-md-4 col-sm-6">
					<div class="card">
						<div style="padding: 0.25rem !important;" class="card-body p-4">
							<img src="/public/images/total-transactions.svg" alt="image">
							<span class="donut1" data-peity="{ &quot;fill&quot;: [&quot;rgb(255, 213, 174)&quot;, &quot;rgba(255, 255, 255, 1)&quot;],   &quot;innerRadius&quot;: 45, &quot;radius&quot;: 10}" style="display: none;">5/8</span>
							<div style="padding-left: 20px;padding-bottom: 20px;">
								<h2 class="fs-24 text-black font-w600 mb-0">{{ $completed_jobs }}</h2>
								<span class="fs-14">Completed Jobs</span>
							</div>
						</div>
					</div>
				</div>

			<!--	<div class="col-xl col-md-4 col-sm-6">
					<div class="card">
						<div style="padding: 0.25rem !important;" class="card-body p-4">
							<img src="/public/images/total-offers.svg" alt="image">
							<span class="donut1" data-peity="{ &quot;fill&quot;: [&quot;rgb(238, 252, 255)&quot;, &quot;rgba(255, 255, 255, 1)&quot;],   &quot;innerRadius&quot;: 45, &quot;radius&quot;: 10}" style="display: none;">8/8</span>
							<div style="padding-left: 20px;padding-bottom: 20px;">
								<h2 class="fs-24 text-black font-w600 mb-0">6</h2>
								<span class="fs-14">Total Offers</span>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xl col-md-4 col-md-6">
					<div class="card">
						<div style="padding: 0.25rem !important;" class="card-body p-4">
							<img src="/public/images/total-connects.svg" alt="image">
							<span class="donut1" data-peity="{ &quot;fill&quot;: [&quot;rgb(238, 252, 255)&quot;, &quot;rgba(255, 255, 255, 1)&quot;],   &quot;innerRadius&quot;: 45, &quot;radius&quot;: 10}" style="display: none;">8/8</span>
							<div style="padding-left: 20px;padding-bottom: 20px;">
								<h2 class="fs-24 text-black font-w600 mb-0">6</h2>
								<span class="fs-14">Total connects</span>
							</div>
						</div>
					</div>
				</div>

					
			</div>
			<div class="row">
				<div class="col-md-9 col-sm-9">
					<div class="card">
						<div class="card-header d-sm-flex d-block pb-0 border-0">
							<div class="d-flex align-items-center">
								<span class="p-3 mr-3 rounded bg-warning">
									<i class="fa fa-usd" aria-hidden="true" style="color: white;"></i>
								</span>
								<div class="mr-auto pr-3">
									<h4 class="text-black fs-20">Transactions</h4>
									<p class="fs-13 mb-0 text-black">Take a look at your transactions.</p>
								</div>
							</div>
						</div>
						<div class="card-body pb-0">
							<div id="chartBar"></div>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3">
					<div class="card">
						<div class="card-header border-0 pb-0">
							<h4 class="text-black fs-20 mb-0">Hired Vs Cancel</h4>
						</div>
						<div class="card-body text-center">
							<div class="man-chart mb-4">
								<div id="pieChart"></div>
								<svg width="74" height="50" viewBox="0 0 74 50" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_29_2825)">
									<path d="M18.2407 22.0472V10.3386C17.365 10.5553 16.5463 10.961 15.8408 11.5278C15.1354 12.0947 14.56 12.8091 14.1543 13.622L10.4422 21.126V38.4488C10.9855 39.428 11.778 40.2428 12.7377 40.809C13.6975 41.3752 14.7896 41.6722 15.9012 41.6693H65.8116C67.4662 41.6693 69.0531 41.0056 70.2231 39.8243C71.3931 38.643 72.0504 37.0407 72.0504 35.3701V33.8583H29.9385C26.836 33.8583 23.8607 32.6139 21.6669 30.3989C19.4731 28.1839 18.2407 25.1797 18.2407 22.0472Z" fill="#A87B5D"/>
									<path d="M10.8555 29.5039H21.7734H10.8555ZM25.6727 29.5039H26.4525H25.6727Z" fill="#A87B5D"/>
									<path d="M10.8555 29.5039H21.7734M25.6727 29.5039H26.4525" stroke="#A87B5D" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M55.7622 20.7598H55.7593H44.3891C44.3164 20.7598 44.2458 20.7307 44.1929 20.6774C44.1399 20.6238 44.1092 20.5502 44.1092 20.4724V14.9606C44.1092 14.8829 44.1399 14.8092 44.1929 14.7557C44.2458 14.7023 44.3164 14.6732 44.3891 14.6732L50.3004 14.6732L50.3033 14.6732C50.3394 14.673 50.3754 14.68 50.4091 14.6939C50.4426 14.7077 50.4734 14.7282 50.4997 14.7543C50.4999 14.7545 50.5 14.7547 50.5002 14.7549L55.9577 20.2652L55.9592 20.2667C55.999 20.3066 56.0267 20.3581 56.038 20.415L56.5285 20.3176L56.0381 20.415C56.0494 20.4719 56.0436 20.5309 56.0217 20.5842C55.9998 20.6375 55.963 20.6822 55.9167 20.7132L56.1949 21.1286L55.9167 20.7132C55.8705 20.7441 55.8167 20.7602 55.7622 20.7598ZM55.7593 21.2598H44.3891C44.1823 21.2598 43.9839 21.1769 43.8377 21.0292C43.6914 20.8816 43.6092 20.6813 43.6092 20.4724V14.9606C43.6092 14.7518 43.6914 14.5515 43.8377 14.4039C43.9839 14.2562 44.1823 14.1732 44.3891 14.1732H50.3004L55.7593 21.2598ZM22.0699 20.3298L22.0699 20.3298L22.0711 20.3277L25.1035 14.818C25.1037 14.8177 25.1038 14.8175 25.104 14.8172C25.1288 14.7729 25.1644 14.7367 25.2068 14.7116C25.2492 14.6865 25.2972 14.6734 25.3457 14.6732H37.3626C37.4353 14.6732 37.506 14.7023 37.5588 14.7557C37.6118 14.8092 37.6425 14.8829 37.6425 14.9606V20.4724C37.6425 20.5502 37.6118 20.6238 37.5588 20.6774C37.506 20.7307 37.4353 20.7598 37.3626 20.7598H22.312C22.2643 20.7597 22.2171 20.747 22.1751 20.7226C22.133 20.6982 22.0974 20.6627 22.0723 20.6192C22.0471 20.5757 22.0334 20.5259 22.033 20.4748C22.0326 20.4238 22.0454 20.3738 22.0699 20.3298Z" fill="#A87B5D" stroke="#A87B5D"/>
									<path d="M58.4888 20.8976L49.6998 11.9843C49.12 11.3995 48.4318 10.9358 47.6744 10.6196C46.9171 10.3035 46.1054 10.1411 45.2859 10.1417H20.5334C19.3744 10.1409 18.238 10.4661 17.2518 11.0808C16.2655 11.6955 15.4684 12.5755 14.9497 13.622L11.0972 21.4095C10.6651 22.285 10.4408 23.2501 10.4422 24.2283V35.3386C10.4422 37.0092 11.0995 38.6115 12.2695 39.7928C13.4395 40.9741 15.0263 41.6378 16.681 41.6378H66.5914C68.246 41.6378 69.8329 40.9741 71.0029 39.7928C72.1729 38.6115 72.8302 37.0092 72.8302 35.3386V29.0394C72.8302 27.3687 72.1729 25.7665 71.0029 24.5852C69.8329 23.4038 68.246 22.7402 66.5914 22.7402H62.9339C62.1091 22.745 61.2916 22.5846 60.5286 22.2683C59.7656 21.9521 59.0723 21.4862 58.4888 20.8976V20.8976Z" stroke="#0F172A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M25.2828 48.8189C29.159 48.8189 32.3014 45.6461 32.3014 41.7323C32.3014 37.8185 29.159 34.6457 25.2828 34.6457C21.4065 34.6457 18.2641 37.8185 18.2641 41.7323C18.2641 45.6461 21.4065 48.8189 25.2828 48.8189Z" fill="white" stroke="#0F172A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M56.4768 48.8189C60.3531 48.8189 63.4954 45.6461 63.4954 41.7323C63.4954 37.8185 60.3531 34.6457 56.4768 34.6457C52.6005 34.6457 49.4581 37.8185 49.4581 41.7323C49.4581 45.6461 52.6005 48.8189 56.4768 48.8189Z" fill="white" stroke="#0F172A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path d="M39.71 29.5039H42.8294M72.6743 32.0315H70.9118C70.58 32.0336 70.251 31.9696 69.9437 31.8433C69.6363 31.717 69.3566 31.5309 69.1206 31.2954C68.8845 31.06 68.6966 30.7799 68.5678 30.4712C68.4389 30.1624 68.3715 29.8311 68.3695 29.4961C68.3715 29.161 68.4389 28.8297 68.5678 28.521C68.6966 28.2122 68.8845 27.9321 69.1206 27.6967C69.3566 27.4613 69.6363 27.2751 69.9437 27.1488C70.251 27.0225 70.58 26.9586 70.9118 26.9606H72.183M39.1251 48.8189H66.7474M10.7697 48.8189H33.6817M6.95627 48.8189H7.58795M6.17642 32.6772H10.0757M8.51597 34.6457H10.0757M51.8601 22.8346H40.4898C40.283 22.8346 40.0846 22.7517 39.9384 22.604C39.7921 22.4564 39.71 22.2561 39.71 22.0472V16.5354C39.71 16.3266 39.7921 16.1263 39.9384 15.9787C40.0846 15.831 40.283 15.748 40.4898 15.748H46.4011C46.5037 15.7474 46.6055 15.7673 46.7005 15.8065C46.7955 15.8457 46.8819 15.9034 46.9548 15.9764L52.4137 21.4882C52.5237 21.5983 52.5987 21.739 52.6292 21.8924C52.6597 22.0457 52.6442 22.2048 52.5848 22.3492C52.5254 22.4936 52.4248 22.617 52.2957 22.7034C52.1666 22.7899 52.015 22.8356 51.8601 22.8346V22.8346ZM18.4123 22.8346H33.4634C33.6702 22.8346 33.8686 22.7517 34.0148 22.604C34.1611 22.4564 34.2432 22.2561 34.2432 22.0472V16.5354C34.2432 16.3266 34.1611 16.1263 34.0148 15.9787C33.8686 15.831 33.6702 15.748 33.4634 15.748H21.4459C21.3077 15.7483 21.1721 15.7856 21.0528 15.8561C20.9336 15.9267 20.8351 16.028 20.7674 16.1496L17.7338 21.6614C17.6672 21.7811 17.6327 21.9164 17.6338 22.0537C17.6349 22.191 17.6716 22.3257 17.7402 22.4443C17.8087 22.5629 17.9069 22.6613 18.0248 22.7298C18.1427 22.7983 18.2763 22.8344 18.4123 22.8346Z" stroke="#0F172A" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path opacity="0.2" d="M3.1194 20.8032V24.7402M5.06902 22.7717H1.16977M65.3203 13.3228V17.2598M67.2699 15.2913H63.3706" stroke="#4B4668" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									<path opacity="0.5" d="M44.779 5.11811C45.8557 5.11811 46.7286 4.23678 46.7286 3.14961C46.7286 2.06243 45.8557 1.1811 44.779 1.1811C43.7022 1.1811 42.8293 2.06243 42.8293 3.14961C42.8293 4.23678 43.7022 5.11811 44.779 5.11811Z" stroke="#A87B5D" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
									</g>
									<defs>
									<clipPath id="clip0_29_2825">
									<rect width="74" height="50" fill="white"/>
									</clipPath>
									</defs>
								</svg>
							</div>
							<ul class="d-flex flex-wrap">
								<li class="mr-5 mb-2">
									<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="19" height="19" rx="9.5" fill="#0F172A"/>
									</svg>
									<span class="fs-12 text-black">Total Hired</span>
								</li>
								<li class="mr-5 mb-2">
									<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="19" height="19" rx="9.5" fill="#A87B5D"/>
									</svg>
									<span class="fs-12 text-black">Total Cancelled</span>
								</li>
								<li class="mr-5 mb-2">
									<svg class="mr-2" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
										<rect width="19" height="19" rx="9.5" fill="#E5E5E5"/>
									</svg>
									<span class="fs-12 text-black">Total Pending</span>
								</li>
							</ul>
						</div>
					</div>
				</div>-->
			</div>
    	</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>

	<link href="{{url('public')}}/vendor/chartist/css/chartist.min.css" rel="stylesheet" type="text/css"/>
	<script src="{{url('public')}}/vendor/chart.js/Chart.bundle.min.js" type="text/javascript"></script>
	<script src="{{url('public')}}/vendor/apexchart/apexchart.js" type="text/javascript"></script>
	<script src="{{url('public')}}/vendor/peity/jquery.peity.min.js" type="text/javascript"></script>

	<script type="text/javascript">
		(function($) {
			/* "use strict" */
			var dzChartlist = function(){	
				var screenWidth = $(window).width();
				var chartBar = function(){
					var optionsArea = {
			          	series: [{
			            	name: "Earning",
			            	data: [20, 40, 20, 80, 40, 40, 20, 60, 60, 20, 110, 60]
			          	}],
				        chart: {
					        height: 350,
					        type: 'area',
						  		group: 'social',
							  	toolbar: {
					            show: false
					        },
					        zoom: {
					          enabled: false
					        },
					   	},
				      	dataLabels: {
				        	enabled: false
				      	},
				      	stroke: {
				        	width: [4],
					  		colors:['#A87B5D'],
					  		curve: 'straight'
				      	},
				      	legend: {
							show:false,
				        	tooltipHoverFormatter: function(val, opts) {
				        		return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
				       		},
						  	markers: {
								fillColors:['#C046D3','#1EA7C5','#FF9432'],
								width: 19,
								height: 19,
								strokeWidth: 0,
								radius: 19
					  		}
			   			}, 
				    	markers: {
			          		size: [6],
					  		strokeWidth: [4],
					  		strokeColors: ['#FF9432'],
					  		border:0,
					  		colors:['#fff'],
			          		hover: {
			            		size: 10,
			          		}
			        	},
			        	xaxis: {
			          		categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep','Oct','Nov','Dec' ],
					  		labels: {
					   			style: {
						  			colors: '#3E4954',
						  			fontSize: '14px',
						   			fontFamily: 'Poppins',
						  			fontWeight: 100,
								},
					  		},
				        },
						yaxis: {
							labels: {
								offsetX:-16,
							  	style: {
							  		colors: '#3E4954',
							  		fontSize: '14px',
							   		fontFamily: 'Poppins',
							  		fontWeight: 100,
								},
					  		},
						},
						fill: {
							colors:['#FF9432'],
							type:'solid',
							opacity: 0.2
						},
						colors:['#FF9432'],
			        	grid: {
			          		borderColor: '#f1f1f1',
					  		xaxis: {
			            		lines: {
			              			show: true
			            		}
			          		}
			        	},
						responsive: [{
							breakpoint: 575,
							options: {
								chart: {
									height: 250,
								},
								markers: {
								 	size: [4],
								 	hover: {
										size: 7,
								  	}
								}
							}
					 	}]
			        };
					var chartArea = new ApexCharts(document.querySelector("#chartBar"), optionsArea);
			        chartArea.render();
				}
				
				var pieChart = function(){
					var options = {
				      	series: [20, 30, 60],
				      	chart: {
				      		type: 'donut',
				  			height:200,
				    	},
						legend: {
							show:false,
						},
						fill:{
							colors:['#0F172A','#A87B5D','#EBEBEB']
						},
						stroke:{
							width:0,
						},
						colors:['#0F172A','#A87B5D','#EBEBEB'],
						dataLabels: {
					    	enabled: false
				    	}
				   };
			   
				   var chart = new ApexCharts(document.querySelector("#pieChart"), options);
				   chart.render();
				}
				/* Function ============ */
				return {
					init:function(){},
			
					load:function(){
						chartBar();
						pieChart();
					},
					resize:function(){}
				}
			}();
			
			jQuery(window).on('load',function(){
				setTimeout(function(){
					dzChartlist.load();
				}, 1000); 		
			});

			jQuery(document).ready(function(){});
			jQuery(window).on('resize',function(){});     
		})(jQuery);
	</script>
	<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
	<script>
	    $(document).ready(function () {
			$('#example').DataTable();
		});
	</script>    
@endsection