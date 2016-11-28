<input type="text" ng-model="search.name" class="form-control" placeholder="Filter by department name" />

<div class="loader smallLoader" ng-show="departments.length <= 0"></div>
<div ng-repeat="department in departments | filter: search | orderBy: 'name'" ng-show="department.people.length > 0">
    <h2 id = "@{{department.id}}"> @{{department.name}}</h2>
    <div class="row" style="display: flex; flex-wrap: wrap; align-items: stretch">
        <div class="col-xs-12 col-sm-4 col-lg-3" ng-repeat="person in department.people | orderBy : 'name' | limitTo: 5">
            <div class="personView" data-person="person"></div>
        </div>
    </div>
</div>