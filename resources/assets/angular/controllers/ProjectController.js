'use strict';

/**
 * Controller for the page that displays project details
 */
angular.module('itracker')
    .controller('ProjectController', ['$scope','$http', '$routeParams',
        function ($scope, $http, $routeParams) {

    $scope.project = {};
    $scope.events = [];

    $scope.activeTodoLists = [];
    $scope.completedTodoLists = [];

    $scope.activeTodoListsCompletedCount = 0;
    $scope.activeTodoListsRemainingCount = 0;

    $scope.completedTodoListsCompletedCount = 0;
    $scope.completedTodoListsRemainingCount = 0;

    $scope.prettyDate = function(dateTime){
        var dateStr = dateTime.substring(0,dateTime.indexOf('T'));
        var year = dateStr.substring(0,dateStr.indexOf('-'));
        var rest = dateStr.substring(dateStr.indexOf('-') + 1);
        var month = monthNames[parseInt(rest.substring(0,rest.indexOf('-'))) - 1];
        rest = rest.substring(rest.indexOf('-') + 1);
        var day = rest;
        var prettyDate = day + ' ' + month + ' ' + year;
        return prettyDate;
    };
    $http.get('get.php?url=projects/' + $routeParams.projectId + '.json')
        .success(function (data, status, headers, config) {
            // console.log('SUCCESS');
            // this callback will be called asynchronously
            // when the response is available
            var project = angular.fromJson(data);
            if (angular.isObject(project)) {
                $scope.project = project;
            }
        }).
    error(function (data, status, headers, config) {
        // called asynchronously if an error occurs
        // or server returns response with an error status.
        console.log('ERROR');
    });

    $scope.page = 1;
    $scope.more = true;
    $scope.limit = 10;
    $scope.pull = true;
    $scope.getEventSet = function(){
        if($scope.pull && $scope.limit >= $scope.events.length){
            var curDate = '';
            $scope.getProjectEvents($routeParams.projectId, $scope.page).success(function (data, status, headers, config) {
                if(data.length < 50){
                    $scope.pull = false;
                }
                angular.forEach(data,function (event){
                    event.created_at = $scope.prettyDate(event.created_at);
                    event.updated_at = $scope.prettyDate(event.updated_at);

                    var date = event.created_at;
                    if (date === curDate) {
                        event.created_at = '';
                    }

                    curDate = date;
                    $scope.events.push(event);
                });
                $scope.page++;
                if($scope.limit >= $scope.events.length){
                    $scope.more = false;
                }
            })
        }else if($scope.limit >= $scope.events.length){
            $scope.more = false;
        }
    };
    $scope.getEventSet();

    $scope.getProjectAccesses($routeParams.projectId).success(function (data, status, headers, config) {
        $scope.people = data;
    });


    // Get active todo lists
    $scope.activeTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists.json')
        .success(function (data, status, headers, config) {
            // console.log('SUCCESS');
            // this callback will be called asynchronously
            // when the response is available
            $scope.activeTodoLists = [];
            angular.forEach(data, function(list){
                $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/' + list.id + '.json')
                    .success(function (data, status, headers, config) {
                        $scope.activeTodoLists.push(data);
                    })
            });
            // console.log(activeTodoLists)
        }).
        error(function (data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            console.log('ERROR');
        });

    // Get active todo lists
    $scope.completedTodoLists = $http.get('get.php?url=projects/' + $routeParams.projectId + '/todolists/completed.json')
        .success(function (data, status, headers, config) {
            // console.log('SUCCESS');
            // this callback will be called asynchronously
            // when the response is available
            var completedTodoLists = angular.fromJson(data);
            if (angular.isArray(completedTodoLists)) {
                $scope.completedTodoLists = completedTodoLists;
                // console.log(completedTodoLists);
            }
        }).
        error(function (data, status, headers, config) {
            // called asynchronously if an error occurs
            // or server returns response with an error status.
            console.log('ERROR');
        });


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
}]);