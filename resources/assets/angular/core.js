'use strict';

angular.module('itracker',[
    //'ui.router',
    'ngRoute',
]).config(['$routeProvider','$locationProvider', function ($routeProvider, $locationProvider) {
    $routeProvider
        .when('/', {
            templateUrl: '/angular/legacy.home',
            controller: 'HomeController'
        })
        .when('/people/by-dept/', {
            templateUrl: '/angular/legacy.people-by-dept',
            controller: 'PeopleByDeptController'
        })
        .when('/people/by-name/', {
            templateUrl: '/angular/legacy.people-by-name',
            controller: 'PeopleByNameController'
        })
        .when('/people/:personId/', {
            templateUrl: '/angular/legacy.person',
            controller: 'PersonController'
        })
        .when('/projects/by-name/', {
            templateUrl: '/angular/legacy.projects-by-name',
            controller: 'ProjectsByNameController'
        })
        .when('/projects/by-dept/', {
            templateUrl: '/angular/legacy.projects-by-dept',
            controller: 'ProjectsByDeptController'
        })
        .when('/projects-old/:projectId/', {
            templateUrl: '/angular/legacy.project-orig',
            controller: 'ProjectController'
        })
        .when('/projects/:projectId/', {
            templateUrl: '/angular/legacy.project',
            controller: 'ProjectController'
        })
        .when('/projects/:projectId/todolists/:todoListId', {
            templateUrl: '/angular/legacy.todo-list',
            controller: 'TodoListController'
        })
        .when('/departments/:departmentName', {
            templateUrl: '/angular/legacy.department',
            controller: 'DepartmentController'
        })
        .otherwise({
            templateUrl: '/angular/legacy.404-error',
            controller: 'ErrorController'
        });

}]).value('basecamp.config', {
    debug: false // Set to false to disable logging to console
});

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

function replace_All(str, find, replace){
    while(str.indexOf(find) != -1){
        str = str.replace(find, replace);
    }
    return str;
}
