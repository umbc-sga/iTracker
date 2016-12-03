<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">
            @{{ teamTitle }}
        </h3>
        <div class="box-body no-padding">
            <div class="row" style="vertical-align:middle;" data-ng-repeat="person in members | orderBy:'name'">
                <a data-ng-href="{{url('/person')}}/@{{person.id}}">
                    <div class="col-xs-4">
                        <img data-ng-src="@{{person.avatar_url}}"
                             style="height: 100%; width: 100%;"
                             class="img-circle"
                             title="@{{person.name}}"
                             alt="@{{person.name}}">
                    </div>
                </a>
                <div class="col-xs-8">
                    <a data-ng-href="{{url('/person')}}/@{{person.id}}">
                        <h4>@{{person.name}}</h4>
                    </a>
                    <h5>@{{person.position}}</h5>
                    <h5>@{{person.email_address}}</h5>
                </div>
            </div>
        </div>
    </div>
</div>