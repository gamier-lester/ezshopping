import config from '../../config/config.js';

function logOutUser() {
	window.localStorage.removeItem('member');
	const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
	window.location.assign(projectUrl + '/views/member/login/index.php');
}

window.logOutUser = logOutUser;