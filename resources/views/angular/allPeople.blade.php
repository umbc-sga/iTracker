<input type="text" ng-model="search.name" class="form-control" placeholder="Filter by person name" />
<div class="row" style="margin-top:20px; display: flex; flex-wrap: wrap; align-items: stretch">
    <div class="col-xs-12 col-sm-4 col-lg-3" ng-repeat="person in people | filter: search | orderBy : 'name'">
        <div class="personView" data-person="person"></div>
    </div>
</div>