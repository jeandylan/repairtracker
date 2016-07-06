/**
 * Created by dylan on 06-Jul-16.
 */
app.service("createCustomersService", function ($http, $q) {

    var deferred = $q.defer();

    this.getData = function (URI) {
        return $http.get(URI)
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
    this.postData = function (URI) {
        return $http.post(URI)
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