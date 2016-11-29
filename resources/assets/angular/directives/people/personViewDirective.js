'use strict';

angular.module('itracker')
    .directive('personView', [function(){
            return {
                restrict: 'C',
                scope: {
                    person: '='
                },
                templateUrl: '/angular/people.personView'
            };
        }]);
