'use strict';

angular.module('itracker')
    .directive('projectView', [function(){
            return {
                restrict: 'C',
                scope: {
                    project: '='
                },
                controller: ['$scope', ($scope) => {
                    let randomColor = () => ("000000" + Math.random().toString(16).slice(2, 8).toUpperCase()).slice(-6);

                    $scope.colorPic = randomColor();
                }],
                templateUrl: '/angular/proj.projectView'
            };
        }]);
