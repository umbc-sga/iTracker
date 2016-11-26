'use strict';

/**
 * Controller for the page that shows the todo lists for a certain project
 */
angular.module('itracker')
    .controller('TodoListController', ['$scope','$http', '$routeParams',
        function ($scope, $http, $routeParams) {

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
            });

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
    }]);