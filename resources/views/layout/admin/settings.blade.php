<a class="btn btn-sm <?php if($page_name == 'account_settings') { echo 'btn-primary'; }  else { echo "btn-info"; }?>" href="{{ url('/admin/account_settings') }}" style="color: white; margin-bottom: 20px;">Account Settings</a>

<a class="btn btn-sm <?php if($page_name == 'system_settings') { echo 'btn-primary'; }  else { echo "btn-info"; }?>" href="{{ url('/admin/system_settings') }}" style="color: white; margin-bottom: 20px;">System Settings</a>

<a class="btn btn-sm <?php if($page_name == 'system_about_us') { echo 'btn-primary'; }  else { echo "btn-info"; }?>" href="{{ url('/admin/system_about_us') }}" style="color: white; margin-bottom: 20px;">About Us</a>     

<a class="btn btn-sm <?php if($page_name == 'system_terms') { echo 'btn-primary'; }  else { echo "btn-info"; }?>" href="{{ url('/admin/system_terms') }}" style="color: white; margin-bottom: 20px;">Terms and Conditions</a>     

<a class="btn btn-sm <?php if($page_name == 'system_privacy') { echo 'btn-primary'; }  else { echo "btn-info"; }?>" href="{{ url('/admin/system_privacy') }}" style="color: white; margin-bottom: 20px;">Privacy Policy</a>     
<br>