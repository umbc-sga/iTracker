<div class="box-header with-border">
    <h3 class="box-title">
        Department Admin -- @{{ permissions.role.title }}
    </h3>
</div>
<div class="box-body">
    <div class="officerAdmin" data-permissions="permissions.role.permissions"></div>
    <div class="officerExec" data-permissions="permissions.role.permissions"></div>
    @{{ permissions.role.permissions }}
</div>