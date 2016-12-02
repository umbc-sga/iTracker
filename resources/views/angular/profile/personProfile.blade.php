<div class="box-header with-border">
    <h3 class="box-title">About Me</h3>
</div>
<div class="box-body">
    <strong><i class="fa fa-user"></i> Bio</strong>
    <p class="text-muted">
        @{{ profile.biography.length ? profile.biography : 'No Bio' }}
    </p>
    <hr>
    <strong><i class="fa fa-book margin-r-5"></i> Major and Class Standing</strong>
    <p class="text-muted">
        @{{ (profile.classStanding.length ? profile.classStanding : 'N/a') | capitalize }},
        @{{ profile.major.length ? profile.major : 'N/a' }}
    </p>
    <hr>
    <strong><i class="fa fa-map-marker margin-r-5"></i> Hometown</strong>
    <p class="text-muted">@{{ profile.hometown.length ? profile.hometown : 'N/a' }}</p>
    <hr>
    <strong><i class="fa fa-question-circle"></i> One thing I really want to share with the world is...</strong>
    <p class="text-muted">@{{ profile.fact.length ? profile.fact : 'N/a' }}</p>
</div>