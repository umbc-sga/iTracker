<div class="box-group" id="accordion">
    <div class="panel box box-warning box-solid"
         data-ng-repeat="list in todos | orderBy: 'completed'"
         style="margin-bottom:20px; overflow: hidden;">

        <a data-toggle="collapse"
           data-parent="#accordion"
           href="#todoCollapse-@{{list.id}}"
           target="_self"
           style="text-decoration:none; color:black;">
            <div class="progress progress-md progress-striped" style="height: 30px; margin-bottom: 0px;">
                <div class="box-header with-border progress-bar" data-ng-class="{ 'progress-bar-warning': !list.completed, 'progress-bar-success': list.completed} "
                     style="width:@{{list.ratio | number:0}}%"></div>
                <h4 class="todoTitle" style="white-space: nowrap">
                    @{{list.name}}
                </h4>
                <h6 class="pull-right" data-ng-show="!list.completed">
                    @{{list.ratio | number:0}} % complete
                </h6>
            </div>
        </a>

        <div id="todoCollapse-@{{list.id}}" class="panel-collapse collapse">
            <div class="box-body no-padding">
                <h3>@{{list.name}}</h3>
                <h4>@{{list.description.length ? list.description : 'No description given'}}</h4>

                <table class="table table-bordered" data-ng-show="list.todos.length > 0">
                    <tr>
                        <th>Task To Do</th>
                        <th style="width: 150px;">Assigned To</th>
                    </tr>

                    <tr data-ng-repeat="todo in list.todos | orderBy:'completed'" data-ng-class="{'bg-success':todo.completed}">
                        <td valign="middle">
                            <h5>@{{todo.content}}</h5>
                            <h6 data-ng-show="todo.due_on != null">Due: @{{todo.due_on | date}}</h6>
                            <h6>Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</h6>
                        </td>
                        <td align="center" valign="middle">
                            <span data-ng-repeat="person in todo.assignees">
                                <a data-ng-href="{{url('/people')}}/@{{person.id}}/">
                                    <img data-ng-src="@{{person.avatar_url}}"
                                         class="img-circle"
                                         style="width: 75px"
                                         title="@{{person.name}}"
                                         alt="@{{person.name}}">
                                    <h5>@{{person.name}}</h5>
                                </a>
                            </span>
                        </td>
                    </tr>
                </table>
                <span data-ng-show="(list.todos.remaining.length + list.todos.completed.length) == 0">
                    <h5>No items in this list yet!</h5>
                </span>
            </div>
        </div>
    </div>
</div>