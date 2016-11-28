<input type="text" ng-model="search.name" class="form-control" placeholder="Filter by department name" />
<div ng-repeat="dept in departments | filter: search | orderBy: 'name'" ng-show="dept.projects.length > 0 || true">
    <div class="departmentView" data-department="dept"></div>
</div>