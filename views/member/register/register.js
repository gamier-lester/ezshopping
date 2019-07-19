import  ApiCall  from '../../../assets/js/api.js';
import { AlertComponent, SpinnerComponent } from '../../../assets/js/components.js';

// variables
const registerButtonLoading = new SpinnerComponent('register-button');
const registerAlert = new AlertComponent('alert-container');
const memberApi = new ApiCall('api.member.php');
let requestForm = new FormData();
let alertData = {};
// functions
function register(event) {
	requestForm.set('request_process', 'register');
	requestForm.set('request_member_username', event.parentElement.username.value);
	requestForm.set('request_member_password', event.parentElement.password.value);
	registerButtonLoading.start();
	event.disabled = true;
	memberApi.post(requestForm).then( response => {
		if (response.response_message.success) {
			window.localStorage.setItem('member', response.member);	
		}
		alertData.type = response.response_message.success ? 'success' : 'danger' ;
		alertData.message = response.response_message.message;
		registerAlert.alert(alertData);
		registerButtonLoading.end();
		if (response.response_message.success) {
			window.location.assign('http://localhost:8080/e-commerce/views/member/login/index.php');
		}
	});
	event.disabled = false;
}

// functions ()
window.register = register;