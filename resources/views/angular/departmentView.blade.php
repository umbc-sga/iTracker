<h2 id = "@{{department.id}}"> @{{department.name}}</h2>
<div class="row" style="display: flex; flex-wrap: wrap; align-items: stretch">
    <div class="col-xs-12 col-sm-4 col-lg-3" ng-repeat="proj in department.projects | orderBy: 'name' | limitTo:5">
        <div class="projectView" data-project="proj"></div>
    </div>
</div>