'use strict';

angular.module('itracker')
    .directive('person', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                controller: ['$scope', ($scope) => {
                    let personId = $routeParams.personId;

                    $scope.events = [];

                    $scope.person = {};

                    basecampService.getPerson(personId).then((response) => $scope.person = response.data);

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
                            $scope.getPersonEvents($routeParams.personId, $scope.page).success(function (data, status, headers, config) {
                                if(data.length < 50){
                                    $scope.pull = false;
                                }
                                angular.forEach(data,function (event){
                                    // alert(JSON.stringify(event));
                                    if(event.bucket.type == 'Project'){
                                        event.summary += " in <a href=\"/itracker/projects/" + event.bucket.id + "/\">" + event.bucket.name + "</a>";
                                    }
                                    event.created_at = $scope.prettyDate(event.created_at);
                                    event.updated_at = $scope.prettyDate(event.updated_at);

                                    var date = event.created_at;
                                    if (date === curDate) {
                                        event.created_at = '';
                                    }

                                    curDate = date;
                                    $scope.events.push(event);
                                });
                                $scope.page++;
                                if($scope.limit >= $scope.events.length){
                                    $scope.more = false;
                                }
                            })
                        }else if($scope.limit >= $scope.events.length){
                            $scope.more = false;
                        }
                    };
                    //$scope.getEventSet();
                }],
                templateUrl: '/angular/person'
            };
        }]);
