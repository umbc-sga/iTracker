<input type="text" data-ng-model="search.name" class="form-control" placeholder="Filter by person name" />

<div class="loader smallLoader" data-ng-show="people.length <= 0"></div>
<div class="row" style="margin-top:20px; display: flex; flex-wrap: wrap; align-items: stretch">
    <div class="col-xs-12 col-sm-4 col-lg-3" data-ng-repeat="person in people | filter: search | orderBy : 'name'">
        <div class="personView" data-person="person"></div>
    </div>
</div>