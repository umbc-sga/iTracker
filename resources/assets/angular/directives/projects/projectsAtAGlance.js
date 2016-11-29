'use strict';

angular.module('itracker')
    .directive('projectsAtAGlance', [function(){
            return {
                restrict: 'C',
                scope: {
                    projects: '='
                },
                templateUrl: '/angular/proj.projectsAtAGlance'
            };
        }]);
