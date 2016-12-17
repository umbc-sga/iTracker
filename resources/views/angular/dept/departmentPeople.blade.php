<input type="text" data-ng-model="search.name" class="form-control" placeholder="Filter by department name" />

<div class="loader smallLoader" data-ng-show="departments.length <= 0"></div>
<div data-ng-repeat="department in departments | filter: search | orderBy: 'name'"
     data-ng-show="department.memberships.length > 0">
    <div class="loader smallLoader" data-ng-show="!department.loaded"></div>
    <h2>
        @{{department.name}}
        <small>
            <a data-ng-href="{{url('/department')}}/@{{department.name | departmentHref}}">See Department</a>
        </small>
    </h2>
    <div class="row" style="display: flex; flex-wrap: wrap; align-items: stretch">
        <div class="col-xs-12 col-sm-4 col-lg-3" data-ng-repeat="person in department.memberships | orderBy : 'name'">
            <div class="personView" data-person="person"></div>
        </div>
    </div>
</div>