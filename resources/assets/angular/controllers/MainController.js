'use strict';

/**
 * Main controller that holds some global data
 *
 * Fetches and stores some initial data in the main property to display global statistics
 */
angular.module('itracker')
    .controller('MainController', ['$scope', 'dataService',
        function ($scope, dataService) {

        /**
         * Container for some global data
         */
        $scope.main = dataService.main;

        /**
         * Recalculate main counters when main active todo lists change
         */
        $scope.$watch('main.activeTodoLists', function (activeTodoLists, oldActiveTodoLists) {

            // Do nothing of nothing changed
            if (activeTodoLists === oldActiveTodoLists) {
                return;
            }

            $log.debug('Recalculate main active todo list counters');

            // Reset main counters
            $scope.main.activeTodoListsCompletedCount = 0;
            $scope.main.activeTodoListsRemainingCount = 0;

            // Increment counters
            for(let list of activeTodoLists){
                $scope.main.activeTodoListsCompletedCount += list.completed_count;
                $scope.main.activeTodoListsRemainingCount += list.remaining_count;
            }
        }, true);

        /**
         * Recalculate main counters when main completed todo lists change
         */
        $scope.$watch('main.completedTodoLists', function (completedTodoLists, oldCompletedTodoLists) {

            // Do nothing of nothing changed
            if (completedTodoLists === oldCompletedTodoLists) {
                return;
            }

            $log.debug('Recalculate main completed todo list counters');

            // Reset counters
            $scope.main.completedTodoListsCompletedCount = 0;
            $scope.main.completedTodoListsRemainingCount = 0;

            // Increment counters
            for(let list of completedTodoLists) {
                $scope.main.completedTodoListsCompletedCount += todoList.completed_count;
                $scope.main.completedTodoListsRemainingCount += todoList.remaining_count;
            }
        }, true);


        $scope.bootstrap = () => dataService.bootstrap();
    }]);