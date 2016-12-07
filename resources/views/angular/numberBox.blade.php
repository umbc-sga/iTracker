<a data-ng-href="@{{ url }}" style="text-decoration: none; color: inherit;">
    <div class="small-box @{{ color }}">
        <div class="inner" style="padding: 10px">
            <h3>
                @{{ str }}
            </h3>
            <p>@{{ title }}</p>
        </div>
        <div class="icon">
            <i class="@{{ icon }}"></i>
        </div>
        <a data-ng-href="#" class="small-box-footer">
            @{{ description }} <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</a>