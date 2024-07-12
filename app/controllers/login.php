<?php

class Login extends Controller
{
		public function index()
		{
				$returnUrl = isset($_GET['returnUrl']) ? $_GET['returnUrl'] : '/';
				$this->view('login/index', ['returnUrl' => $returnUrl]);
		}

		public function verify()
		{
				if (session_status() == PHP_SESSION_NONE) {
						session_start();
				}

				$username = $_POST['username'];
				$password = $_POST['password'];
				$returnUrl = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/';

				$userModel = $this->model('User');
				$userAuthenticated = $userModel->authenticate($username, $password);

				if ($userAuthenticated) {
						$_SESSION['user_id'] = $userAuthenticated['id'];
						$_SESSION['username'] = $userAuthenticated['username'];
						error_log('User logged in: ' . $_SESSION['user_id']); // Debugging line
						header('Location: ' . $returnUrl);  // Redirect to the provided return URL or home page
						exit();
				} else {
						$_SESSION['error'] = "Invalid credentials.";
						header('Location: /login?returnUrl=' . urlencode($returnUrl));
						exit();
				}
		}
}
?>
