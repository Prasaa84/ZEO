<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="container">
	<h1>Welcome to myHomePage!</h1>
	<p>Now, when the page does exist, it is loaded, including the header and footer, and displayed to the user. If the page doesn't exist, a "404 Page not found" error is shown.<br />

The first line in this method checks whether the page actually exists. PHP's native file_exists() function is used to check whether the file is where it's expected to be. show_404() is a built-in CodeIgniter function that renders the default error page.

In the header template, the $title variable was used to customize the page title. The value of title is defined in this method, but instead of assigning the value to a variable, it is assigned to the title element in the $data array.

The last thing that has to be done is loading the views in the order they should be displayed. The second parameter in the view() method is used to pass values to the view. Each value in the $data array is assigned to a variable with the name of its key. So the value of $data['title'] in the controller is equivalent to $title in the view.

	</p>

</div>

</body>
</html>