'use strict';

angular.module('itracker', ['ui.router']);
'use strict';

angular.module('itracker').directive('someDirective', [function () {
    return {
        restrict: 'C',
        controller: ['$scope', function ($scope) {
            $scope.now = new Date().toUTCString();
        }],
        templateUrl: '/angular/template'
    };
}]);