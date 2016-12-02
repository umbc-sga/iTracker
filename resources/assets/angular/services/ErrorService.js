'use strict';

angular.module('itracker')
    .factory('errorService', ['$window', function($window) {
        return {
           getErrors: () => $window.errs
        };
    }]);