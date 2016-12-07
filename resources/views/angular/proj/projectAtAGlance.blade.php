<div class="box-body no-padding">
    <table class="table table-responsive table-condensed teamTable">
        <tbody>
        <tr>
            <td align="right">Name</td>
            <td>@{{project.name}}</td>
        </tr>
        <tr>
            <td align="right">Description</td>
            <td>@{{project.description}}</td>
        </tr>
        <tr>
            <td align="right">Created At</td>
            <td>@{{project.created_at | date}}</td>
        </tr>
        <tr>
            <td align="right">Last Updated</td>
            <td>@{{project.updated_at | date}}</td>
        </tr>
        <tr data-ng-show="project.dock.message_board">
            <td align="right"># of Topics</td>
            <td>@{{project.dock.message_board.data.messages_count}}</td>
        </tr>
        <tr data-ng-show="project.dock.todoset">
            <td align="right">Completed To-Do Lists</td>
            <td>@{{project.dock.todoset.data.completed_ratio.split('/')[0]}}</td>
        </tr>
        <tr data-ng-show="project.dock.todoset">

        <td align="right">Outstanding To-Do Lists</td>
            <td>@{{project.dock.todoset.data.completed_ratio.split('/')[1] - project.dock.todoset.data.completed_ratio.split('/')[0]}}</td>
        </tr>
        <tr data-ng-show="project.people">
            <td align="right"># of People</td>
            <td>@{{project.people.length}}</td>
        </tr>
        <tr data-ng-show="project.dock.vault">
            <td align="right"># of Documents</td>
            <td>@{{project.dock.vault.data.documents_count + project.dock.vault.data.uploads_count + project.dock.vault.data.vaults_count}}</td>
        </tr>
        <tr data-ng-show="project.dock.schedule">
            <td align="right"># of Events</td>
            <td>@{{project.dock.schedule.data.entries_count}}</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="box-footer" data-ng-show="readMore">
    <a href="{{url('/projects')}}/@{{project.id}}"><button type="button" class="btn btn-primary btn-block btn-flat">Read More!</button></a>
</div>