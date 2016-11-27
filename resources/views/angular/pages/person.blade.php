<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1>
			@{{person.name}}'s Profile
		</h1>
		<ol class="breadcrumb">
			<li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
			<li><a href="{{url('/people/by-name/')}}">People</a></li>
			<li class="active">@{{person.name}}</li>
		</ol>
	</section>

	<!-- Main content -->
	<section class="content person"></section>	<!-- /.content -->
</div>	<!-- /.content-wrapper -->
