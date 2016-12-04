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
            projectCounts: {},
            activeTodoLists: [],
            completedTodoLists: [],
            activeTodoListsCompletedCount: 0,
            activeTodoListsRemainingCount: 0,
            completedTodoListsCompletedCount: 0,
            completedTodoListsRemainingCount: 0,
            emails: {},
            user: null
        };

        /**
         * Get project counts
         *
         * @param projectId
         * @returns {{
         *     activeTodoListsCompletedCount,
         *     activeTodoListsRemainingCount,
         *     completedTodoListsCompletedCount,
         *     completedTodoListsRemainingCount,
         *     allTodoListsCompletedCount,
         *     allTodoListsCompletedCount,
         *     percentComplete
         * }}
         */
        let getProjectCounts = (projectId) => {
            let result = {
                activeTodoListsCompletedCount: 0,
                activeTodoListsRemainingCount: 0,
                completedTodoListsCompletedCount: 0,
                completedTodoListsRemainingCount: 0,
                allTodoListsCompletedCount: 0,
                percentComplete: 0
            };

            if(!(projectId != null)){
                return result;
            }

            // Return cached result if there is one
            if(this.main.projectCounts[projectId] != null){
                return this.main.projectCounts[projectId];
            }

            // Loop over active todo lists and count todo's
            for(let list of this.main.activeTodoLists)
                if(list.bucket.id === projectId) {
                    result.activeTodoListsCompletedCount += list.completed_count;
                    result.activeTodoListsRemainingCount += list.remaining_count;
                }


            for(let list of this.main.completedTodoLists)
                if(list.bucket.id === projectId) {
                    result.completedTodoListsCompletedCount += list.completed_count;
                    result.completedTodoListsRemainingCount += list.remaining_count;
                }

            // Only store result in cache if all data was fetched correctly so the numbers get updated
            // when todo lists are still being fetched
            if(this.main.projects.length && this.main.activeTodoLists.length && this.main.completedTodoLists.length){

                // Calculate some extra statistics
                result.allTodoListsCompletedCount = result.activeTodoListsCompletedCount + result.completedTodoListsCompletedCount;
                result.allTodoListsRemainingCount = result.activeTodoListsRemainingCount + result.completedTodoListsRemainingCount;
                result.percentComplete = result.allTodoListsCompletedCount * (100 / (result.allTodoListsCompletedCount + result.allTodoListsRemainingCount));

                // Store in cache
                this.main.projectCounts[projectId] = result;
            }

            return result;
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
            getProjectCounts: getProjectCounts,
            bootstrap: bootstrap,
            main: this.main,
            groups: this.groups,
            projects: this.projects,
            people: this.people,
            user: this.main.user
        }
    }]);