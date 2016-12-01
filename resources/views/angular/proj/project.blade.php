<div class="loader smallLoader" data-ng-show="!loaded"></div>

<div class="row" data-ng-show="loaded">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Progress Bar
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="progress progress-xl progress-striped active" style="height:30px;">
                            <div class="progress-bar progress-bar-primary" style="width: @{{(((activeTodoListsCompletedCount + completedTodoListsCompletedCount) * (100 / (activeTodoListsRemainingCount + activeTodoListsCompletedCount + completedTodoListsRemainingCount + completedTodoListsCompletedCount))) || '0') | number:0}}%">
                                <h6>@{{(((activeTodoListsCompletedCount + completedTodoListsCompletedCount) * (100 / (activeTodoListsRemainingCount + activeTodoListsCompletedCount + completedTodoListsRemainingCount + completedTodoListsCompletedCount))) || '0') | number:0}}%</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="meetTheTeam" data-members="project.people" data-team-title="People on this Project"></div>
                @if(config('services.basecamp.openAccess'))
                    <div class="box-footer">
                        <form action="{{route('project.join')}}" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="PUT">
                            {{ csrf_field() }}
                            <input type="hidden" name="projectID" value="@{{project.id}}">
                            <button type="submit" class="btn btn-primary btn-block btn-flat ">Join the team!</button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="col-xs-12 col-md-6">
                <div class="box box-primary projectAtAGlance" data-project="project" data-read-more="false"></div>
            </div>
        </div>

        <div class="box box-primary" data-ng-show="project.todolists.remaining_count > 0">
            <div class="box-header with-border">
                <h3 class="box-title">Active To-Do Lists <small>(Click on list name to expand)</small> </h3>
            </div>
            <div class="box-body">
                <div class="box-group" id="accordion">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-warning box-solid" data-ng-repeat="list in activeTodoLists | orderBy: 'name'" style="margin-bottom:20px;">
                        <a data-toggle="collapse" data-parent="#accordion" href="#todoCollapse-@{{list.id}}" target="_self" style="text-decoration:none; color:black;">
                            <div class="progress progress-md progress-striped active" style="height: 30px; margin-bottom: 0px;">
                                <div class="box-header with-border progress-bar progress-bar-warning" style="width:@{{(list.completed_count * (100 / (list.remaining_count + list.completed_count))) || '0' | number:0}}%"></div>
                                <h4 class="box-title todoTitle">
                                    @{{list.name}}
                                </h4>
                                <h6 class="pull-right">
                                    @{{(list.completed_count * (100 / (list.remaining_count + list.completed_count))) || '0' | number:0}}% complete
                                </h6>
                            </div>
                        </a>

                        <div id="todoCollapse-@{{list.id}}" class="panel-collapse collapse">
                            <div class="box-body no-padding">
                                <h4 data-ng-show="list.description.length > 0">@{{list.description}}</h4>
                                <table class="table table-bordered"
                                       data-ng-show="(list.todos.remaining.length + list.todos.completed.length) > 0">
                                    <tr>
                                        <th>Task To Do</th>
                                        <th style="width: 150px;">Assigned To</th>
                                    </tr>
                                    <tr data-ng-repeat="todo in list.todos.remaining">
                                        <td valign="middle">
                                            <h5>@{{todo.content}}</h5>
                                            <h6 data-ng-show="todo.due_on != null">Due: @{{todo.due_on | date}}</h6>
                                            <h6>Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</h6>
                                        </td>
                                        <td align="center" valign="middle">
                                            <span data-ng-show="todo.assignee != null" data-ng-repeat="person in project.people | filter: {id:todo.assignee.id}">
                                                <a data-ng-href="{{url('/person')}}/@{{todo.assignee.id}}/">
                                                    <img data-ng-src="@{{person.avatar_url}}" class="img-circle" title="@{{todo.assignee.name}}" alt="@{{todo.assignee.name}}">
                                                    <h5>@{{todo.assignee.name}}</h5>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr data-ng-repeat="todo in list.todos.completed">
                                        <td valign="middle">
                                            <h5><i class="fa fa-check"></i> <span style="text-decoration: line-through;">@{{todo.content}}</span></h5>
                                            <h6 data-ng-show="todo.due_on != null">Due: @{{todo.due_on | date}}</h6>
                                            <h6>Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</h6>
                                        </td>
                                        <td align="center" valign="middle">
                                           <span data-ng-show="todo.assignee != null"
                                                 data-ng-repeat="person in project.people | filter: {id:todo.assignee.id}">
                                                <a data-ng-href="{{url('/person')}}/@{{todo.assignee.id}}/">
                                                    <img data-ng-src="@{{person.avatar_url}}" class="img-circle" title="@{{todo.assignee.name}}" alt="@{{todo.assignee.name}}">
                                                    <h5>@{{todo.assignee.name}}</h5>
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
            </div>
        </div>

        <div class="box box-primary" data-ng-show="project.todolists.completed_count > 0">
            <div class="box-header with-border">
                <h3 class="box-title">Completed To-Do Lists <small>(Click on list name to expand)</small> </h3>
            </div>
            <div class="box-body">
                <div class="box-group">
                    <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                    <div class="panel box box-success" data-ng-repeat="list in completedTodoLists | orderBy: 'name'" style="margin-bottom:20px;">
                        <a data-toggle="collapse" data-parent="#accordion" data-ng-href="#todoCollapse-@{{list.id}}" target="_self" style="text-decoration:none; color:black;">
                            <div class="progress progress-md progress-striped active" style="height: 30px; margin-bottom: 0px;">
                                <div class="box-header with-border progress-bar progress-bar-success" style="width:100%"></div>
                                <h4 class="box-title todoTitle">
                                    @{{list.name}}
                                </h4>
                                <h6 class="pull-right">
                                    100% complete
                                </h6>
                            </div>
                        </a>

                        <div id="todoCollapse-@{{list.id}}" class="panel-collapse collapse">
                            <div class="box-body no-padding">
                                <h4 data-ng-show="list.description.length > 0">@{{list.description}}</h4>
                                <table class="table table-bordered"
                                       data-ng-show="(list.todos.remaining.length + list.todos.completed.length) > 0">
                                    <tr>
                                        <th>Task To Do</th>
                                        <th>Assigned To</th>
                                    </tr>
                                    <tr data-ng-repeat="todo in list.todos.remaining">
                                        <td valign="middle">
                                            <h5>@{{todo.content}}</h5>
                                            <h6 data-ng-show="todo.due_on != null">Due: @{{todo.due_on | date}}</h6>
                                            <h6>Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</h6>
                                        </td>
                                        <td align="center" valign="middle">
                                            <span data-ng-show="todo.assignee != null"
                                                  data-ng-repeat="person in people | filter: {id:todo.assignee.id}">
                                                <a data-ng-href="{{url('/person')}}/@{{todo.assignee.id}}/">
                                                    <img data-ng-src="@{{person.avatar_url}}" class="img-circle" title="@{{todo.assignee.name}}" alt="@{{todo.assignee.name}}">
                                                    <h5>@{{todo.assignee.name}}</h5>
                                                </a>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr data-ng-repeat="todo in list.todos.completed">
                                        <td valign="middle">
                                            <h5><i class="fa fa-check"></i> <span style="text-decoration: line-through;">@{{todo.content}}</span></h5>
                                            <h6 data-ng-show="todo.due_on != null">Due: @{{todo.due_on | date}}</h6>
                                            <h6>Created: @{{todo.created_at | date}} | Last update: @{{todo.updated_at | date}}</h6>
                                        </td>
                                        <td align="center" valign="middle">
                                            <span data-ng-show="todo.assignee.length != null"
                                                  data-ng-repeat="person in project.people | filter: {id:todo.assignee.id}">
                                                <a data-ng-href="{{url('/person')}}/@{{todo.assignee.id}}/">
                                                    <img data-ng-src="@{{person.avatar_url}}" class="img-circle" title="@{{todo.assignee.name}}" alt="@{{todo.assignee.name}}">
                                                    <h5>@{{todo.assignee.name}}</h5>
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
            </div>
        </div>
    <!-- <div class="box box-primary" ng-show="project.attachments.count > 0">
						<div class="box-header with-border">
							<h3 class="box-title">Documents</h3>
						</div>
						<div class="box-body">
							<table class="table table-bordered">
                    			<tr>
						            <th>Document</th>
						            <th>Added By</th>
						            <th></th>
						        </tr>
                    			<tr ng-repeat="doc in attachments">
                    				<td valign="middle">
                    					<h5>@{{doc.name}}</h5>
						                <h6>Created: @{{doc.created_at | date}} | Last update: @{{doc.updated_at | date}}</h6>
						            </td>
						            <td align="center" valign="middle">
					                    <a href="/itracker/people/@{{doc.creator.id}}/">
					                    	<img src="@{{doc.creator.avatar_url}}" class="img-circle" title="@{{doc.creator.name}}" alt="@{{doc.creator.name}}">
											<h5>@{{doc.creator.name}}</h5>
										</a>
						            </td>
	                    			<td>
	                    				<h5>@{{doc.content_type}}</h5>
	                    				<a class="btn btn-app" ng-show="doc.link_url != null" href="@{{doc.link_url}}">
	                    					<i class="fa" ng-class="{'fa-file-image-o':docType(doc.content_type), 'fa-refresh': !docType(doc.content_type)}"></i>
	                    					<i class="fa @{{getClass(doc.content_type)}}" ></i>
	                    					<h5>Download</h5>
	                    				</a>
	                    			</td>
	                    		</tr>
                    		</table>
						</div>
					</div> -->
    </div>
    <div class="col-md-7">
        <div class="iTrakertimeline" data-timeline="events"></div>
    </div>
</div>