'use strict';

angular.module('itracker')
    .directive('featuredProjects', ['basecampService',
        function(basecampService){
        return {
            restrict: 'C',
            scope: {
                projects: '='
            },
            controller: ['$scope', ($scope) => {
                $scope.featuredProjs = [];

                if (Array.isArray($scope.projects))
                    for(let project of $scope.projects)
                        if (project.bookmarked == true) {
                            project.updated_at = new Date(project.updated_at);
                            $scope.featuredProjs.push(project);
                        }
            }],
            templateUrl: '/angular/proj.featuredProjects'
        };
    }]);
