'use strict';

angular.module('itracker')
    .factory('dataService', ['$q', '$log', 'retrievalService', function($q, $log, retrievalService) {
        this.people = [];
        this.projects = [];
        this.groups = [];

        this.main = {
            people: [],
            projects: [],
            groups: [],
            emails: {},
            user: null
        };


        let bootstrap = () => {
            retrievalService.getProjects().then((response) => {
                let projects = response.data;
                if (Array.isArray(projects)) {
                    $log.debug('Projects:', projects);
                    this.projects = projects;
                    this.main.projects = projects;
                }
            });

            retrievalService.getPeople().then((response) => {
                let people = response.data;

                if (Array.isArray(people)) {
                    $log.debug('People: ', people);
                    this.people = people;

                    for(let person of people){
                        this.main.emails[person.email] = person.id;
                        this.main.people.push( person );
                    }
                }
            });

            retrievalService.getGroups().then((response) => {
                let groups = response.data;

                if (Array.isArray(groups)) {
                    $log.debug('Groups:', groups);

                    this.groups = groups;

                    for(let group of groups){
                        this.main.groups.push( group );
                    }
                }
            });

            retrievalService.getCurrentUser().then((response) => {
                this.main.user = response.data;
            });
        };

        return {
            bootstrap: bootstrap,
            main: this.main,
            groups: this.groups,
            projects: this.projects,
            people: this.people,
            user: this.main.user
        }
    }]);