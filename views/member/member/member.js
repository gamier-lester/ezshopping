if (window.merchantId === undefined) {
	var merchantId = null;
} else if (window.merchantId !== undefined) {
	var merchantId = window.merchantId;
	window.sessionStorage.setItem('last_merchant_view', merchantId);
}
import  ApiCall  from '../../../assets/js/api.js';
import { AlertComponent, CardComponent, NavigationComponent } from '../../../assets/js/components.js';
import config from '../../../config/config.js';

const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const memberApi = new ApiCall('api.member.php');
const itemApi = new ApiCall('api.item.php');
const pageAlert = new AlertComponent('page-alert');
let alertData = {};
let requestForm = new FormData();

function createItemCard(dataObject) {
	let resultText = '';
	let entryData = {};
	for (let i = 0; i < dataObject .length; i++) {
		entryData.cardId = dataObject[i].item_id;
		entryData.cardTitle = dataObject[i].item_name;
		entryData.cardImage = (dataObject[i].media_link) ? dataObject[i].media_link : config.defaultImage;
		let adCart = new CardComponent(entryData);
		resultText += adCart.createAd();
	}
	return resultText;
}

if (JSON.parse(window.localStorage.getItem('member')) === null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setDefault();
  pageNav.startListener();
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember(false, JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}
if (merchantId === null) {
	if (window.sessionStorage.getItem('last_merchant_view') === null) {
		window.location.assign(projectUrl+'/views/shopping/home/index.php');
	} else if (window.sessionStorage.getItem('last_merchant_view') != null) {
		merchantId = window.sessionStorage.getItem('last_merchant_view');
	}
}


requestForm = new FormData();
requestForm.set('request_process', 'fetch_public_data');
requestForm.set('request_member_id', merchantId);
memberApi.post(requestForm).then(response => {
	if (response.response_message.success) {
		let userData = {};
		userData.cardImage = response.user_details.media_link === null ? config.defaultImage : response.user_details.media_link;
		userData.cardTitle = response.user_details.user_email;
		userData.cardText = response.user_details.date_created;
		userData.cardSubtitle = 'Merchant Name: ' + response.user_details.user_lastname + ', ' + response.user_details.user_firstname;
		let cardComponent = new CardComponent(userData);
		document.querySelector('#user-container').innerHTML = cardComponent.createMerchant();
		requestForm = new FormData();
		requestForm.set('request_process', 'fetch_user_items');
		requestForm.set('request_member_id', 11);
		itemApi.post(requestForm).then(response => {
			document.querySelector('#item-container').innerHTML =	createItemCard(response.items);
		});
	} else {
		alertData.type = 'danger';
		alertData.message = response.response_message.message;
		pageAlert.alert(alertData);
	}
});