<ul class="timeline">
    <li class="time-label" data-ng-repeat="event in timeline | limitTo: limit" >
        <span class="bg-red" data-ng-show ='event.created_at.length > 0'>
            @{{event.created_at | date:'short'}}
        </span>
        <img data-ng-class="{timeline_afterDate: event.created_at.length > 0,
         timeline_otherwise: event.created_at.length == 0}"
             class=" fa fa-user img-circle bg-blue"
             data-ng-src="@{{event.creator.avatar_url}}" title = "@{{event.creator.name}}">

        <div class="timeline-item" style="margin-top:10px;">
        <span class="time">
            <!-- <i class="fa fa-clock-o"></i> TIME -->
        </span>
        <h3 class="timeline-header">
            <a data-ng-href="{{url('/people')}}/@{{event.creator.id}}">@{{event.creator.name}}</a>
            <span>@{{ event.action }}</span>
            <span>@{{ event.description[0] == '<' || event.description.length == 0 ? '' : event.description }}</span>
        </h3>
        </div>
    </li>
    <li data-ng-show="limit < timeline.length">
        <button type="button" class="btn btn-primary pull-right" ng-click="increaseLimit()">
            <i class="fa fa-clock-o"></i> Show Previous Events
        </button>
    </li>
</ul>