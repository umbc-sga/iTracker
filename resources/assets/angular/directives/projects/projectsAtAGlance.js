'use strict';

angular.module('itracker')
    .directive('projectsAtAGlance', [function(){
            return {
                restrict: 'C',
                scope: {
                    projects: '=',
                    readMore: '='
                },
                templateUrl: '/angular/proj.projectsAtAGlance'
            };
        }]);
