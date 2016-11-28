'use strict';

angular.module('itracker',[
    //'ui.router',
    'ngRoute',
]).config(['$routeProvider','$locationProvider', '$logProvider',
    function ($routeProvider, $locationProvider, $logProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/angular/pages.home',
        })
        .when('/departments/people', {
            templateUrl: '/angular/pages.departmentPeople',
        })
        .when('/people', {
            templateUrl: '/angular/pages.allPeople',
        })
        .when('/person/:personId/', {
            templateUrl: '/angular/pages.person',
        })
        .when('/projects/', {
            templateUrl: '/angular/pages.allProjects',
        })
        .when('/departments', {
            templateUrl: '/angular/pages.allDepartments',
        })
        .when('/project/:projectId/', {
            templateUrl: '/angular/pages.project',
        })
        .when('/projects/:projectId/todolists/:todoListId', {
            templateUrl: '/angular/legacy.todo-list',
            controller: 'TodoListController'
        })
        .when('/departments/:departmentName', {
            templateUrl: '/angular/pages.department'
        })
        .otherwise({
            templateUrl: '/angular/pages.404-error'
        });

    $locationProvider.html5Mode(true);

    $logProvider.debugEnabled(window.debug || false);

}]);

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

