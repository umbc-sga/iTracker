'use strict';

angular.module('itracker')
    .directive('allProjects', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    $scope.projects = [];

                    basecampService.getProjects().then((response) => $scope.projects = response.data);

                    let randomColor = () => Math.floor(Math.random()*16777215).toString(16);

                    $scope.colorPic = randomColor();
                }],
                templateUrl: '/angular/allProjects'
            };
        }]);
