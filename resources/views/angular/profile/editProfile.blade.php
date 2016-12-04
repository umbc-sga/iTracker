<div class="col-xs-12">
    <div class="box box-primary col-xs-12">
        <h3>Modify how you see fit!</h3>
        <div class="box box-danger" data-ng-repeat="error in errors">
            @{{ error[0] }}
        </div>
        <form style="display:inline;" data-ng-submit="!loading && submit('{{csrf_token()}}')">
            <label for="bio">Biography</label>
            <textarea required name="bio" class="form-control" data-ng-model="profile.biography"></textarea>

            <label for="classStanding">Class Standing</label>
            <select required name="classStanding" class="form-control" data-ng-model="profile.classStanding">
                <option value="freshman">Freshman</option>
                <option value="sophomore">Sophomore</option>
                <option value="junior">Junior</option>
                <option value="senior">Senior</option>
                <option value="graduate">Graduate</option>
                <option value="staff">Staff</option>
            </select>

            <label for="major">Major</label>
            <input required type="text" name="major" class="form-control" data-ng-model="profile.major" maxlength="100">

            <label for="hometown">Hometown</label>
            <input required type="text" name="hometown" class="form-control" data-ng-model="profile.hometown" maxlength="150">

            <label for="fact">One fact about you</label>
            <input required type="text" name="fact" class="form-control" data-ng-model="profile.fact" maxlength="200">
            <button type="submit" value="submit" class="btn btn-success btn-flat pull-right" data-ng-class="{'disabled': loading}">Save</button>
        </form>
    </div>
</div>