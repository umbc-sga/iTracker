'use strict';

angular.module('itracker')
    .directive('projectsAtAGlance', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    projects: '=',
                    readMore: '='
                },
                templateUrl: apiService.root+'/angular/proj.projectsAtAGlance'
            };
        }]);
