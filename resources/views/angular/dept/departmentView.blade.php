<h2>
    @{{department.name}}
    <small>
        <a data-ng-href="{{url('/departments')}}/@{{department.name | departmentHref}}">See Department</a>
    </small>
</h2>
<div class="row" style="display: flex; flex-wrap: wrap; align-items: stretch">
    <div class="loader smallLoader" data-ng-show="!loaded"></div>
    <div class="col-xs-12 col-sm-4 col-lg-3" data-ng-repeat="proj in department.projects | orderBy: 'name' | limitTo:5">
        <a data-ng-href="{{url('/projects')}}/@{{ proj.id }}" style="text-decoration: none">
            <div class="projectView" data-project="proj"></div>
        </a>
    </div>
</div>