<?php

class Login extends Controller
{
		//displays the login page
		public function index()
		{
				// Retrieve the return URL, otherwise default to the home page
				$returnUrl = isset($_GET['returnUrl']) ? $_GET['returnUrl'] : '/';

				// Render the login view and pass the return URL to it
				$this->view('login/index', ['returnUrl' => $returnUrl]);
		}

		//handles the login verification
		public function verify()
		{
				// Start the session
				if (session_status() == PHP_SESSION_NONE) {
						session_start();
				}

				// Retrieve username and password from the POST request
				$username = $_POST['username'];
				$password = $_POST['password'];

				// Retrieve the return URL from the POST request
				$returnUrl = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/';

				// Load the User model
				$userModel = $this->model('User');

				// Authenticate the user with the credentials
				$userAuthenticated = $userModel->authenticate($username, $password);

				// If authentication is successful, set session variables and redirect to the return URL
				if ($userAuthenticated) {
						$_SESSION['user_id'] = $userAuthenticated['id'];
						$_SESSION['username'] = $userAuthenticated['username'];
						header('Location: ' . $returnUrl);  // Redirect to the return URL
						exit();
				} else {
						// If authentication fails, set an error message in the session and redirect to the login page with the return URL
						$_SESSION['error'] = "Invalid credentials.";
						header('Location: /login?returnUrl=' . urlencode($returnUrl));
						exit();
				}
		}
}
?>
