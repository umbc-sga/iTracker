var monthNames = ["January", "February", "March", "April", "May", "June",
  "July", "August", "September", "October", "November", "December"
];

function replace_All(str, find, replace){
    while(str.indexOf(find) != -1){
        str = str.replace(find, replace);
    }
    return str;
}

angular.module('basecamp', ['ngSanitize'])

    .config(['$routeProvider','$locationProvider', function ($routeProvider, $locationProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'templates/home.html',
                controller: 'HomeController'
            })
            .when('/people/by-dept/', {
                templateUrl: 'templates/people-by-dept.html',
                controller: 'PeopleByDeptController'
            })
            .when('/people/by-name/', {
                templateUrl: 'templates/people-by-name.html',
                controller: 'PeopleByNameController'
            })
            .when('/people/:personId/', {
                templateUrl: 'templates/person.html',
                controller: 'PersonController'
            })
            .when('/projects/by-name/', {
                templateUrl: 'templates/projects-by-name.html',
                controller: 'ProjectsByNameController'
            })
            .when('/projects/by-dept/', {
                templateUrl: 'templates/projects-by-dept.html',
                controller: 'ProjectsByDeptController'
            })
            .when('/projects-old/:projectId/', {
                templateUrl: 'templates/project-orig.html',
                controller: 'ProjectController'
            })
            .when('/projects/:projectId/', {
                templateUrl: 'templates/project.html',
                controller: 'ProjectController'
            })
            .when('/projects/:projectId/todolists/:todoListId', {
                templateUrl: 'templates/todo-list.html',
                controller: 'TodoListController'
            })
            .when('/departments/:departmentName', {
                templateUrl: 'templates/department.html',
                controller: 'DepartmentController'
            })
            .when('/:personId/dashboard',{
                templateUrl: 'templates/dashboard.html',
                controller: 'DashboardController'
            })
            .otherwise({
                templateUrl: 'templates/404-error.html',
                controller: 'ErrorController'
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
            completedTodoListsRemainingCount: 0
        };

        /**
         * Get all people
         *
         * Returns promise so additional callbacks can be attached
         */
        $scope.getPeople = function () {
            // var rawPeople = $http.get('get.php?url=people.json');
            // var finalPeople = [];
            // for (var i = 0; i <= rawPeople.length; i++) {
            //     var personInfo = $http.get('get.php?url=people/' + rawPeople[i]["id"] +'.json');
            //     var personProj = $http.get('get.php?url=people/' + rawPeople[i]["id"] +'/projects.json');
            //     finalPeople.push( { "info" : personInfo, "projects" : personProj } );
            // }
            // return finalPeople;
            return $http.get('get.php?url=people.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        

        $scope.getPersonInfo = function(personID) {
            return $http.get('get.php?url=people/' + personID +'.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getPersonProj = function(personID) {
            return $http.get('get.php?url=people/' + personID +'/projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getPersonEvents= function(personID, page) {
            if (page === 1) {
                return $http.get("get.php?url=people/" + personID + "/events.json%3Fsince=2015-01-01T00:00:00")
                    .error(function (data, status, headers, config) {
                        basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                    })
            } else {
                return $http.get("get.php?url=people/" + personID + "/events.json%3Fsince=2015-01-01T00:00:00&page=" + page)
                    .error(function (data, status, headers, config) {
                        basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                    })
            }
        }

        $scope.getGroups = function(){
            return $http.get('get.php?url=groups.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting groups: ' + data);
                })
        }

        $scope.getGroup = function(groupId){
            return $http.get('get.php?url=groups/' + groupId + '.json')
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
            return $http.get('get.php?url=projects.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting projects: ' + data);
                })
        }

        $scope.getProject = function (id) {
            return $http.get('get.php?url=projects/' + id + '.json')
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
            return $http.get('get.php?url=todolists.json')
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
            return $http.get('get.php?url=todolists/completed.json')
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getProjectAccesses = function(id){
            return $http.get("get.php?url=projects/" + id + "/accesses.json")
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting project accesses: ' + data);
                })
        }

        $scope.getExtraPersonInfo = function(id){
            return $http.get("getRecord.php?table=person&id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getExtraDeptInfo = function(id){
            return $http.get('getRecord.php?table=department&id=' + id)
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
            return $http.get("get.php?url=projects/" + id + "/events.json%3Fsince=2015-01-01T00:00:00%26page=" + page)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting completed todo lists: ' + data);
                })
        }

        $scope.getPersonRoles = function(id){
            return $http.get("getRole.php?id=" + id)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }

        $scope.getRolePerson = function(roleId, departmentId){
            return $http.get('getRoleHolder.php?dept=' + departmentId + "&role=" + roleId)
                .error(function (data, status, headers, config) {
                    basecampConfig.debug && console.log('Error while getting role: ' + data);
                })
        }
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
        }

        
        /**
         * Recalculate main counters when main active todo lists change
         */
        $scope.$watch('main.activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            // Do nothing of nothing changed
            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            basecampConfig.debug && console.log('Recalculate main active todo list counters');

            // Reset main counters
            $scope.main.activeTodoListsCompletedCount = 0;
            $scope.main.activeTodoListsRemainingCount = 0;

            // Increment counters
            angular.forEach(activeTodoLists, function (todoList) {

                // Increment main counters
                $scope.main.activeTodoListsCompletedCount += todoList.completed_count;
                $s