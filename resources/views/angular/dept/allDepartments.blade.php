<input type="text" data-ng-model="search.name" class="form-control" placeholder="Filter by department name" />

<div class="loader smallLoader" ng-show="departments.length <= 0"></div>
<div data-ng-repeat="dept in departments | filter: search | orderBy: 'name'"
     data-ng-show="dept.projects.length > 0">
    {{-- @todo Handle departments with no projects --}}
    <div class="departmentView" data-department="dept"></div>
</div>