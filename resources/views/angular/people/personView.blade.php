<div class="box box-widget widget-user-2">
    <a href="{{url('/person')}}/@{{person.id}}/">
        <div class="widget-user-header bg-blue" style="height: inherit; overflow: auto">
            <div class="widget-user-image">
                <img class="img-circle" src="@{{person.avatar_url}}" alt="User Avatar">
            </div>
            <h3 class="widget-user-username">@{{person.name}}</h3>
            <h4 class="widget-user-desc">@{{person.position}}</h4>
            <h5 class="widget-user-desc">@{{person.email}}</h5>
        </div>
    </a>
</div>