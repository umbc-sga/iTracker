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
        <tr>
            <td align="right"># of Topics</td>
            <td>@{{project.topics.count}}</td>
        </tr>
        <tr>
            <td align="right">Completed To-Do Lists</td>
            <td>@{{project.todolists.completed_count}}</td>
        </tr>
        <tr>
            <td align="right">Outstanding To-Do Lists</td>
            <td>@{{project.todolists.remaining_count}}</td>
        </tr>
        <tr>
            <td align="right"># of People</td>
            <td>@{{project.accesses.count}}</td>
        </tr>
        <tr>
            <td align="right"># of Documents</td>
            <td>@{{project.documents.attachments + project.attachments.count}}</td>
        </tr>
        <tr>
            <td align="right"># of Events</td>
            <td>@{{project.calendar_events.count}}</td>
        </tr>
        </tbody>
    </table>
</div>
<div class="box-footer" ng-show="readMore">
    <a href="{{url('/project')}}/@{{project.id}}"><button type="button" class="btn btn-primary btn-block btn-flat">Read More!</button></a>
</div>