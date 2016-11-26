'use strict';

angular.module('itracker')
    .directive('featuredProjects', ['basecampService',
        function(basecampService){
        return {
            restrict: 'C',
            controller: ['$scope', ($scope) => {
                $scope.featuredProjs = [];

                basecampService.getProjects().then((projects) => {
                    if (Array.isArray(projects))
                        for(let project of projects)
                            if (project.starred == true)
                                $scope.featuredProjs.push(project);
                });
            }],
            templateUrl: '/angular/featuredProjects'
        };
    }]);
