angular.module('dashboard', ['ngSanitize'])

    .config(['$routeProvider','$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'dashboard.html',
                controller: 'DashboardController'
            });
            
        $locationProvider.html5Mode(true);
    }])

    .value('basecamp.config', {
        debug: false // Set to false to disable logging to console
    })

/**
 * Main controller that holds some global data
 *
 * Fetches and stores some initial data in the main property to display global statistics
 */
    .controller('MainController', ['$scope', '$http', 'basecamp.config', function ($scope, $http, basecampConfig) {

        /**
         * Get all people
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getPeople = function () {
            return $http.get('../get.php?url=people.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        

        $scope.getPersonInfo = function(personID) {
            return $http.get('../get.php?url=people/' + personID +'.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getPersonProj = function(personID) {
            return $http.get('../get.php?url=people/' + personID +'/projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getPersonEvents= function(personID, page) {
            if (page === 1) {
                return $http.get("../get.php?url=people/" + personID + "/events.json%3Fsince=2015-01-01T00:00:00")
                    .error(function (data, status, headers, config) {
                        basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                    })
            } else {
                return $http.get("../get.php?url=people/" + personID + "/events.json%3Fsince=2015-01-01T00:00:00&page=" + page)
                    .error(function (data, status, headers, config) {
                        basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                    })
            }
        }

        $scope.getDeptPositions = function(dept){
            return $http.get('../getPositions.php?dept=' + dept)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }
        $scope.getGroups = function(){
            return $http.get('../get.php?url=groups.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }

        $scope.getGroup = function(groupId){
            return $http.get('../get.php?url=groups/' + groupId + '.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting group : ' + groupId + data);
                })
        }
        /**
         * Get all projects
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getProjects = function () {
            return $http.get('../get.php?url=projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getProject = function (id) {
            return $http.get('../get.php?url=projects/' + id + '.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        /**
         * Get all active todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getActiveTodoLists = function () {
            return $http.get('../get.php?url=todolists.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting active todo lists: ' + data);
                });
        }

        /**
         * Get all completed todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getCompletedTodoLists = function () {
            return $http.get('../get.php?url=todolists/completed.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getProjectAccesses = function(id){
            return $http.get("../get.php?url=projects/" + id + "/accesses.json")
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting project accesses: ' + data);
                })
        }

        $scope.getExtraPersonInfo = function(id){
            return $http.get("../getRecord.php?table=person&id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getExtraDeptInfo = function(id){
            return $http.get('../getRecord.php?table=department&id=' + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonPack = function(id){
            var per = {};
            $scope.getPersonInfo(id).success(function(data, status, headers, config) {
                per.id = data.id;
                per.name = data.name;
                per.email = data.email_address;
                per.assigned = data.assigned_todos.count;
                per.avatar_url = data.avatar_url;
                per.active = 0;
                per.archive = 0;

                $scope.getPersonProj(id).success(function(data, status, headers, config) {
                    angular.forEach(data, function(proj){
                        if (!proj.template) {
                            if(!proj.trashed) {
                                per.active++;
                            }else{
                                per.archive++;
                            }
                        }
                    })
                })
            })
            return per;
        }


        $scope.getProjectPack = function(id){
            var proj = {};
            $scope.getProject(id).success(function(data, status, headers, config) {
                proj.id = data.id;
                proj.name = data.name;
                proj.description = data.description;
                proj.creator = data.creator.name;
                proj.events = data.calendar_events.count
                proj.docs = data.documents.count;
                if(data.archived){
                    proj.status = "Archived";
                }else{
                    proj.status = "Active";
                }
            })
            return proj;
        }

        $scope.getPersonDepts = function(id){
            var departments = [];
            $scope.getGroups().success(function(data, status, headers, config) {
                angular.forEach(data,function(dept){
                    $scope.getGroup(dept.id).success(function(data, status, headers, config) {
                        angular.forEach(data.memberships, function(person){
                            if(person.id == id){
                                departments.push(data);
                            }
                        })
                    })
                })
            })
            return departments;
        }

        $scope.getProjectEvents= function(id, page){
            return $http.get("../get.php?url=projects/" + id + "/events.json%3Fsince=2015-01-01T00:00:00%26page=" + page)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonRoles = function(id){
            return $http.get("../getRole.php?id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.getRole = function(id){
            return $http.get('../getRecord.php?table=role&id=' + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })   
        }

        $scope.getRolePerson = function(roleId, departmentId){
            return $http.get('../getRoleHolder.php?dept=' + departmentId + "&role=" + roleId)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.changeRole = function(person, dept, role){
            $http.get("../changeRole.php?person=" + person + "&dept=" + dept + "&role=" + role);
        }

        $scope.getPosition = function(pos, dept){
            return $http.get('../getPositionHolder.php?dept=' + dept + '&position=' + pos)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.changePosition = function(person, position){
            $http.get('../changePosition.php?person=' + person + '&position=' + position)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while changePosition: ' + data);
                })
        }

        $scope.newPosition = function(pos, isElevated, dept){
            return $http.get('newPosition.php?position=' + pos + '&elevated=' + isElevated + '&dept=' + dept)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while changePosition: ' + data);
                })
        }
    }])
    .controller('DashboardController',  ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        var email = document.getElementById('userInfo').innerHTML;
        $scope.getPeople().success(function (data, status, headers, config) {
            var personId = 0;
            angular.forEach(data, function(person){
                if(person.email_address == email){
                    personId = person.id;
                }
            })
            $scope.getPersonInfo(personId).success(function (data, status, headers, config) {
                $scope.person = data;
            })
            $scope.getPersonRoles(personId).success(function (data, status, headers, config) {
                $scope.role = data;
                $scope.positionDepartmentList = [];
                if($scope.role.addOfficer){
                    $scope.getGroups().success(function (data, status, headers, config) {
                        $scope.positionDepartmentList = data;
                    })
                }else{
                    $scope.getPersonDepts(personId).success(function (data, status, headers, config) {
                        $scope.positionDepartmentList = data;
                    })
                }
            

                $scope.depts = [];
                $scope.getGroups().success(function(data, status, headers, config) {
                    angular.forEach(data, function(dept){
                        $scope.getGroup(dept.id).success(function(data, status, headers, config) {
                            $scope.depts.push(data);
                        })
                    })
                })
                $scope.positions = [];
                $scope.removePositions = {};
                $scope.departmentPositions = {};
                $scope.getGroups().success(function(data, status, headers, config) {
                    angular.forEach(data,function(dept){
                        $scope.getDeptPositions(dept.id).success(function(data, status, headers, config) {
                            $scope.departmentPositions[dept.id] = [];
                            $scope.removePositions[dept.id] = {};
                            $scope.removePositions[dept.id].name = dept.name;
                            $scope.removePositions[dept.id].positions = [];
                            angular.forEach(data, function(position){
                                var pos = {};
                                pos.id = position.positionId;
                                pos.name = position.position;
                                pos.needPermission = position.needPermission;
                                $scope.getPosition(pos.id, dept.id).success(function(data, status, headers, config) {
                                    pos.holder = data.id;
                                    pos.dept = dept.id;
                                    if(pos.needPermission){
                                        if($scope.role.addOfficer){
                                            $scope.removePositions[dept.id].positions.push(pos);
                                        }
                                        $scope.departmentPositions[dept.id].push(pos);
                                    }else{
                                        $scope.removePositions[dept.id].positions.push(pos);
                                        $scope.positions.push(pos);
                                    }
                                })
                            })
                            // if($scope.removePositions[dept.id].positions.length == 0 ){
                            //     delete $scope.removePositions[dept.id];
                            // }
                        })
                    })
                })
                $scope.newPosition = "";
                $scope.positionDepartment = "";
                $scope.isElevated = false;
            })
        })
        $scope.updateOfficer = false;
        $scope.changeOfficer = function(){
            $scope.getGroups().success(function(data, status, headers, config) {
                angular.forEach(data, function(dept){
                    angular.forEach($scope.departmentPositions[dept.id], function(position){
                        $scope.getPosition(position.id, dept.id).success(function(data, status, headers, config) {
                            if(position.holder != data.id){
                                if(data.id != undefined)
                                    $scope.changePosition(data.id, 5);
                                $scope.changePosition(position.holder, position.id);
                            }
                        })
                    })
                })
            })
            $scope.updateOfficer = true;
            //chenge to 6
            //change person in arr to role in db
        }
        $scope.personalUpdate = false;
        $scope.UpdatePersonal = function(){
            $scope.personalUpdate = true;
            var args = 'id=' + $scope.person.id;
            args += '&bio=' + $scope.role.bio;
            args += '&major=' + $scope.role.major;
            args += '&classStanding=' + $scope.role.classStanding;
            args += '&hometown=' + $scope.role.hometown;
            args += '&fact=' + $scope.role.fact;
            args += '&position=' + $scope.role.position;
            $scope.arg = args;
            $http.get('../updatePerson.php?' + args)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        

        $scope.addAd = false;
        $scope.addAdmin = function(){
            $scope.addAd = true;
            $scope.changeRole($scope.newAdmin,0,7);
        }

        $scope.newPos = false;
        $scope.createPosition = function(){
            var elev;
            if($scope.isElevated){
                elev = 1;
            }else{
                elev = 0;
            }
            $http.get('../newPosition.php?position=' + $scope.newPosition + '&elevated=' + elev + '&dept=' + $scope.positionDepartment).success(function(data, status, headers, config) {
                var pos = {
                    id:data,
                    name:$scope.newPosition,
                    needPermission: $scope.isElevated,
                    holder:0
                }
                if(pos.needPermission){
                    if($scope.role.addOfficer){
                        $scope.removePositions[$scope.positionDepartment].positions.push(pos);
                    }
                    $scope.departmentPositions[$scope.positionDepartment].push(pos);
                }else{
                    $scope.removePositions[$scope.positionDepartment].positions.push(pos);
                    $scope.positions.push(pos);
                }
                $scope.newPos = true;
            })
        }

        $scope.removePosition = false;
        $scope.removedDept = 0;
        $scope.removedPos = 0;
        $scope.deletaDepartment = function(){
            //$http.get('removePosition.php?positionId=' + $scope.removedPos + '&departmentId=' + removedDept);
            var i = 0;
            angular.forEach($scope.departmentPositions[$scope.removedDept],function(pos){
                if(pos.id == $scope.removedPos){
                    $scope.departmentPositions[$scope.removedDept].splice(i,1);
                }
                i++;
            })
            i = 0;
            angular.forEach($scope.positions,function(pos){
                alert(pos.dept); 
                if(pos.id == $scope.removedPos && pos.dept == $scope.removedDept){
                    $scope.positions.splice(i,1);
                }
                i++;
            })
            i = 0;
            angular.forEach($scope.removePositions[$scope.removedDept].positions,function(pos){
              alert(pos.dept); 
                if(pos.id == $scope.removedPos && pos.dept == $scope.removedDept){
                    $scope.removePositions[$scope.removedDept].positions.splice(i,1);
                }
                i++;  
            })
        }
    }])