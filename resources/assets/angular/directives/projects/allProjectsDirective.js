'use strict';

angular.module('itracker')
    .directive('allProjects', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    projects: '='
                },
                controller: ['$scope', ($scope) => {
                    let randomColor = () => Math.floor(Math.random()*16777215).toString(16);

                    $scope.colorPic = randomColor();
                }],
                templateUrl: apiService.root+'/angular/proj.allProjects'
            };
        }]);
