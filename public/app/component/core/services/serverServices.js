/**
 * Created by dylan on 06-Jul-16.
 * used by All Contollers to make Server Query,return a promise a success or failure
 * for notification used webSocket i.e socket i.o
 */
app.service("serverServices", function ($http, $q,toaster) {
    return {
        get: function(uri,params) {
          //always return to promise , where reject means some err occured,
            var deferred = $q.defer(); //always declare a new deffered when using promised else old promise will be returned
            return $http({
                method: 'GET',
                url: uri,       //add the / so that angular could handle https ,if ever https is being used
                params: params
            }) //pass the get uri,add the / so that angular could handle https ,if ever https is being used
                .then(function(response) {
                    deferred.resolve(response.data); //return sucessful data to controller /function calling it
                    return deferred.promise;

                }, function(error) {
                    toaster.pop('error',"error", error.data.error);
                    console.log(error.data);
                    deferred.reject(error); //return server error data
                    return deferred.promise;
                });
        },
        /*
        delete query sent to server,use to delete data
         */
        delete: function(uri,params) {
            //always return to promise , where reject means some err occured,
            var deferred = $q.defer(); //always declare a new deffered when using promised else old promise will be returned
            return $http({
                method: 'DELETE',
                url: uri,       //add the / so that angular could handle https ,if ever https is being used
                params: params
            })  //use the delete  uri,add the / so that angular could handle https ,if ever https is being used
                .then(function(response) {
                    deferred.resolve(response.data); //return sucessful data to controller /function calling it
                    (response.data.successful) ? toaster.pop('successful',"deleted", response.data.message ) : toaster.pop('warning',"",response.data.message);
                    return deferred.promise;

                },function(error) {
                    // something went wrong
                    toaster.pop('error',"error", error.data.error);
                    deferred.reject(error.data);//return server error data
                    return deferred.promise;
                });
        },
        /*
        put query sent to server,used to update
         */
        put:function (uri,data) {
            var deferred = $q.defer(); //always declare a new deffered when using promised else old promise will be returned
            return $http({
                method: 'PUT',
                url: uri,       //add the / so that angular could handle https ,if ever https is being used
                data: data
            })
                .then(function(response) {
                    deferred.resolve(response.data); //return sucessful data to controller /function calling it
                    (response.data.successful) ? toaster.pop('successful',"updated", response.data.message ) : toaster.pop('warning',"",response.data.message);
                    return deferred.promise;

                },function(error) {
                    // something went wrong
                    toaster.pop('error',"error", error.data.error);
                    console.log(error.data);
                    deferred.reject(error);//return server error data
                    return deferred.promise;
                })
        },

        /*
        post query sent to server,used to add new data
         */
        post:function (uri,data) {
            var deferred = $q.defer(); //always declare a new deffered when using promised else old promise will be returned
            return $http.post(uri,data) //use the delete  uri,add the / so that angular could handle https ,if ever https is being used
                .then(function(response) {
                    deferred.resolve(response.data); //return sucessful data to controller /function calling it
                    (response.data.successful) ? toaster.pop('successful',"Created", response.data.message ) : toaster.pop('warning',"!!",response.data.message);
                    return deferred.promise;

                }, function(error) {
                    // something went wrong
                    toaster.pop('error',"error", error.data.error);
                    console.log(error.data);
                    deferred.reject(error.data);//return the server error data (error Code Etc..)
                    return deferred.promise;
                });
        }

        }
});

