import  ApiCall  from '../../../assets/js/api.js';
import { AlertComponent, SpinnerComponent } from '../../../assets/js/components.js';

// variables
const loginButtonLoading = new SpinnerComponent('login-button');
const loginAlert = new AlertComponent('alert-container');
const memberApi = new ApiCall('api.member.php');
let requestForm = new FormData();
let alertData = {};
// functions
function login(event) {
	requestForm.set('request_process', 'login');
	requestForm.set('request_member_username', event.parentElement.username.value);
	requestForm.set('request_member_password', event.parentElement.password.value);
	loginButtonLoading.start();
	event.disabled = true;
	memberApi.post(requestForm).then( response => {
		if (response.response_message.success) {
			window.localStorage.setItem('member', JSON.stringify(response.member));	
		}
		alertData.type = response.response_message.success ? 'success' : 'danger' ;
		alertData.message = response.response_message.message;
		loginAlert.alert(alertData);
		loginButtonLoading.end();
		if (response.response_message.success) {
			window.location.assign('http://localhost:8080/e-commerce/views/shopping/home/index.php');
		}
	});
	event.disabled = false;
}

// functions ()
window.login = login;