
<div class="content-wrapper">
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

    <section class="content project" data-token="{{csrf_token()}}"></section>
</div>