<!-- START SIDEBAR -->
<nav class="page-sidebar" id="sidebar">
  	<div id="sidebar-collapse">
    	<ul class="side-menu metismenu">
	    	@foreach (auth()->user()->roles()->get(['id', 'role']) as $role)
	        	@includeIf('tenant.partials.navigations.' . $role->role)
	      	@endforeach
    	</ul>
  	</div>
</nav>
<!-- END SIDEBAR -->
