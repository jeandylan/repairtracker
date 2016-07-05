/**
 * Created by dylan on 27-Jun-16.
 */
app.controller("googleTypeAheadController",function ($scope,$http) {
    var _selected;
    var addressObtainViaQuery=[];
    var address=new Address();
    $scope.getLocation = function(val) {
        return $http.get('//maps.googleapis.com/maps/api/geocode/json', {
            params: {
                address: val,

                sensor: false
            }
        }).then(function(response){

            return response.data.results.map(function(item){
                addressObtainViaQuery.push(item);
                return item.formatted_address;
            });
        });
    };

    $scope.ngModelOptionsSelected = function(value) {
        if (arguments.length) {
            _selected = value;
            address.getAddressDetails();
            updateScope();
        } else {
            return _selected;
        }
    };

    $scope.modelOptions = {
        debounce: {
            default: 500,
            blur: 250
        },
        getterSetter: true
    };
function updateScope() {
    console.log(address.addressDetails)
    $scope.state=address.state;
    $scope.village=address.village;
    $scope.street=address.street;
    $scope.city=address.city;
    
}

    /*address
    class
     */

    function Address() {
       this.addressDetails=[];
        this.country="";
        this.countryCode=""; //short version of country
        this.street=""; //
        this.city="";
        this.village="";  //sub village of a main one
        this.state=""; //same as  state ,"administrative_area_level_1" in map api

    }
    Address.prototype.getAddressDetails=function () {
        for (var i=0; i < addressObtainViaQuery.length; i++) {
            if (addressObtainViaQuery[i].formatted_address===_selected){
                this.addressDetails=addressObtainViaQuery[i].address_components;

            }
        }
        this.classifyAddressData();
    }
    Address.prototype.classifyAddressData=function () {
    /* this function is used to classify data obtain from google map api into countries,street etc...
     *
     */
    if(this.addressDetails.length>0) {
        for (var i = 0; i < this.addressDetails.length; i++) {
            for (var j=0;j< this.addressDetails[i].types.length;j++){
                switch (this.addressDetails[i].types[j]){
                    case "country":
                        this.country=this.addressDetails[i].long_name;
                        this.countryCode=this.addressDetails[i].short_name;
                        break;
                    case "route":
                        this.street=this.addressDetails[i].long_name;
                        break;
                    case "locality":
                        this.city=this.addressDetails[i].long_name;
                        break;
                    case "sublocality":
                        this.village=this.addressDetails[i].long_name;
                        break;
                    case "administrative_area_level_1":
                        this.state=this.addressDetails[i].long_name;
                        break;
                    case "neighborhood":
                        this.street=this.street+","+this.addressDetails[i].long_name;
                    default:
                        break;
            }

            }

        }
    }
}

});