'use strict';

angular.module('itracker',[
    //'ui.router',
    'ui.bootstrap',
    'ngRoute',
]).config(['$routeProvider','$locationProvider', '$logProvider', '$compileProvider',
    function ($routeProvider, $locationProvider, $logProvider, $compileProvider) {

    let _base = document
        .getElementsByTagName('base')[0]
        .getAttribute('href')
        .replace(new RegExp(`^https?:\/\/${location.host}`),'');

    $routeProvider
        .when('/', {
            templateUrl: _base+'/angular/pages.home',
        })
        .when('/people', {
            templateUrl: _base+'/angular/pages.allPeople',
        })
        .when('/people/:personId/', {
            templateUrl: _base+'/angular/pages.person',
        })
        .when('/projects/', {
            templateUrl: _base+'/angular/pages.allProjects',
        })
        .when('/projects/:projectId/', {
            templateUrl: _base+'/angular/pages.project',
        })
        .when('/departments', {
            templateUrl: _base+'/angular/pages.allDepartments',
        })
        .when('/departments/people', {
            templateUrl: _base+'/angular/pages.departmentPeople',
        })
        .when('/departments/:departmentName', {
            templateUrl: _base+'/angular/pages.department'
        })
        .when('/profile/:profileId/:action', {
            templateUrl: _base+'/angular/pages.profile'
        })
        .otherwise({
            templateUrl: _base+'/angular/pages.404error'
        });

    $locationProvider.html5Mode(true);

    $compileProvider.debugInfoEnabled(window.debug || false);

    $logProvider.debugEnabled(window.debug || false);

}]);

