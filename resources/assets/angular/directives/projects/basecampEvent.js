'use strict';

angular.module('itracker')
    .directive('basecampEvent', [function(){
            return {
                restrict: 'C',
                scope: {
                    event: '=',
                },
                templateUrl: '/angular/proj.basecampEvent'
            };
        }]);