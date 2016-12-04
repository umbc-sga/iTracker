<div class="box-header with-border">
    <h3 class="box-title">
        Department Admin -- @{{ title }}
    </h3>
</div>
<div class="box-body">
    @{{ perms }}
    <div class="officerAdmin"
         data-permissions="perms"
         data-department="department"></div>
    <div class="officerExec"
         data-permissions="perms"
         data-department="department"></div>
</div>