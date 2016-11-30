<!-- small box -->
<div class="small-box @{{ color }}">
    <div class="inner">
        <h3>
            @{{ str }}
        </h3>
        <p>@{{ title }}</p>
    </div>
    <div class="icon">
        <i class="@{{ icon }}"></i>
    </div>
    <a data-ng-href="@{{ url }}" class="small-box-footer">
        @{{ description }} <i class="fa fa-arrow-circle-right"></i>
    </a>
</div>