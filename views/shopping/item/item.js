if (window.itemId === undefined) {
	var itemId = null;
} else if (window.itemId !== undefined) {
	var itemId = window.itemId;
	window.sessionStorage.setItem('last_item_view', itemId);
}
// import
import ApiCall from '../../../assets/js/api.js';
import { AlertComponent, CardComponent, FormComponent, NavigationComponent, SloganComponent, SpinnerComponent } from '../../../assets/js/components.js';
import config from '../../../config/config.js';

// variables
const shoppingApi = new ApiCall('api.shopping.php');
const itemApi = new ApiCall('api.item.php');
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const itemProfileLoader = new SpinnerComponent('item-profile');
const itemDetailLoader = new SpinnerComponent('item-details');
const itemRelatedSearchLoader = new SpinnerComponent('item-related-search');
const pageAlert = new AlertComponent('page-alert');
let alertData = {};
let requestForm = new FormData();

// functions
function appendItemLink(event) {
  let memberLink = window.open(`${projectUrl}/views/member/member/index.php`, '_blank');
  memberLink.merchantId = event.target.dataset.userId;
}

function addToCart(triggerElement) {
	let formData = document.querySelector(triggerElement.target.dataset.target);
	if (formData.order_quantity.value === '' || parseInt(formData.order_quantity.value) < 0) {
		alertData.type = 'danger';
		alertData.message = 'Order quantity must be at least 1';
		pageAlert.alert(alertData);
		return false;
	}
	requestForm = new FormData();
	requestForm.set('request_process', 'fetch_one');
	requestForm.set('request_item_id', itemId);
	itemApi.post(requestForm).then( response => {
		let orderData = response.item_detail;
		orderData.order_quantity = parseInt(formData.order_quantity.value);
		if (JSON.parse(window.localStorage.getItem('cart')) === null) {
			let cart = new Array();
			cart.push(orderData);
			window.localStorage.setItem('cart', JSON.stringify(cart));
		} else if (JSON.parse(window.localStorage.getItem('cart')) !== null) {
			let cart = JSON.parse(window.localStorage.getItem('cart'));
			let itemCheck = false;
			cart.forEach(item => {
				if (item.id === orderData.id) {
					item.order_quantity = parseInt(item.order_quantity) + parseInt(orderData.order_quantity);
					itemCheck = true;
				}
			});
			if (itemCheck === false) {
				cart.push(orderData);
			}
			window.localStorage.setItem('cart', JSON.stringify(cart));
		}
		alertData.type = 'success';
		alertData.message = 'Successfully added to cart';
		pageAlert.alert(alertData);
	});
}

function createMerchantCard(dataObject) {
	let userData = {};
	userData.cardId = dataObject.user_id;
	userData.cardImage = (dataObject.media_link) ? dataObject.media_link : config.defaultImage;
	userData.cardTitle = dataObject.user_lastname + ',' + ' ' + dataObject.user_firstname;
	userData.cardSubtitle = dataObject.user_email;
	userData.cardText = dataObject.user_date_joined;
	userData.cardLink = 'testlink';
	let userCard = new CardComponent(userData);
	return userCard.createUser();
}

function createRelatedCard(dataObject) {
	let resultText = '';
	let entryData = {};
	for (let i = 0; i < dataObject .length; i++) {
		entryData.cardId = dataObject[i].id;
		entryData.cardTitle = dataObject[i].name;
		entryData.cardImage = (dataObject[i].media_link) ? dataObject[i].media_link : config.defaultImage;
		let adCart = new CardComponent(entryData);
		resultText += adCart.createAd();
	}
	return resultText;
}

function goBack() {
	window.location.assign(projectUrl+'/views/shopping/home/index.php');
}

function setProcessEvents() {
	document.querySelector('#go-back-button').addEventListener('click', e => {
		goBack();
	});
	document.querySelector('.cart-button').addEventListener('click', e => {
		addToCart(e);
	});
	document.querySelector('.visit-merchant').addEventListener('click', e => {
		appendItemLink(e);
	});
	document.querySelectorAll('.card-link') .forEach(e => {
		e.addEventListener('click', event => {
			visitItem(event);
		});
	});
}

function visitItem(elementTrigger) {
  window.sessionStorage.setItem('last_item_view', elementTrigger.target.dataset.itemId);
	let itemLink = window.location.assign(`${projectUrl}/views/shopping/item/index.php`);
  // itemLink.itemId = elementTrigger.target.dataset.itemId;
}

// functions()
if (itemId === null) {
	if (window.sessionStorage.getItem('last_item_view') === null) {
		window.location.assign(projectUrl+'/views/shopping/home/index.php');
	} else if (window.sessionStorage.getItem('last_item_view') != null) {
		itemId = window.sessionStorage.getItem('last_item_view');
	}
}

if (JSON.parse(window.localStorage.getItem('member')) === null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setDefault();
  pageNav.startListener();
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember(false, JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}

itemProfileLoader.start();
itemDetailLoader.start();
itemRelatedSearchLoader.start();
requestForm = new FormData();
requestForm.set('request_process', 'fetch_one');
requestForm.set('request_item_id', itemId);
shoppingApi.post(requestForm).then( response => {
	itemProfileLoader.end();
	itemDetailLoader.end();
	itemRelatedSearchLoader.end();
	let profileForm = new FormComponent();
	let detailSlogan = new SloganComponent();
	document.querySelector('#item-profile').innerHTML = profileForm.generateCartForm(response.item_data);
	document.querySelector('#item-details').innerHTML = detailSlogan.createItemSlogan(response.item_data);
	document.querySelector('#item-details').innerHTML += createMerchantCard(response.item_merchant);
	document.querySelector('#item-related-search').innerHTML = createRelatedCard(response.item_related_search);
	setProcessEvents();
});
// window.functions