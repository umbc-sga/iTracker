'use strict';

angular.module('itracker')
    .directive('projectView', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    project: '='
                },
                controller: ['$scope', ($scope) => {
                    let randomColor = () => ("000000" + Math.random().toString(16).slice(2, 8).toUpperCase()).slice(-6);

                    $scope.colorPic = randomColor();
                }],
                templateUrl: apiService.root+'/angular/proj.projectView'
            };
        }]);
