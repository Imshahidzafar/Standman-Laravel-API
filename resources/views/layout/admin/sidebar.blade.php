<?php 
	$users_system = DB::table('users_system')->where('users_system_id', session('id'))->get()->first();
	$permissions = DB::table('users_system_roles')->where('users_system_roles_id', $users_system->users_system_roles_id)->get()->first();
?>
<style>
	li.mm-active > a i{
		color: #8000FF;
	}
</style>
 
<div class="deznav">
	<div class="deznav-scroll">
		<ul class="metismenu" id="menu">
			<?php if($permissions->dashboard == 'Yes'){ ?>
			<li>
				<a href="{{ url('admin/dashboard')  }}" aria-expanded="true">	
					<i class="fa fa-th-large" aria-hidden="true"></i>
					<span class="nav-text"> Dashboard</span>
				</a>
			</li>
			<?php } ?>

			<?php if($permissions->users_customers == 'Yes'){ ?>
			<li>
				<a href="{{ url('admin/users_customers') }}"  aria-expanded="true">
					<i class="fa fa-users"></i>
					<span class="nav-text"> Users</span>
				</a>
			</li>	
			<?php } ?>

			<?php if($permissions->support == 'Yes'){ ?>
			<li>
				<a href="{{ url('admin/support') }}"  aria-expanded="true">
					<i class="fa fa-comment-o" aria-hidden="true"></i>
					<span class="nav-text"> Customer Support</span>
				</a>
			</li>	
			<?php } ?>
			<?php if($permissions->delete_account_req == 'Yes'){ ?>
				<li>
					<a href="{{ url('admin/users_customers_del_req') }}"  aria-expanded="true">
						<i class="fa fa-users" aria-hidden="true"></i>
						<span class="nav-text"> Delete Account Request</span>
					</a>
				</li>	
			<?php } ?>
			<?php if($permissions->jobs == 'Yes'){ ?>
				<li>
					<a href="{{ url('admin/jobs')  }}" aria-expanded="true">	
						<i class="fa fa-briefcase"></i>
						<span class="nav-text"> Jobs</span>
					</a>
				</li>
			<?php } ?>

			<?php if($permissions->account_settings == 'Yes'){ ?>
			<li>
				<a href="{{ url('admin/account_settings')  }}" aria-expanded="true">	
					<i class="fa fa-wrench"></i>
					<span class="nav-text"> General Settings</span>
				</a>
			</li>
			<?php } ?>

			<?php if($permissions->users_system == 'Yes' || $permissions->users_system_roles == 'Yes' || $permissions->system_settings == 'Yes'){ ?>
			<li>
				<a class="has-arrow ai-icon" aria-expanded="false" href="javascript:void()">
					<i class="fa fa-gears"></i>
					<span class="nav-text"> System Settings</span>
				</a>

				<ul aria-expanded="false">
					<?php if($permissions->users_system == 'Yes'){ ?>
			        <li><a href=" {{ url('admin/users_system') }}">Users System</a></li>	
			        <?php } ?>

					<?php if($permissions->users_system_roles == 'Yes'){ ?>
			        <li><a href=" {{ url('admin/users_system_roles') }}">Users System Roles</a></li>	
			        <?php } ?>

					<!--
					<?php if($permissions->system_settings == 'Yes'){ ?>
			        <li><a href=" {{ url('admin/system_settings') }}">System Settings</a></li>	
			    	<?php } ?>
			    	-->
				</ul>
			</li>
			<?php } ?>
		</ul>
    </div>
</div>