<div class="header">
    <div class="header-content" style="padding-left: 30px !important; padding-right: 30px !important;">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
    		    <div class="header-left" style="display: flex; justify-content: space-between; width: 50%;">
					<div class="dashboard_bar" style="width: 100%; display: flex; justify-content: space-between; align-items: center">
						@yield('titleBar')
						@yield('searchbar')
						<!-- @yield('filter') -->
					</div>
                </div>
                
                <ul style="align-items: center;" class="navbar-nav header-right">
					@yield('filter')
					<span style="font-weight:bold; margin-left:5px; padding-left:20px; font-size: 20px;" class="name">
					    <?php
							$user_data = DB::table('users_system')->select('first_name')->where('users_system_id', session('id'))->get();
							echo $user_data[0]->first_name;
						?>    
					</span>
					
					<?php
						$img2=DB::table('users_system')->select('user_image')->where('users_system_id', session('id'))->get();
						$img=$img2[0]->user_image;
					?>
                    
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                            <img src="{{ url('public') }}/{{ $img }}" width="20" alt=""/>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{url('/admin/logout')}}" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ml-2">Logout </span><br>
							</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>