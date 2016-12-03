'use strict';

angular.module('itracker')
    .directive('project', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    let projectId = $routeParams.projectId;

                    $scope.project = {};

                    $scope.loaded = false;
                    $scope.todoLoaded = false;
                    $scope.historyLoaded = false;

                    basecampService.getProject(projectId)
                        .then((response) => $scope.project = response.data)
                        .catch((response) => $log.error(response))
                        .finally(()=>$scope.loaded = true);

                    basecampService.getProjectTodos(projectId)
                        .then((response) => {
                            let lists = response.data;

                            for(let list of lists){
                                let ratio = list.completed_ratio.split('/');
                                list.ratio = Math.floor((ratio[0]/ratio[1])*100);
                            }

                            $scope.project.todo = lists;
                        })
                        .catch((response) => $log.error(response))
                        .finally(() => $scope.todoLoaded = true);

                    basecampService.getProjectHistory(projectId)
                        .then((response) => {
                            let timeline = [];

                            for(let moment of response.data){
                                let obj = {
                                    type: moment.type,
                                    action: '',
                                    description: moment.description,
                                    updated_at: moment.updated_at,
                                    created_at: moment.created_at,
                                    url: moment.url,
                                    creator: moment.creator
                                };

                                switch(moment.type){
                                    case 'Upload':
                                        obj.action = 'uploaded '+moment.filename;
                                        break;
                                    case 'Todo':
                                        obj.action = (moment.completed ? 'completed' : '') + moment.content;
                                        break;
                                    default:
                                        break;
                                }

                                timeline.push(obj);
                            }

                            $scope.project.history = timeline;
                        })
                        .catch((response) => $log.error(response))
                        .finally(() => $scope.historyLoaded = true);

                    /*
                    $scope.prettyDate = function(dateTime){
                        let dateStr = dateTime.substring(0,dateTime.indexOf('T'));
                        let year = dateStr.substring(0,dateStr.indexOf('-'));
                        let rest = dateStr.substring(dateStr.indexOf('-') + 1);
                        let month = monthNames[parseInt(rest.substring(0,rest.indexOf('-'))) - 1];
                        rest = rest.substring(rest.indexOf('-') + 1);
                        return rest + ' ' + month + ' ' + year;
                    };

                    $scope.page = 1;
                    $scope.more = true;
                    $scope.limit = 10;
                    $scope.pull = true;

                    $scope.getEventSet = function(){
                        if($scope.pull && $scope.limit >= $scope.events.length){
                            var curDate = '';
                            basecampService.getProjectEvents(projectId, $scope.page).then((response) => {
                                let events = response.data;

                                console.log(events);
                                if(events.length < 50){
                                    $scope.pull = false;
                                }

                                for(let event of events){
                                    event.created_at = $scope.prettyDate(event.created_at);
                                    event.updated_at = $scope.prettyDate(event.updated_at);

                                    let date = event.created_at;
                                    if (date === curDate) {
                                        event.created_at = '';
                                    }

                                    curDate = date;
                                    $scope.events.push(event);
                                }

                                $scope.page++;
                                if($scope.limit >= $scope.events.length){
                                    $scope.more = false;
                                }
                            });
                        } else if($scope.limit >= $scope.events.length){
                            $scope.more = false;
                        }
                    };
                    //$scope.getEventSet();
                    */
                }],
                templateUrl: '/angular/proj.project'
            };
        }]);
