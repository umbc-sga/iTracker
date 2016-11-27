<ul class="timeline">
    <li class="time-label" ng-repeat="event in timeline | limitTo: limit" >
        <span class="bg-red" ng-show ='event.created_at.length > 0'>
            @{{event.created_at}}
        </span>
        <img ng-class="{timeline_afterDate: event.created_at.length > 0, timeline_otherwise: event.created_at.length == 0}" class=" fa fa-user img-circle bg-blue" src="@{{event.creator.avatar_url}}" title = "@{{event.creator.name}}">

        <div class="timeline-item" style="margin-top:10px;">
        <span class="time">
            <!-- <i class="fa fa-clock-o"></i> TIME -->
        </span>
        <h3 class="timeline-header">
            <a href="{{url('/person')}}/@{{event.creator.id}}">@{{event.creator.name}} </a>
            <span>@{{ event.summary }}</span>
        </h3>
        </div>
    </li>
    <li>
    <button type="button" class="btn btn-primary" ng-hide = "!more" ng-click = "limit = limit + 5; getEventSet()"><i class="fa fa-clock-o"></i> Show Previous Events</button>
    </li>
</ul>