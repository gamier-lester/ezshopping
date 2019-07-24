// imports
import config from '../../../config/config.js';
import { CardComponent, NavigationComponent, SloganComponent } from '../../../assets/js/components.js';
import  ApiCall from '../../../assets/js/api.js';

// variables
const itemApi = new ApiCall('api.item.php');
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const slogans = new SloganComponent();
const cartItems = JSON.parse(window.localStorage.getItem('cart'));
let randomIndex = 0;
let cartIndex = 0;
let requestForm = new FormData();

// functions
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
} else if (JSON.parse(window.localStorage.getItem('cart')) !== null) {
	fetchCartLoop(cartItems);
}

fetchRandomLoop(randomIndex);


// window.functions