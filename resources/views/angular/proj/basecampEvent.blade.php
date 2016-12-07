<h3>@{{ event.summary }} <small data-ng-show="event.live" class="text-danger">LIVE</small></h3>
<h5>When: @{{ event.starts_at | date:'short'  }} to @{{ event.ends_at | date:'short'  }}</h5>