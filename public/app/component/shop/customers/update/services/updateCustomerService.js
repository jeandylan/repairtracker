/**
 * Created by dylan on 04-Jul-16.
 */
app.service("updateCustomerService", function ($http, $q) {


/*
first we need to get data from server for the customer that must be updated
 */
    this.readCustomerById=function (id) {
        var deferred = $q.defer();
        return $http.get('http://localhost:8000/api/customer/'+id).then(function (response) {
                // promise is fulfilled
                deferred.resolve(response.data);
                return deferred.promise;
            }, function (response) {
                // the following line rejects the promise
                deferred.reject(response);
                // promise is returned
                return deferred.promise;
            });

    }


});



