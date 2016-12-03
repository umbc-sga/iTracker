<div ng-controller="TodoListController">

    <ul class="breadcrumb">
        <li><a href="#">Projects</a> <span class="divider">/</span></li>
        <li><a href="#/projects/@{{project.id}}">@{{project.name}}</a> <span class="divider">/</span></li>
        <li>@{{todoList.name}}</li>
    </ul>

    <div class="page-header">
        <h1>@{{todoList.name}} <small>@{{(todoList.completed_count * (100 / (todoList.remaining_count + todoList.completed_count))) || '0' | number:0}}% complete</small></h1>
    </div>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 60%">To do</th>
            <th style="width: 60%">Status</th>
        </tr>
        </thead>
        <tbody>
        <tr class="info">
            <td><input type="text" ng-model="search.content" class="input-block-level" placeholder="Filter by todo list name" /></td>
            <td><input type="text" ng-model="search.assignee.name" class="input-block-level" placeholder="Filter by name" /></td>
        </tr>
        <tr ng-repeat="todo in todoList.todos.remaining | filter:search | orderBy: todo.position">
            <td>
                <p>@{{todo.content}}</p>
                <p class="muted">Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</p>
            </td>
            <td>
                <p>Assigned to @{{todo.assignee.name}}</p>
            </td>
        </tr>
        <tr ng-repeat="todo in todoList.todos.completed | filter:search | orderBy: todo.position">
            <td>
                <p class="muted" style="text-decoration: line-through;">@{{todo.content}}</p>
                <p class="muted">Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}} | Complete: @{{todo.completed_at | date}}</p>
            </td>
            <td>
                <p class="muted">Completed by @{{todo.completer.name}} on @{{todo.completed_at | date}}</p>
            </td>
        </tr>
        </tbody>
    </table>

</div>

