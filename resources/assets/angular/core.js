'use strict';

angular.module('itracker',[
    //'ui.router',
    'ui.bootstrap',
    'ngRoute',
]).config(['$routeProvider','$locationProvider', '$logProvider', '$compileProvider',
    function ($routeProvider, $locationProvider, $logProvider, $compileProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/angular/pages.home',
        })
        .when('/people', {
            templateUrl: '/angular/pages.allPeople',
        })
        .when('/people/:personId/', {
            templateUrl: '/angular/pages.person',
        })
        .when('/projects/', {
            templateUrl: '/angular/pages.allProjects',
        })
        .when('/projects/:projectId/', {
            templateUrl: '/angular/pages.project',
        })
        .when('/departments', {
            templateUrl: '/angular/pages.allDepartments',
        })
        .when('/departments/people', {
            templateUrl: '/angular/pages.departmentPeople',
        })
        .when('/departments/:departmentName', {
            templateUrl: '/angular/pages.department'
        })
        .when('/profile/:profileId/:action', {
            templateUrl: '/angular/pages.profile'
        })
        .otherwise({
            templateUrl: '/angular/pages.404error'
        });

    $locationProvider.html5Mode(true);

    $compileProvider.debugInfoEnabled(window.debug || false);

    $logProvider.debugEnabled(window.debug || false);

}]);

