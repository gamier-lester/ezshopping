// imports
import config from '../../../config/config.js';
import { AlertComponent, CardComponent, NavigationComponent, SloganComponent, SpinnerComponent } from '../../../assets/js/components.js';
import  ApiCall from '../../../assets/js/api.js';

// variables
const pageAlert = new AlertComponent('cart-alert');
const placeOrderLoading = new SpinnerComponent('process-orders-button');
const cartLoading = new SpinnerComponent('cart-container');
const cartRelatedLoading = new SpinnerComponent('cart-related');
const orderApi = new ApiCall('api.order.php');
const itemApi = new ApiCall('api.item.php');
const transactionApi = new ApiCall('api.transaction.php');
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const slogans = new SloganComponent();
const cartItems = JSON.parse(window.localStorage.getItem('cart'));
let randomIndex = 0;
let cartIndex = 0;
let transactionId = 0;
let orderIndex = 0;
let uploadStatus = true;
let requestForm = new FormData();
let alertData = {};

// functions
const addOrderLoop = function(arr) {
	addOrder(arr[orderIndex], function() {
		orderIndex++;

		if (orderIndex < arr .length) {
			addOrderLoop(arr);
		} else {
			window.localStorage.removeItem('cart');
			cartLoading.end();
			cartRelatedLoading.end();
			placeOrderLoading.end();
			document.querySelector('#process-orders-button').style.display = 'none';
			document.querySelector('#cart-container').innerHTML = slogans.createEmptySetSlogan();
		}

	});
}

function addOrder(arr, callback) {
	requestForm.set('request_process', 'create_order');
	requestForm.set('request_transaction_id', transactionId);
	requestForm.set('request_item_id', arr.id);
	requestForm.set('request_item_price', arr.price);
	requestForm.set('request_item_quantity', arr.order_quantity);
	requestForm.set('request_merchant_id', arr.merchant_id);
	requestForm.set('request_order_amount', (arr.price * arr.order_quantity) .toFixed(2));
	orderApi.post(requestForm).then(response => {
		if (response.response_message.success) {
			window.sessionStorage.setItem('last_order_placed', orderIndex);
			alertData.type = 'success';
			alertData.message = response.response_message.message;
			pageAlert.alert(alertData);
		} else {
			uploadStatus = false;
			console.log('something failed');
		}
	});
	callback();
}

function appendItemLink(event) {
  let itemLink = window.open(`${projectUrl}/views/shopping/item/index.php`, '_blank');
  itemLink.itemId = event.target.dataset.itemId;
}

function setEventListener(targetFunction) {
	if (targetFunction === 'updateCart') {
		document.querySelectorAll('.update-button') .forEach(e => {
			e.addEventListener('click', trigger => {
				updateCart(trigger);
			});
		});
		document.querySelectorAll('button.close') .forEach(e => {
			e.addEventListener('click', trigger => {
				removeItem(trigger);
			});
		});
	} else if (targetFunction === 'view items') {
		document.querySelectorAll('#cart-related .card-link') .forEach(e => {
			e.addEventListener('click', trigger => {
				appendItemLink(trigger);
			});
		})
	}
}

const fetchCartLoop = function(arr) {
	fetchItem(arr[cartIndex], function() {
		cartIndex++;

		if (cartIndex < cartItems .length) {
			fetchCartLoop(arr);
		} else {
			setEventListener('updateCart');
		}
	});
}

function fetchItem(item, callback) {
	requestForm = new FormData();
	requestForm.set('request_process', 'fetch_one');
	requestForm.set('request_item_id', item.id);
	itemApi.post(requestForm).then( response => {
		cartLoading.end();
		let cardData = {};
		let cardParams = {};
		cardData.cardId = response.item_detail.id;
		cardData.cardImage = response.item_detail.media_link;
		cardData.cardTitle = response.item_detail.name;
		cardParams.item_price = response.item_detail.price;
		cardParams.item_quantity = item.order_quantity;
		cardParams.order_price = (item.order_quantity * response.item_detail.price).toFixed(2);
		let newCard = new CardComponent(cardData);
		document.querySelector('#cart-container').innerHTML += newCard.createCartItem(cardParams);
		callback();
	});
}

const fetchRandomLoop = function(index) {
	fetchRandomItem(index, function() {
		randomIndex++;

		if (randomIndex < 3) {
			fetchRandomLoop(index);
		}
	});
}

function fetchRandomItem(index, callback) {
	requestForm = new FormData();
	requestForm.set('request_process', 'fetch_one');
	requestForm.set('request_item_id', randomIndex+1);
	itemApi.post(requestForm).then( response => {
		cartRelatedLoading.end();
		let cardData = {};
		cardData.cardId = response.item_detail.id;
		cardData.cardTitle = response.item_detail.name;
		cardData.cardImage = (response.item_detail.media_link) ? response.item_detail.media_link : config.defaultImage;
		let adCart = new CardComponent(cardData);
		document.querySelector('#cart-related').innerHTML += adCart.createAd();
		callback();
	});
}

function goBack() {
	window.location.assign(projectUrl+'/views/shopping/home/index.php');
}

function placeOrders(e) {
	e.disabled = true;
	placeOrderLoading.start();
	cartLoading.start();
	cartRelatedLoading.start();
	let orders = JSON.parse(window.localStorage.getItem('cart'));
	requestForm = new FormData();
	requestForm.set('request_process', 'create_transaction');
	requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
	transactionApi.post(requestForm).then( reqResponse => {
		console.log(reqResponse);
		if (reqResponse.response_message.success) {
			transactionId = reqResponse.transaction_details.transaction_id;
			addOrderLoop(orders);
		}
	});
}

function removeItem(trigger) {
	let newCart = JSON.parse(window.localStorage.getItem('cart'));
	for (let i = 0; i < cartItems .length; i++) {
		if (newCart[i].id === trigger.target.dataset.targetId) {
			newCart.splice(i, 1);
			break;
		}
	}
	window.localStorage.setItem('cart', JSON.stringify(newCart));
	document.querySelector(`#item-${trigger.target.dataset.targetId}`).remove();
}

function updateCart(trigger) {
	let cartForm = document.querySelector(`#item-${trigger.target.dataset.itemId}-form`);
	for (let i = 0; i < cartItems .length; i++) {
		if (cartItems[i].id === trigger.target.dataset.itemId) {
			cartItems[i].order_quantity = cartForm.order_quantity.value;
			break;
		}
	}
	window.localStorage.setItem('cart', JSON.stringify(cartItems));
	document.querySelector(`#item-${trigger.target.dataset.itemId}-price`).innerHTML = cartForm.order_quantity.value;
	let totalDisplay = document.querySelector(`#item-${trigger.target.dataset.itemId}-total`);
	totalDisplay.innerHTML = `Total Amount: ${(totalDisplay.dataset.targetPrice * cartForm.order_quantity.value) .toFixed(2)}`;
}
// functions ()
if (JSON.parse(window.localStorage.getItem('member')) === null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setDefault();
  pageNav.startListener();
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember('cart', JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}

document.querySelector('#go-back-button').addEventListener('click', function() {
	goBack();
});

if (JSON.parse(window.localStorage.getItem('cart')) === null  || JSON.parse(window.localStorage.getItem('cart')) .length === 0) {
	document.querySelector('#cart-container').innerHTML = slogans.createEmptySetSlogan();
	document.querySelector('#process-orders-button').style.display = 'none';
} else if (JSON.parse(window.localStorage.getItem('cart')) !== null) {
	cartLoading.start();
	fetchCartLoop(cartItems);
}

cartRelatedLoading.start();
fetchRandomLoop(randomIndex);


// window.functions
window.placeOrders = placeOrders;