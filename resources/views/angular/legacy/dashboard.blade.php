<div ng-controller="DashboardController">
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
	
	</h1>
      <ol class="breadcrumb">
	<li><a href="/itracker/"><i class="fa fa-home"></i> Home</a></li>
	<li class="active">@{{person.name}}</li>
	</ol>
      </section>
 
    <!-- Main content -->
    <section class="content">
      <div class="row">
	<div class="col-md-6">
	  <div class="box box-primary" ng-show = "role.updatePersonalInfo">
	    <div class="box-header with-border">
	      <h3 class="box-title">
		Update My Information
		</h3>
	      </div>
	    <div class="box-body">
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="major">Major:</label>
		<input type="text" id="major" class="form-control" ng-model="role.major">
		</div>
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="classStanding">Class Standing:</label>
		<input type="text" id="classStanding" class="form-control" ng-model="role.classStanding">
		</div>
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="position">Position:</label>
		<input type="text" id="position" class="form-control" ng-model="role.position">
		</div>
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="hometown">Hometown:</label>
		<input type="text" id="hometown" class="form-control" ng-model="role.hometown">
		</div>
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="fact">Interesting Fact:</label>
		<input type="text" id="fact" class="form-control" ng-model="role.fact">
		</div>
	      <div class="form-group" ng-class="{'has-success':personalUpdate}">
		<label for="bio">Bio:</label>
		<textarea rows="8" id="bio" class="form-control" ng-model="role.bio"></textarea>
		</div>
	      </div>
	    <div class="box-footer">
	      <button type="submit" class="btn btn-primary" ng-click="UpdatePersonal()">Update</button>
	      </div>
	    </div>
	  <div class="box box-primary" ng-show = "role.addOfficer">
	    <div class="box-header with-border">
	      <h3 class="box-title">
		Add Officer
		</h3>
	      </div>
	    <div class="box-body">
	      <div class="form-group" ng-repeat="dept in depts" ng-class="{'has-success':updateOfficer}">
		<h4>@{{dept.name}}</h4><br>
		<div class="form-group" ng-repeat="(role, personId) in heads[dept.id] | orderBy: role">
		  <label for="role">@{{role}}</label>
		  <select id="role" ng-model="heads[dept.id][role]" class="form-control">
		    <!-- <option ng-selected="personId == 0"></option> -->
		    <option ng-repeat="per in dept.memberships | orderBy: name'" value="@{{per.id}}" ng-selected="per.id == personId">@{{per.name}}</option>
		    </select>
		  </div>
		</div>
	      </div>
	    <div class="box-footer">
	      <button type="submit" class="btn btn-primary" ng-click="changeOfficer()">Update</button>
	      </div>
	    </div>
	  </div>
	<div class="col-md-6">
	  <div class="box box-primary" ng-show = "role.makeAdmin">
	    <div class="box-header with-border">
	      <h3 class="box-title">
		Add Administraighter
		</h3> 
	      </div>
	    <div class="box-body">
	      <div class="form-group" ng-class="{'has-success':addAd}">
		<label for="admin">Add Aministraighter</label>
		<select ng-model="newAdmin" class="form-control" >
		  <option ng-repeat="per in main.people | orderBy: info.name" value="@{{per.info.id}}">@{{per.info.name}}</option>
		  </select>
		</div>
	      </div>
	    <div class="box-footer">
	      <button type="submit" class="btn btn-primary" ng-click="addAdmin()">Update</button>
	      </div>
	    </div>
	  <div class="box box-primary" ng-show = "role.addDepartmentPicture">
	    <div class="box-header with-border">
	      <h3 class="box-title">
		Add Department Picture
		</h3>
	      </div>
	    <div class="box-body">
	      <div class="form-group">

		</div>
	      </div>
	    </div>
	  <div class="box box-primary" ng-show = "role.addProjectPicture">
	    <div class="box-header with-border">
	      <h3 class="box-title">
		Add Project Picture
		<
