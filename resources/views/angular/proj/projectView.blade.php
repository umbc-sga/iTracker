<div class="box box-widget widget-user">
    <small class="pull-right">
        <span data-ng-class="{'bg-aqua': project.status == active, 'bg-red': project.status != active}"
              style="border-radius: 0 0 0 2px; padding: 2px">
            @{{project.status | capitalize}}
        </span>
    </small>
    <div class="widget-user-header bg-blue"
         style="height: inherit;
                 background: @{{ project.picture ? 'url(\''+project.picture+'\'' : 'none'}}) center no-repeat;
                 background-size: cover">
        <div class="row">
            <h3 class="widget-user-username">@{{project.name}}</h3>
            <h5 class="widget-user-desc">@{{project.description}}</h5>
        </div>
    </div>
</div>