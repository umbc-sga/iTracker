<div ng-controller="HomeController">

    <div class="page-header">
        <h1>Projects</h1>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 60%;">Project</th>
            <th style="width: 40%;">Status</th>
        </tr>
        </thead>
        <tbody>
        <tr class="info">
            <td><input type="text" ng-model="search.name" class="input-block-level" placeholder="Filter by project name" /></td>
            <td></td>
        </tr>
        <tr ng-repeat="project in main.projects | filter:search | orderBy:project.updated_at">
            <td>
                <h4><a href="#/projects/@{{project.id}}">@{{project.name}}</a></h4>
                <p class="ng-cloak" ng-show="project.description">@{{project.description}}</p>
                <p class="muted">Created: @{{project.created_at | date}} | Last update: @{{project.updated_at | date}}</p>
            </td>
            <td>
                <h4>@{{getProjectCounts(project.id).percentComplete | number:0}}% complete</h4>
                <div class="progress progress-striped" ng-class="{ 'progress-success':((getProjectCounts(project.id).percentComplete | number:0) == 100) }">
                    <div class="bar"
                         ng-style="{width: getProjectCounts(project.id).percentComplete + '%' }"></div>
                </div>
            </td>
        </tr>
        </tbody>
    </table>

</div>

