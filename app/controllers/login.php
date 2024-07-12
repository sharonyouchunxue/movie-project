<?php

class Login extends Controller
{
		public function index()
		{
				$returnUrl = isset($_GET['returnUrl']) ? $_GET['returnUrl'] : '/';
				$this->view('login/index', ['returnUrl' => $returnUrl]);
		}

		public function verify(){
				// session_start(); //declared in init.php

				$username = $_POST['username'];
				$password = $_POST['password'];
				$returnUrl = isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '/';

				$userModel = $this->model('User');
				$userAuthenticated = $userModel->authenticate($username, $password);

				if ($userAuthenticated) {
						$_SESSION['user_id'] = $userAuthenticated['id']; // Set user_id from authenticated user data
						error_log('Debugging message: User logged in with ID ' . $_SESSION['user_id']);
						error_log('Debugging message: Session ID ' . session_id());
						header('Location: ' . $returnUrl);
						exit();
				} else {
						$_SESSION['error'] = "Invalid credentials.";
						error_log('Debugging message: Authentication failed for username ' . $username);
						header('Location: /login?returnUrl=' . urlencode($returnUrl));
						exit();
				}
		}
}
