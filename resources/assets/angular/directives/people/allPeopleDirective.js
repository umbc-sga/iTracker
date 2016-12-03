'use strict';

angular.module('itracker')
    .directive('allPeople', [function(){
            return {
                restrict: 'C',
                scope: {
                    people: '='
                },
                templateUrl: '/angular/people.allPeople'
            };
        }]);
