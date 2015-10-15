
@extends('layouts.master')

@section('content')
<div >
    <h1>Simple interest rate calculator</h1>


    <p>This calculator was programmed using Laravel 5.1, Bootstrap3, and jQuery.</p>

	<p>To run the example, just unzip the archive somewhere convenient, open a command prompt in the project root directory and then type "php artisan serve". This will make the web site accessible at http://localhost:8000. Otherwise you'll need set up a web server to make the "public" folder accessible from some URL.</p>

	<p>Because of the client-side javascript validation, you probably won't notice the server-side validation, but if you disable javascript and submit the form, you'll see the server-side validation in action, which uses Request validation to prevent the form's post request from ever reaching the "calculate" method in the index controller. If the submitted data passes the validation rules defined in /app/Http/Requests/CalculateRequest.php, only then will the controller method be called that handles the actual calculations, and the request is injected using type-hinting in the "calculate" method of the index controller located at /app/Http/Controllers/IndexController.php</p>

	<p>
		You can run the PHPSpec tests (similar to phpunit) from a command prompt in the project root dir by typing "vendor\bin\phpspec run" on windows or "vendor/bin/phpspec" on linux or macos. The tests are not complete, they are merely examples of some possible tests that can be run.
	</p>

	<p>Normally, one would not zip up all these files and distribute them together -- most of the framework and 3rd party files would not be included in a composer-based app. Normally you'd probably only need to download the composer.json, and other config files located in the project root dir. Then you would simply run "composer install" on the commandline to set up all the composer dependencies, then you'd type "npm install" to install the node modules, then you'd type "bower update" to download any js/css libs managed by bower, and finally you'd type the "gulp" command to combine/minify/publsh all the assets to their proper locations in the "public" folder. But you should theoretically not need to do any of that to view this project.</p>

	<p>Here is a list of the main files of interest for this project:</p>

	<blockquote>

		<h3>PHPSpec test cases</h3>
		<code>
			/spec<br>
		</code>

		<h3>Calculator Classes</h3>
		<code>
			/app/Calculator.php<br>
			/app/LoanCalculatorInterface.php<br>
			/app/LoanCalculator.php<br>
		</code>

		<h3>Server Side Validation</h3>
		<code>
			/app/Http/Requests/CalculateRequest.php<br>
		</code>

		<h3>Controllers</h3>
		<code>
			/app/Http/Controllers/IndexController.php<br>
		</code>

		<h3>Views (blade templates)</h3>
		<code>
			/resources/views/layouts/master.blade.php<br>
			/resources/views/index.blade.php<br>
			/resources/views/about.blade.php<br>
		</code>

		<h3>SASS (.scss) files</h3>
		<code>
			/resources/assets/sass/app.scss<br>
			/resources/assets/sass/flaticon.scss<br>
		</code>

		<h3>JS files</h3>
		<code>
			/resources/assets/js/app.js<br>
		</code>

		<h3>compiled and versioned js/css files</h3>
		<code>
			/public/build/css<br>
			/public/build/js<br>
		</code>

		<h3>Web document root directory</h3>
		<code>
			/public<br>
		</code>

	</blockquote>

	<p>The files in the  /resources/assets folders such as js and css files are combined by gulp and published to the /public/build directory by the running "gulp" command with no arguments from the project root dir. To see how this is configured, you can open the 'gulpfile.js'. You can easily manage the versions of jQuery, Bootstrap and most other 3rd party js libs by tweaking the 'bower.json' file in the project root and typing "bower update" on the commandline.</p>


</div>

@stop