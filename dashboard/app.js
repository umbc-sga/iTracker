function replace_All(str, find, replace){
    while(str.indexOf(find) != -1){
        str = str.replace(find, replace);
    }
    return str;
}


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

        $scope.main = {
            groups: []
        }
    	$scope.contains = function(person, arr){
			angular.forEach(arr,function(id,member){
				if(id == person.id){
					return true;
				}
			})
			return false;
		}
    	$scope.getPerson = function(personId){
    		var person = {};
    		$scope.getPersonInfo(personId).success(function (data, status, headers, config) {
                person = data;
                $scope.getExtraPersonInfo(personId).success(function(data, status, headers, config) {
                    person.bio = data.bio;
                    person.major = data.major;
                    person.classStanding = data.classStanding;
                    person.hometown = data.hometown;
                   	person.fact = data.fact;
                    person.position = data.position;
                })
            })
            return person;
    	}

        /**
         * Get all people
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getPeople = function() {
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

        $scope.getDeptPositions = function(dept) {
            return $http.get('../getPositions.php?dept=' + dept)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }
        $scope.getGroups = function() {
            return $http.get('../get.php?url=groups.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }

        $scope.getGroup = function(groupId) {
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
        $scope.getProjects = function() {
            return $http.get('../get.php?url=projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getProject = function(id) {
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
        $scope.getActiveTodoLists = function() {
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
        $scope.getCompletedTodoLists = function() {
            return $http.get('../get.php?url=todolists/completed.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getProjectAccesses = function(id) {
            return $http.get("../get.php?url=projects/" + id + "/accesses.json")
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting project accesses: ' + data);
                })
        }

        $scope.getPeopleInRole = function(role){
            return $http.get('../getPeopleByRole.php?id=' + role)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting people in role: ' + data);
                })
        }
        $scope.getExtraPersonInfo = function(id) {
            return $http.get("../getRecord.php?table=person&id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getExtraDeptInfo = function(id) {
            return $http.get('../getRecord.php?table=department&id=' + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonPack = function(id) {
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


        $scope.getProjectPack = function(id) {
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

        $scope.getPersonDepts = function(id) {
            var departments = [];
            $scope.getGroups().success(function(data, status, headers, config) {
                angular.forEach(data,function(dept){
                    $scope.getGroup(dept.id).success(function(data, status, headers, config) {
                        angular.forEach(data.memberships, function(person){
                            if(person.id == id){
                                var group_href = replace_All(replace_All(data.name.toLowerCase()," ", "-") , "&", "and");
                                data.href = group_href;
                                departments.push(data);
                            }
                        })
                    })
                })
            })
            return departments;
        }

        $scope.getProjectEvents = function(id, page) {
            return $http.get("../get.php?url=projects/" + id + "/events.json%3Fsince=2015-01-01T00:00:00%26page=" + page)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonRoles = function(id) {
            return $http.get("../getRole.php?id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.getRole = function(id) {
            return $http.get('../getRecord.php?table=role&id=' + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })   
        }

        $scope.getRolePerson = function(roleId, departmentId) {
            return $http.get('../getRoleHolder.php?dept=' + departmentId + "&role=" + roleId)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.changeRole = function(person, dept, role) {
            $http.get("../changeRole.php?person=" + person + "&dept=" + dept + "&role=" + role);
        }

        $scope.getPosition = function(pos, dept) {
            return $http.get('../getPositionHolder.php?dept=' + dept + '&position=' + pos)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.getGroups().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawGroups = data;

                    angular.forEach (rawGroups, function (group) {
                        $http.get('newRecord.php?table=department&id=' + group.id)
                            .error(function (data, status, headers, config) {
                                basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                            });

                        $scope.getGroup(group.id).success(function (data, status, headers, config) {
                            var groupInfo = data;
                            var group_href = replace_All(replace_All(groupInfo.name.toLowerCase()," ", "-") , "&", "and");
                            groupInfo.group_href = group_href;

                            angular.forEach(data.memberships, function(person){
                                
                                $http.get('newRole.php?personId=' + person.id + '&deptId=' + data.id)
                                    .error(function (data, status, headers, config) {
                                        basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                                    });
                            })
                            basecampConfig.debug && console.log('Group Info:', groupInfo);

                            $scope.main.groups.push( groupInfo );
                        })
                    })
                }
            });
        $scope.changePosition = function(person, position) {
            $http.get('../changePosition.php?person=' + person + '&position=' + position)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while changePosition: ' + data);
                })
        }

        $scope.newPosition = function(pos, isElevated, dept) {
            return $http.get('newPosition.php?position=' + pos + '&elevated=' + isElevated + '&dept=' + dept)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while changePosition: ' + data);
                })
        }
    }])

    .controller('DashboardController',  ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        var email = document.getElementById('userInfo').innerHTML;
        $scope.getPeople().success(function (data, status, headers, config) {
            $scope.people = data;
            var personId = 0;
            angular.forEach(data, function(person) {
                if (person.email_address == email) {
                    personId = person.id;
                }
            })
            $scope.id = personId;
            $scope.getPersonInfo(personId).success(function(data, status, headers, config) {
            	$scope.person = data;
            })

            $scope.personDepts = $scope.getPersonDepts(personId);

// alert(member.name + ' ' + JSON.stringify(ids) + ' ' + ids.includes(member.id));


			

            $scope.getPersonRoles(personId).success(function (data, status, headers, config) {
                $scope.role = data;

                //update all userds in your departments
                $scope.members = {};
                if($scope.role.addOfficer){
                    $scope.getPeople().success(function(data, status, headers, config) {
                        angular.forEach(data,function(member){
                            $scope.getExtraPersonInfo(member.id).success(function(data, status, headers, config) {
                                var personInfo = member;
                                personInfo.bio = data.bio;
                                personInfo.major = data.major;
                                personInfo.classStanding = data.classStanding;
                                personInfo.hometown = data.hometown;
                                personInfo.fact = data.fact;
                                personInfo.position = data.position;
                                personInfo.positionId = data.positionId;
                                if(!$scope.contains(personInfo, $scope.members))
                                    $scope.members[member.id] = personInfo; 
                            })
                        })
                    })
                }else{
                    $scope.getGroups().success(function(data, status, headers, config) {
                        angular.forEach(data,function(dept){
                            $scope.getGroup(dept.id).success(function(data, status, headers, config) {
                                angular.forEach(data.memberships, function(person){
                                    if(person.id == personId){
                                        angular.forEach(data.memberships,function(member){
                                            $scope.getExtraPersonInfo(member.id).success(function(data, status, headers, config) {
                                                var personInfo = member;
                                                personInfo.bio = data.bio;
                                                personInfo.major = data.major;
                                                personInfo.classStanding = data.classStanding;
                                                personInfo.hometown = data.hometown;
                                                personInfo.fact = data.fact;
                                                personInfo.position = data.position;
                                                personInfo.positionId = data.positionId;
                                                if(!$scope.contains(personInfo, $scope.members))
                                                    $scope.members[member.id] = personInfo; 
                                            })
                                        })
                                    }
                                })
                            })
                        })
                    })
                }
            
                $scope.positionDepartmentList = [];
                if ($scope.role.addOfficer) {
                    $scope.getGroups().success(function (data, status, headers, config) {
                        $scope.positionDepartmentList = data;
                        $scope.deotDescriptions = data
                    })
                } else {
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
                            angular.forEach(data, function(position) {
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
                        })
                    })
                })

                $scope.deptDescriptions = {};
                $scope.getGroups().success(function(data, status, headers, config) {
                    angular.forEach(data, function(dept){
                        $scope.getExtraDeptInfo(dept.id).success(function(data, status, headers, config) {
                            $scope.deptDescriptions[data.id] = data.description;
                        })
                    })
                })

                $scope.execIIds = [];
                $scope.executiveOfficers = [];
                $scope.getPeopleInRole(1).success(function(data, status, headers, config) {
                    angular.forEach(data, function(person){
                        if(!$scope.execIIds.includes(person.personId)){
                            $scope.execIIds.push(person.personId);
                        }
                    })
                    angular.forEach($scope.execIIds, function(per){
                        $scope.getPersonInfo(per).success(function(data, status, headers, config) {
                            $scope.executiveOfficers.push(data.name);
                        })
                    })
                })

                $scope.cabinetIds = [];
                $scope.cabinetOfficers = [];
                $scope.getPeopleInRole(2).success(function(data, status, headers, config) {
                    angular.forEach(data, function(person){
                        if(!$scope.cabinetIds.includes(person.personId)){
                            $scope.cabinetIds.push(person.personId);
                        }
                    })

                    angular.forEach($scope.cabinetIds,function(per){
                        $scope.getPersonInfo(per).success(function(data, status, headers, config) {
                            $scope.cabinetOfficers.push(data.name);
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
            var args =	 'id=' + $scope.id;
            args += '&bio=' + $scope.role.bio;
            args += '&major=' + $scope.role.major;
            args += '&classStanding=' + $scope.role.classStanding;
            args += '&hometown=' + $scope.role.hometown;
            args += '&fact=' + $scope.role.fact;
            args += '&position=' + $scope.role.positionId;
            $scope.arg = args;
            $http.get('../updatePerson.php?' + args)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        

        $scope.addAd = false;
        $scope.addAdmin = function(){
            $scope.addAd = true;
            $scope.getPersonInfo($scope.newAdmin).success(function(data, status, headers, config) {
            	$scope.executiveOfficers.push(data.name);
            })
            $scope.changeRole($scope.newAdmin,0,1);
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

       	$scope.memberUpdate = false;
       	$scope.memberChanged = 0;
       	$scope.UpdateDeptMember = function(){
       		$scope.memberUpdate = true;
       		var args = 'id=' + $scope.memberChanged;
            args += '&bio=' + $scope.members[$scope.memberChanged].bio;
            args += '&major=' + $scope.members[$scope.memberChanged].major;
            args += '&classStanding=' + $scope.members[$scope.memberChanged].classStanding;
            args += '&hometown=' + $scope.members[$scope.memberChanged].hometown;
            args += '&fact=' + $scope.members[$scope.memberChanged].fact;
            args += '&position=' + $scope.members[$scope.memberChanged].positionId;
            $scope.arg = args;
            $http.get('../updatePerson.php?' + args)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
       	}

        $scope.removePosition = false;
        $scope.errorPosition = false;
        $scope.removedDept = 0;
        $scope.removedPos = 0;
        $scope.deletaDepartment = function(){
            $scope.removePosition = true;
            $scope.errorPosition = false;
            $http.get('../removePosition.php?positionId=' + $scope.removedPos + '&departmentId=' + $scope.removedDept);
            var i = 0;
            angular.forEach($scope.departmentPositions[$scope.removedDept],function(pos){
                if(pos.id == $scope.removedPos){
                    if(pos.holder <= 0){
                        $scope.departmentPositions[$scope.removedDept].splice(i,1);
                    }else{
                        $scope.removePosition = false;
                        $scope.errorPosition = true;
                    }
                }
                i++;
            })
            i = 0;
            angular.forEach($scope.positions,function(pos){
                if(pos.id == $scope.removedPos && pos.dept == $scope.removedDept ){
                    if(pos.holder == 0){
                       $scope.positions.splice(i,1);
                   }else{
                       $scope.removePosition = false;
                       $scope.errorPosition = true;
                   }
                }
                i++;
            })
            i = 0;
            angular.forEach($scope.removePositions[$scope.removedDept].positions,function(pos){
                if(pos.id == $scope.removedPos && pos.dept == $scope.removedDept  && pos.holder == 0){
                    $scope.removePositions[$scope.removedDept].positions.splice(i,1);
                }
                i++;  
            })
        }

        $scope.addExec = false;
        $scope.addExecutive = function(){
            $scope.addExec = true;
            $scope.getPersonInfo($scope.newExec).success(function(data, status, headers, config) {
            	$scope.cabinetOfficers.push(data.name);
            })
            $scope.changeRole($scope.newExec,0,2);
        }

        $scope.removeRoles = false;
        $scope.RemoveAllRoles = function(){
            $scope.removeRoles = true;
            $scope.getPersonInfo($scope.normalRole).success(function(data, status, headers, config) {
            	if($scope.cabinetOfficers.indexOf(data.name) >=0){
            		$scope.cabinetOfficers.splice($scope.cabinetOfficers.indexOf(data.name), 1);
            	}
            	if($scope.executiveOfficers.indexOf(data.name) >= 0){
	            	$scope.executiveOfficers.splice($scope.executiveOfficers.indexOf(data.name), 1);
	            }
            })
            $scope.changeRole($scope.normalRole,0,3);
        }

       $scope.changeDeptDescription = false;
       $scope.deptChangeId = 0;
       $scope.saveDescription = function(){
            $scope.changeDeptDescription = true;
            $scope.url = '../UpdateDepartment.php?id=' + $scope.deptChangeId +'&description=' + $scope.deptDescriptions[$scope.deptChangeId];
            $http.get('../UpdateDepartment.php?id=' + $scope.deptChangeId +'&description=' + $scope.deptDescriptions[$scope.deptChangeId])
       }
    }])