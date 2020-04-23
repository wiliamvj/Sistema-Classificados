
/**
 * Created by Vinícius on 30/09/2016.
 */

var AddressApp = angular.module('AddressApp', []);

AddressApp.controller('AddressCtrl', ['$scope','$http', function($scope,$http){

    $scope.getAdressByCepURL = base_url+'/address/getByCep/';

    $scope.postalCode = '';
    $scope.states = '';
    $scope.cities '';
    $scope.neighborhoods '';
    $scope.regions '';

    $scope.city_id = '';
    $scope.state_id = '';
    $scope.neighborhood_id = '';
    $scope.region_id = '';
    $scope.addressText = '';


    $scope.loadStateList = function(sateListJson){
        $scope.states = sateListJson;
    };

    $scope.loadCityList = function(cityListJson){
        $scope.cities = cityListJson;
    };

    $scope.loadAddress = function(jsonAddr){
        $scope.cities = jsonAddr.cities;
        $scope.states = jsonAddr.states;
        $scope.neighborhoods = jsonAddr.neighborhoods;
        $scope.regions = jsonAddr.regions;

        $scope.city_id = 0;
        $scope.state_id = 0;

        $scope.city_id = jsonAddr.city_id;
        $scope.state_id = jsonAddr.state_id;
        $scope.neighborhood_id = jsonAddr.neighborhood_id;
        $scope.region_id = jsonAddr.region_id;

        $scope.addressText = jsonAddr.addressText;

        console.log($scope);

    };

    $scope.getAddressFromCode = function(){

        return $http({
            method: 'GET',
            url: $scope.getAdressByCepURL + $scope.postalCode

        }).success(function(data) {
            $scope.loadAddress(data);
        });
    };

}]);



