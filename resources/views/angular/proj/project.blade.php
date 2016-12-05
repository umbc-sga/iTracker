<h1>
    @{{project.name}}
</h1>

<div class="loader smallLoader" data-ng-show="!loaded"></div>

<div class="row" data-ng-show="loaded">
    <div class="col-xs-12">
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary" data-ng-show="project.picture || canEdit">
                <div data-ng-if="canEdit" class="hidden">
                    <form data-ng-submit="">
                        <input type="file" name="image" custom-on-change="uploadImage" />
                    </form>
                </div>
                <div data-ng-show="project.picture">
                    <img data-ng-src="@{{ project.picture }}"
                         class="projectPicture"
                         data-ng-class="{canEdit: canEdit}"
                         data-ng-click="upload()"
                         title="project picture"
                         alt="project picture"
                         width="100%"
                         height="100%" />
                </div>
                <div data-ng-show="!project.picture && canEdit" style="cursor: pointer">
                    <img src="//placeholdit.imgix.net/~text?txtsize=33&txt=upload&w=350&h=150"
                         class="projectPicture"
                         data-ng-class="{canEdit: canEdit}"
                         data-ng-click="upload()"
                         title="project picture"
                         alt="project picture"
                         width="100%"
                         height="100%" />
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        Progress Bar
                    </h3>
                </div>
                <div class="box-body">
                    <div class="progress progress-xl progress-striped active" style="height:30px;">
                        <div class="progress-bar progress-bar-primary"
                             style="width: @{{(project.dock.todoset.data.completed_ratio.split('/')[0] / project.dock.todoset.data.completed_ratio.split('/')[1])*100}}%">
                            <h6>@{{ (project.dock.todoset.data.completed_ratio.split('/')[0] / project.dock.todoset.data.completed_ratio.split('/')[1])*100 }}%</h6>
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
            <div class="box box-primary">
                <div class="row">
                    <div class="col-xs-12 projectAtAGlance"
                         data-project="project"
                         data-read-more="false"></div>
                </div>
            </div>

            <div class="loader smallLoader" data-ng-show="!historyLoaded"></div>
            <div class="box box-primary col-xs-12" data-ng-show="historyLoaded">
                <h2>History of the Project</h2>
                <div class="iTrakertimeline" data-timeline="project.history"></div>
            </div>

            <div class="loader smallLoader" data-ng-show="!todoLoaded"></div>
            <div class="box box-primary col-xs-12" data-ng-show="todoLoaded">
                <div class="box-header with-border">
                    <h3 class="box-title">To-Do Lists <small>(Click on list name to expand)</small> </h3>
                </div>
                <div class="box-body" data-ng-show="project.todo.length <= 0">
                    <h3><small>(There are no todolists)</small> </h3>
                </div>
                <div class="projectTodo" data-todos="project.todo" data-ng-show="project.todo.length > 0"></div>
            </div>
        </div>
    </div>

    {{--
    <div class="col-xs-12">
        <div class="box box-primary" ng-show="project.attachments.count > 0">
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
        </div>
    </div>
    <div class="col-md-7">
        <div class="iTrakertimeline" data-timeline="events"></div>
    </div>
    --}}
</div>