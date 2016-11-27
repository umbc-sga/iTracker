
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @{{project.name}}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{url('/projects/by-name/')}}">Projects</a></li>
            <li class="active">@{{project.name}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content project"></section> <!-- /.content -->
</div> <!-- /.content-wrapper -->