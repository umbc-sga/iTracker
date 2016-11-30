'use strict';

angular.module('itracker')
    .directive('project', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    let projectId = $routeParams.projectId;

                    $scope.project = {};
                    $scope.events = [];

                    $scope.loaded = false;

                    $scope.activeTodoLists = [];
                    $scope.completedTodoLists = [];

                    $scope.activeTodoListsCompletedCount = 0;
                    $scope.activeTodoListsRemainingCount = 0;

                    $scope.completedTodoListsCompletedCount = 0;
                    $scope.completedTodoListsRemainingCount = 0;

                    $scope.prettyDate = function(dateTime){
                        let dateStr = dateTime.substring(0,dateTime.indexOf('T'));
                        let year = dateStr.substring(0,dateStr.indexOf('-'));
                        let rest = dateStr.substring(dateStr.indexOf('-') + 1);
                        let month = monthNames[parseInt(rest.substring(0,rest.indexOf('-'))) - 1];
                        rest = rest.substring(rest.indexOf('-') + 1);
                        return rest + ' ' + month + ' ' + year;
                    };

                    basecampService.getProject(projectId)
                        .then((response) => $scope.project = response.data)
                        .finally(()=>$scope.loaded = true);

                    $scope.page = 1;
                    $scope.more = true;
                    $scope.limit = 10;
                    $scope.pull = true;

                    $scope.getEventSet = function(){
                        if($scope.pull && $scope.limit >= $scope.events.length){
                            var curDate = '';
                            basecampService.getProjectEvents(projectId, $scope.page).then((response) => {
                                let events = response.data;

                                console.log(events);
                                if(events.length < 50){
                                    $scope.pull = false;
                                }

                                for(let event of events){
                                    event.created_at = $scope.prettyDate(event.created_at);
                                    event.updated_at = $scope.prettyDate(event.updated_at);

                                    let date = event.created_at;
                                    if (date === curDate) {
                                        event.created_at = '';
                                    }

                                    curDate = date;
                                    $scope.events.push(event);
                                }

                                $scope.page++;
                                if($scope.limit >= $scope.events.length){
                                    $scope.more = false;
                                }
                            });
                        } else if($scope.limit >= $scope.events.length){
                            $scope.more = false;
                        }
                    };
                    //$scope.getEventSet();

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
                }],
                templateUrl: '/angular/proj.project'
            };
        }]);
