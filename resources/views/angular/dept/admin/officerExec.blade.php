<ng-form class="form">
    <h4>Pick a member to edit</h4>
    <select class="form-control" data-ng-model="personID">
        <option data-ng-repeat="(idx, member) in department.memberships | orderBy:'name'" data-ng-value="idx" data-ngif>
            @{{ member.name }}
        </option>
    </select>

    <div data-ng-show="perms.indexOf('makeExec') !== false">
        Make an exec
    </div>

    <div data-ng-show="perms.indexOf('editOfficers') !== false">
        Edit Officers
    </div>

    <div data-ng-show="perms.indexOf('updateMembersInfo') !== false">
        <div class="row">
            <div class="col-xs-12" data-ng-show="!department.memberships[personID].id">
                <h5>Pick a person to continue</h5>
            </div>
            <div data-ng-show="department.memberships[personID].id">
                <section class="content profileEdit" data-profile="department.memberships[personID].id"></section>
            </div>
        </div>
    </div>
</ng-form>

@{{ department.memberships[personID] }}