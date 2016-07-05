/**
 * Created by dylan on 04-Jul-16.
 */
app.service("readCustomersService", function ($http, $q) {

    var deferred = $q.defer();

    this.readAllCustomers = function () {
        return $http.get('http://localhost:8000/api/customers')
            .then(function (response) {
                // promise is fulfilled
                deferred.resolve(response.data);
                // promise is returned
                return deferred.promise;
            }, function (response) {
                // the following line rejects the promise
                deferred.reject(response);
                // promise is returned
                return deferred.promise;
            });
    };
});