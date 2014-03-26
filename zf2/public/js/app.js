var TweetApp = angular.module("tweetApp",["ngTable"]);

TweetApp.controller("TweetCtrl",function($scope, $location, $filter, ngTableParams){
	var data = JSON.parse(tweets);

    $scope.tableParams = new ngTableParams({
        page: 1,            // show first page
        count: 5,          // count per page
        filter: {
            id: ''       // initial filter
        },
        sorting: {
            id: 'asc'     // initial sorting
        }
    }, {
        total: data.length, // length of data
        getData: function($defer, params) {
            // use build-in angular filter
            var filteredData = params.filter() ?
                    $filter('filter')(data, params.filter()) :
                    data;
            var orderedData = params.sorting() ?
                    $filter('orderBy')(filteredData, params.orderBy()) :
                    data;

            params.total(orderedData.length); // set total for recalc pagination
            $defer.resolve(orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count()));
    
        }
    });

});

TweetApp.controller("NavCtrl",function($scope){
	
	if(document.URL.endsWith("feeds")){
		$scope.button = "Go Back";
		$scope.getFeeds = function(){
	    	window.location.href = "/";
	    };
	}else{
		$scope.button = "Get Feeds";
			$scope.getFeeds = function(){
	    	window.location.href = "/feeds";
	    };
	}
    
});


String.prototype.endsWith = function(suffix) {
    return this.indexOf(suffix, this.length - suffix.length) !== -1;
};