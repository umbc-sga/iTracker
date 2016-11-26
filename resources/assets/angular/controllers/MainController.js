'use strict';

/**
 * Main controller that holds some global data
 *
 * Fetches and stores some initial data in the main property to display global statistics
 */
angular.module('itracker')
    .controller('MainController', ['$scope', '$http', '$log', 'dataService', 'basecampService',
        function ($scope, $http, $log, dataService, basecampService) {

        /**
         * Container for some global data
         */
        $scope.main = {
            people: [],
            projects: [],
            groups: [],
            projectCounts: {},
            activeTodoLists: [],
            completedTodoLists: [],
            activeTodoListsCompletedCount: 0,
            activeTodoListsRemainingCount: 0,
            completedTodoListsCompletedCount: 0,
            completedTodoListsRemainingCount: 0,
            emails: {}
        };

        /**
         * Get all people
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getPeople = () => {
            return basecampService.people().catch((err) => $log.error('Error while getting projects', err));
        };

        $scope.getPersonInfo = function(personID) {
            return null;
            return $http.get('get.php?url=people/' + personID +'.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting projects: ' + data);
                })
        };

        $scope.getPersonProj = function(personID) {
            return null;
            return $http.get('get.php?url=people/' + personID +'/projects.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting projects: ' + data);
                })
        };

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
            });
            return person;
        };

        $scope.getPersonEvents= function(personID, page) {
            return $http.get("get.php?url=people/" + personID + "/events.json%3Fsince=2015-01-01T00:00:00%26page=" + page)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getGroups = function(){
            return $http.get('get.php?url=groups.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting groups: ' + data);
                })
        };

        $scope.getGroup = function(groupId){
            return $http.get('get.php?url=groups/' + groupId + '.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting group : ' + groupId + data);
                })
        };

        $scope.getDepartmentProjects = function(id){
            var projIDs = [];
            var projects = [];
            $scope.getGroup(id).success(function (data, status, headers, config) {
                angular.forEach(data.memberships, function(person){
                    $scope.getPersonProj(person.id).success(function (data, status, headers, config) {
                        angular.forEach(data, function(proj){
                            if((!proj.template) && (proj.id != 9793820) && (projIDs.indexOf(proj.id) == -1)) {
                                projIDs.push(proj.id);
                                $scope.getProject(proj.id).success(function (data, status, headers, config) {
                                    projects.push(data);
                                })
                            }

                        })
                    })
                })
            });
            return projects;
        };

        /**
         * Get all projects
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getProjects = function () {
            return $http.get('get.php?url=projects.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting projects: ' + data);
                })
        };

        $scope.getProject = function (id) {
            return $http.get('get.php?url=projects/' + id + '.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting projects: ' + data);
                })
        };

        /**
         * Get all active todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getActiveTodoLists = function () {
            return $http.get('get.php?url=todolists.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting active todo lists: ' + data);
                });
        };

        /**
         * Get all completed todo lists
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getCompletedTodoLists = function () {
            return $http.get('get.php?url=todolists/completed.json')
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getProjectAccesses = function(id){
            return $http.get("get.php?url=projects/" + id + "/accesses.json")
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting project accesses: ' + data);
                })
        };

        $scope.getExtraPersonInfo = function(id){
            return $http.get("getRecord.php?table=person&id=" + id)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getExtraDeptInfo = function(id){
            return $http.get('getRecord.php?table=department&id=' + id)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getPersonPack = function(id){
            var per = {};
            $scope.getPersonInfo(id).success(function(data, status, headers, config) {
                per.id = data.id;
                per.name = data.name;
                per.email = data.email_address;
                per.todoCount = data.assigned_todos.count;
                per.eventCount = data.events.count;
                per.avatar_url = data.avatar_url;
                per.active = 0;
                per.archive = 0;

                $scope.getPersonProj(id).success(function(data, status, headers, config) {
                    angular.forEach(data, function(proj){
                        if (!proj.template) {
                            if(!proj.archived) {
                                per.active++;
                            }else{
                                per.archive++;
                            }
                        }
                    })
                });
                $scope.getExtraPersonInfo(id).success(function(data, status, headers, config) {
                    per.bio = data.bio;
                    per.major = data.major;
                    per.classStanding = data.classStanding;
                    per.hometown = data.hometown;
                    per.fact = data.fact;
                    per.position = data.position;
                })
            });
            return per;
        };


        $scope.getProjectPack = function(id){
            var proj = {};
            $scope.getProject(id).success(function(data, status, headers, config) {
                proj.id = data.id;
                proj.name = data.name;
                proj.description = data.description;
                proj.creator = data.creator.name;
                proj.events = data.calendar_events.count
                proj.docs = data.documents.count;
                proj.created_at = data.created_at;
                proj.updated_at = data.updated_at;

                if(data.archived){
                    proj.status = "Archived";
                }else{
                    proj.status = "Active";
                }

            });
            return proj;
        };

        $scope.getPersonDepts = function(id){
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
            });
            return departments;
        };

        $scope.getProjectEvents= function(id, page){
            return $http.get("get.php?url=projects/" + id + "/events.json%3Fsince=2015-01-01T00:00:00%26page=" + page)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getPersonRoles = function(id){
            return $http.get("getRole.php?id=" + id)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting role: ' + data);
                })
        };

        $scope.getRole = function(id){
            return $http.get('getRecord.php?table=role&id=' + id)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting completed todo lists: ' + data);
                })
        };

        $scope.getRolePerson = function(roleId, departmentId){
            return $http.get('getRoleHolder.php?dept=' + departmentId + "&role=" + roleId)
                .error(function (data, status, headers, config) {
                    $log.debug('Error while getting role: ' + data);
                })
        };

        $scope.changeRole = function(person, dept, role){
            $http.get("changeRole.php?person=" + person + "&dept=" + dept + "&role=" + role);
        };
        /**
         * Get project counts
         *
         * @param projectId
         * @returns {
         *     activeTodoListsCompletedCount: 0,
         *     activeTodoListsRemainingCount: 0,
         *     completedTodoListsCompletedCount: 0,
         *     completedTodoListsRemainingCount: 0,
         *     allTodoListsCompletedCount: 0,
         *     allTodoListsCompletedCount: 0,
         *     percentComplete: 0
         * }
         */
        $scope.getProjectCounts = function(projectId){

            var result = {
                activeTodoListsCompletedCount: 0,
                activeTodoListsRemainingCount: 0,
                completedTodoListsCompletedCount: 0,
                completedTodoListsRemainingCount: 0,
                allTodoListsCompletedCount: 0,
                percentComplete: 0
            };

            if(angular.isUndefined(projectId)){
                return result;
            }

            // Return cached result if there is one
            if(angular.isDefined($scope.main.projectCounts[projectId])){
                return $scope.main.projectCounts[projectId];
            }

            // Loop over active todo lists and count todo's
            angular.forEach($scope.main.activeTodoLists, function(todoList){
                if(todoList.bucket.id === projectId){
                    result.activeTodoListsCompletedCount += todoList.completed_count;
                    result.activeTodoListsRemainingCount += todoList.remaining_count;
                }
            });

            // Loop over completed todo lists and count todo's
            angular.forEach($scope.main.completedTodoLists, function(todoList){
                if(todoList.bucket.id === projectId){
                    result.completedTodoListsCompletedCount += todoList.completed_count;
                    result.completedTodoListsRemainingCount += todoList.remaining_count;
                }
            });

            // Only store result in cache if all data was fetched correctly so the numbers get updated
            // when todo lists are still being fetched
            if($scope.main.projects.length && $scope.main.activeTodoLists.length && $scope.main.completedTodoLists.length){

                // Calculate some extra statistics
                result.allTodoListsCompletedCount = result.activeTodoListsCompletedCount + result.completedTodoListsCompletedCount;
                result.allTodoListsRemainingCount = result.activeTodoListsRemainingCount + result.completedTodoListsRemainingCount;
                result.percentComplete = result.allTodoListsCompletedCount * (100 / (result.allTodoListsCompletedCount + result.allTodoListsRemainingCount));

                // Store in cache
                $scope.main.projectCounts[projectId] = result;
            }

            return result;
        };


        /**
         * Recalculate main counters when main active todo lists change
         */
        $scope.$watch('main.activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            // Do nothing of nothing changed
            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            $log.debug('Recalculate main active todo list counters');

            // Reset main counters
            $scope.main.activeTodoListsCompletedCount = 0;
            $scope.main.activeTodoListsRemainingCount = 0;

            // Increment counters
            angular.forEach(activeTodoLists, function (todoList) {

                // Increment main counters
                $scope.main.activeTodoListsCompletedCount += todoList.completed_count;
                $scope.main.activeTodoListsRemainingCount += todoList.remaining_count;
            })
        }, true);

        /**
         * Recalculate main counters when main completed todo lists change
         */
        $scope.$watch('main.completedTodoLists', function (completedTodoLists, oldCompletedTodoLists) {

            // Do nothing of nothing changed
            if (completedTodoLists === oldCompletedTodoLists) {
                return;
            }

            $log.debug('Recalculate main completed todo list counters');

            // Reset counters
            $scope.main.completedTodoListsCompletedCount = 0;
            $scope.main.completedTodoListsRemainingCount = 0;

            // Increment counters
            angular.forEach(completedTodoLists, function (todoList) {
                $scope.main.completedTodoListsCompletedCount += todoList.completed_count;
                $scope.main.completedTodoListsRemainingCount += todoList.remaining_count;
            })
        }, true);

        /**
         * Bootstrap data
         *
         * Get projects and if it succeeds also get the todo lists
         */
        $scope.bootstrapData = function(){

            $scope.getProjects().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    $scope.main.projects = data;
                    $log.debug('Projects:', data);

                    $scope.getActiveTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.activeTodoLists = data;
                            $log.debug('Active todo lists:', data);
                        }
                    });

                    $scope.getCompletedTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.completedTodoLists = data;
                            $log.debug('Completed todo lists:', data);
                        }
                    });
                }
            });

            $scope.getPeople().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawPeople = data;
                    // $log.debug('People:', rawPeople);

                    angular.forEach (rawPeople, function (person) {
                        var personInfo = [];
                        var personProj = [];
                        $scope.main.emails[person.email] = person.id;
                        $http.get('newRecord.php?table=person&id=' + person.id)
                            .error(function (data, status, headers, config) {
                                $log.debug('Error while inserting new person ' + data);
                            });
                        $scope.getPersonInfo(person.id).success(function (data, status, headers, config) {
                            var badEmails = ['sga@umbc.edu','berger@umbc.edu','saddison@umbc.edu'];
                            if (badEmails.indexOf(data.email_address) == -1) {
                                personInfo = data;
                                $log.debug('Person Info:', personInfo);

                                $scope.getPersonProj(person.id).success(function (data, status, headers, config) {
                                    // if (angular.isArray(data)) {
                                    personProj = data;
                                    $log.debug('Person Info:', personInfo);

                                    $scope.main.people.push( { 'info' : personInfo, 'proj' : personProj } );
                                    // }
                                })
                            }
                        })
                    })
                }
            });

            $scope.getGroups().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawGroups = data;

                    angular.forEach (rawGroups, function (group) {
                        $http.get('newRecord.php?table=department&id=' + group.id)
                            .error(function (data, status, headers, config) {
                                $log.debug('Error while getting completed todo lists: ' + data);
                            });

                        $scope.getGroup(group.id).success(function (data, status, headers, config) {
                            var groupInfo = data;
                            var group_href = replace_All(replace_All(groupInfo.name.toLowerCase()," ", "-") , "&", "and");
                            groupInfo.group_href = group_href;

                            angular.forEach(data.memberships, function(person){

                                $http.get('newRole.php?personId=' + person.id + '&deptId=' + data.id)
                                    .error(function (data, status, headers, config) {
                                        $log.debug('Error while getting completed todo lists: ' + data);
                                    });
                            });
                            $log.debug('Group Info:', groupInfo);

                            $scope.main.groups.push( groupInfo );
                        })
                    })
                }
            });
        };

        $scope.bootstrapData();

    }]);