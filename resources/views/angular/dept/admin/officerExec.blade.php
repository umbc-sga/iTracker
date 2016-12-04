<ng-form class="form">
    <div class="box box-danger" data-ng-repeat="error in errors">
        @{{ error[0] }}
    </div>

    <h4>Pick a member to edit</h4>
    <select class="form-control" data-ng-model="personID">
        <option data-ng-repeat="(idx, member) in department.memberships" data-ng-value="idx" data-ngif>
            @{{ member.name }}
        </option>
    </select>

    @{{ department.memberships[personID].name ? 'Editing '+department.memberships[personID].name : ''}}

    <div class="col-xs-12" data-ng-show="permissions.indexOf('makeExec') >= 0 || permissions.indexOf('editOfficers') >= 0">
        <h3>Modify Position</h3>
        <button type="button" class="btn btn-lg"
                title="Executive Cabinet"
                data-ng-show="permissions.indexOf('makeExec') >= 0"
                data-ng-class="{'btn-success': department.memberships[personID].role.stub == 'exec'}"
                data-ng-click="makeExec(department.memberships[personID])">
            <i class="fa fa-university" aria-hidden="true"></i>
        </button>
        <button type="button" class="btn btn-lg"
                title="Cabinet"
                data-ng-show="permissions.indexOf('editOfficers') >= 0"
                data-ng-class="{'btn-success': department.memberships[personID].role.stub == 'cabinet'}"
                data-ng-click="makeCabinet(department.memberships[personID])">
            <i  class="fa fa-balance-scale" aria-hidden="true"></i>
        </button>
    </div>

    <div class="col-xs-12" data-ng-show="permissions.indexOf('updateMembersInfo') >= 0">
        <div class="row">
            <div class="col-xs-12">
                <h3>Edit Profile</h3>
            </div>
            <div class="col-xs-12" data-ng-show="!department.memberships[personID]">
                <h5>Pick a person to continue</h5>
            </div>
            <section class="content profileEdit"
                     data-ng-if="department.memberships[personID]"
                     data-person-id="department.memberships[personID].id"
                     data-exit-function="modifyProfile"></section>
        </div>
    </div>
</ng-form>