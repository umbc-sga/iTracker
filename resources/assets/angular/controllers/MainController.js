'use strict';

/**
 * Main controller that holds some global data
 *
 * Fetches and stores some initial data in the main property to display global statistics
 */
angular.module('itracker')
    .controller('MainController', ['$scope', '$log', 'dataService',
        function ($scope, $log, dataService) {

        /**
         * Container for some global data
         */
        $scope.data = dataService.main;

        $scope.bootstrap = () => dataService.bootstrap();
    }]);