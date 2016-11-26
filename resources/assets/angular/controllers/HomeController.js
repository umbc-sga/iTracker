'use strict';

/**
 * Controller for the home page that displays the project overview
 */
angular.module('itracker')
    .controller('HomeController', ['$scope','$http',
        function ($scope, $http) {

        $scope.featuredProjs = [];

        $scope.getProjects().success(function (data, status, headers, config) {
            if (angular.isArray(data)) {
                var rawProjects = data;

                angular.forEach(rawProjects, function (project) {
                    if (project.starred == true) {
                        $scope.featuredProjs.push(project);
                    }
                })
            }
        })
    }]);