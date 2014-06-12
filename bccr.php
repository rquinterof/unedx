<!doctype html>
<html lang="en" ng-app id="ng-app">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>ExchangeApp</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<script src="http://cdnjs.cloudflare.com/ajax/libs/handlebars.js/2.0.0-alpha.4/handlebars.amd.min.js" type="text/javascript"></script>
	<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.17/angular.min.js"></script>
    <script>
        function exchange($scope, $http) {
            $http({
                method: 'POST',
                url: 'exchange.php'
            }).success(function(data) {
                $scope.posts = data; // response data 
                console.log(data);
            });
        }
    </script>
    <style>
        body {
            background-color: #333;
            
        }
    
    		
        
    </style>
</head>

<body>
    <div id="ng-app" ng-app ng-controller="exchange" class="container">

        <div ng-repeat="post in posts">
            <h3>
                <a href='{{post.url}}'>{{post.title}}</a>
            </h3>
            <div class='time'>{{post.time}} - {{post.author}}</div>
            <p>{{post.description}}</p>
            <img ng-src="{{post.banner}}" />
        </div>
        
    </div>
</body>

</html>