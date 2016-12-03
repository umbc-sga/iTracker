'use strict';

angular.module('itracker')
    .directive('personProfile', [function(){
            return {
                restrict: 'C',
                scope: {
                    profile: '='
                },
                templateUrl: '/angular/profile.personProfile'
            };
        }]);
