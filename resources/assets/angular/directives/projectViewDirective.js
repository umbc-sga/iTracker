'use strict';

angular.module('itracker')
    .directive('projectView', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                scope: {
                    project: '='
                },
                controller: ['$scope', ($scope) => {
                    let randomColor = () => ("000000" + Math.random().toString(16).slice(2, 8).toUpperCase()).slice(-6);

                    $scope.colorPic = randomColor();
                }],
                templateUrl: '/angular/projectView'
            };
        }]);
