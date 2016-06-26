function replace_All(str, find, replace){
    while(str.indexOf(find) != -1){
        str = str.replace(find, replace);
    }
    return str;
}

function comparePeople( p, q ){
    return p.name.localeCompare(q.name);
}

angular.module('basecamp', [])

    .config(function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: 'templates/home.html',
                controller: 'HomeController'
            })
            .when('/people/by-dept', {
                templateUrl: 'templates/people-by-dept.html',
                controller: 'PeopleByDeptController'
            })
            .when('/people/by-name', {
                templateUrl: 'templates/people-by-name.html',
                controller: 'PeopleByNameController'
            })
            //.when('/projects/by-name', {})
            .when('/projects/by-dept', {
                templateUrl: 'templates/projects-by-dept.html',
                controller: 'ProjectsByDeptController'
            })
            .when('/projects/:projectId', {
                templateUrl: 'templates/project.html',
                controller: 'ProjectController'
            })
            .when('/projects/:projectId/todolists/:todoListId', {
                templateUrl: 'templates/todo-list.html',
                controller: 'TodoListController'
            })
            //.when('/projects/:projectName', {})
            //.when('/people/:personName', {})
            //.when('/departments/members', {})
            //.when('/departmenet/projects', {})
            //.when('/departments/:departmentName', {})
    })

    .value('basecamp.config', {
        debug: true // Set to false to disable logging to console
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

        $scope.getPersonPack = function(id){
            var per = {};
            $scope.getPersonInfo(id).success(function(data, status, headers, config) {
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

            basecampConfig.debug && console.log('Recalculate main completed todo list counters');

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
                    basecampConfig.debug && console.log('Projects:', data);

                    $scope.getActiveTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.activeTodoLists = data;
                            basecampConfig.debug && console.log('Active todo lists:', data);
                        }
                    });

                    $scope.getCompletedTodoLists().success(function (data, status, headers, config) {
                        if (angular.isArray(data)) {
                            $scope.main.completedTodoLists = data;
                            basecampConfig.debug && console.log('Completed todo lists:', data);
                        }
                    });
                }
            });

            $scope.getPeople().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawPeople = data.sort(comparePeople);   
                    // basecampConfig.debug && console.log('People:', rawPeople);

                    angular.forEach (rawPeople, function (person) {
                        var personInfo = [];
                        var personProj = [];

                        $scope.getPersonInfo(person.id).success(function (data, status, headers, config) {
                            // if (angular.isArray(data)) {
                                personInfo = data;
                                basecampConfig.debug && console.log('Person Info:', personInfo);

                                $scope.getPersonProj(person.id).success(function (data, status, headers, config) {
                                    // if (angular.isArray(data)) {
                                        personProj = data;
                                        basecampConfig.debug && console.log('Person Info:', personInfo);

                                        $scope.main.people.push( { 'info' : personInfo, 'proj' : personProj } );
                                    // }
                                })
                            // }
                        }) 
                    })                    
                }
            });

            $scope.getGroups().success(function (data, status, headers, config) {
                if (angular.isArray(data)) {
                    var rawGroups = data;

                    angular.forEach (rawGroups, function (group) {
                        $scope.getGroup(group.id).success(function (data, status, headers, config) {
                            var groupInfo = data;
                            var group_href = replace_All(replace_All(groupInfo.name.toLowerCase()," ", "-") , "&", "and");
                            groupInfo.group_href = group_href;

                            basecampConfig.debug && console.log('Group Info:', groupInfo);

                            $scope.main.groups.push( groupInfo );
                        })
                    })
                }
            });
        }

        $scope.bootstrapData();

    }])

/**
 * Controller for the home page that displays the project overview
 */
    .controller('HomeController', ['$scope','$http', function ($scope, $http) {
    }])

/**
 * Controller for the page that displays project details
 */
    .controller('ProjectController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {

        $scope.project = {};
        $scope.activeTodoLists = [];
        $scope.completedTodoLists = [];

        $scope.activeTodoListsCompletedCount = 0;
        $scope.activeTodoListsRemainingCount = 0;

        $scope.completedTodoListsCompletedCount = 0;
        $scope.completedTodoListsRemainingCount = 0;

        $scope.project = $http.get('get.php?url=projects/' + $routeParams.projectId + '.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var project = angular.fromJson(data);
                if (angular.isObject(project)) {
                    $scope.project = project;
                    console.log(project);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get active todo lists
        $scope.activeTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var activeTodoLists = angular.fromJson(data);
                if (angular.isArray(activeTodoLists)) {
                    $scope.activeTodoLists = activeTodoLists;
                    console.log(activeTodoLists);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get active todo lists
        $scope.completedTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/completed.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var completedTodoLists = angular.fromJson(data);
                if (angular.isArray(completedTodoLists)) {
                    $scope.completedTodoLists = completedTodoLists;
                    console.log(completedTodoLists);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        $scope.$watch('activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            $scope.activeTodoListsCompletedCount = 0;
            $scope.activeTodoListsRemainingCount = 0;

            angular.forEach(activeTodoLists, function (todoList) {
                $scope.activeTodoListsCompletedCount += todoList.completed_count;
                $scope.activeTodoListsRemainingCount += todoList.remaining_count;
            })

        }, true);

        $scope.$watch('completedTodoLists', function (completedTodoLists, oldCompletedTodoLists) {

            if (completedTodoLists === oldCompletedTodoLists) {
                return;
            }

            $scope.completedTodoListsCompletedCount = 0;
            $scope.completedTodoListsRemainingCount = 0;

            angular.forEach(completedTodoLists, function (todoList) {
                $scope.completedTodoListsCompletedCount += todoList.completed_count;
                $scope.completedTodoListsRemainingCount += todoList.remaining_count;
            })

        }, true);
    }])

/**
 * Controller for the page that shows the todo lists for a certain project
 */
    .controller('TodoListController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {

        $scope.projectId = $routeParams.projectId;
        $scope.todoListId = $routeParams.todoListId;
        $scope.todoList = {};

        $scope.project = $http.get('get.php?url=projects/' + $routeParams.projectId + '.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var project = angular.fromJson(data);
                if (angular.isObject(project)) {
                    $scope.project = project;
                    console.log(project);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })

        // Get todo list including todo's
        $scope.todoList = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/' + $routeParams.todoListId + '.json')
            .success(function (data, status, headers, config) {
                console.log('SUCCESS');
                // this callback will be called asynchronously
                // when the response is available
                var todoList = angular.fromJson(data);
                if (angular.isObject(todoList)) {
                    $scope.todoList = todoList;
                    console.log(todoList);
                }
            }).
            error(function (data, status, headers, config) {
                // called asynchronously if an error occurs
                // or server returns response with an error status.
                console.log('ERROR');
            })
    }])

    .controller('PeopleByDeptController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.depts = [];

        $scope.scrollTo = function(id) {
            $location.hash(id);
            $anchorScroll();
            alert(id);
        }

        $scope.getGroups().success(function (data, status, headers, config) {
            angular.forEach(data,function(dept){
                var department = {};
                $scope.getGroup(dept.id).success(function (data, status, headers, config) {
                    department.name = data.name;
                    department.id = data.id;
                    
                    var people = [];
                    angular.forEach(data.memberships, function(person){
                        //.success(function(data, status, headers, config) {
                            people.push($scope.getPersonPack(person.id));
                        //})
                    })
                    department.people = people;
                    $scope.depts.push(department);
                })
            })
        })
    }])

    .controller('PeopleByNameController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {
        $scope.people = {}
        $scope.alpha = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        angular.forEach($scope.alpha, function(letter){
            $scope.people[letter] = [];
        })
        $scope.getPeople().success(function(data, status, headers, config) {
            angular.forEach(data, function(person){
                var letter = person.name[0].toUpperCase();
                $scope.people[letter].push($scope.getPersonPack(person.id));
            })
        })
    }])

    .controller('ProjectsByDeptController', ['$scope','$http', '$routeParams', function ($scope, $http, $routeParams) {

    }])