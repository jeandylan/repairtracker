/**
 * Created by dylan on 28-Jul-16.
 */
app.controller("createStockCtrl",function ($scope,serverServices,toaster) {



    $scope.createStock=function () {  //it is very import that each data name matches the columns name it is to be inserted in Db, as on server side the code will not work
        var stockData={
            product_name:$scope.stock.product_name,
            selling_price:$scope.stock.selling_price,
            reorder_level:$scope.stock.reorder_level,
            barcode:$scope.stock.barcode

        };

        console.log(stockData);

        serverServices.post('api/stock',stockData) //using service (customer/service/clientService ) that will query Laravel for .json output
            .then(
                function (result) {
                    console.log(result);
                    toaster.pop("success","DONE",result.message);
                },
                function (error) {
                    // handle errors here
                    toaster.pop("error","SERVER ERROR","ooh nothing was saved error ");
                }
            );

    }

});