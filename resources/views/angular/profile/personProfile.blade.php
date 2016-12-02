<div class="box-header with-border">
    <h3 class="box-title">About Me</h3>
</div>
<div class="box-body">
    <strong><i class="fa fa-user"></i> Bio</strong>
    <p class="text-muted">
        @{{ person.profile.biography.length ? person.profile.biography : 'No Bio' }}
    </p>
    <hr>
    <strong><i class="fa fa-book margin-r-5"></i> Major and Class Standing</strong>
    <p class="text-muted">
        @{{ person.profile.classStanding.length ? person.profile.classStanding : 'N/a' }},
        @{{ person.profile.major.length ? person.profile.major.length : 'N/a' }}
    </p>
    <hr>
    <strong><i class="fa fa-map-marker margin-r-5"></i> Hometown</strong>
    <p class="text-muted">@{{ person.profile.hometown.length ? person.profile.hometown : 'N/a' }}</p>
    <hr>
    <strong><i class="fa fa-question-circle"></i> One thing I really want to share with the world is...</strong>
    <p class="text-muted">@{{ person.profile.fact.length ? person.profile.fact : 'N/a' }}</p>
</div>