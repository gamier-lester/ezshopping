import  ApiCall  from '../../../assets/js/api.js';
import { AccordionComponent, ButtonComponent, NavigationComponent, SloganComponent, SpinnerComponent } from '../../../assets/js/components.js';
import config from '../../../config/config.js';


// variables
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const transactionApi = new ApiCall('api.transaction.php');
const orderApi = new ApiCall('api.order.php');
const accordion = new AccordionComponent();
const sloganComponent = new SloganComponent();
let requestForm = new FormData();
const buttonComponent = new ButtonComponent();
const transactionContainerLoader = new SpinnerComponent('transaction_container');
const transactionListLoader = new SpinnerComponent('transaction-link');


// functions
function eventListenerTransactions() {
	document.querySelectorAll('.transaction-button') .forEach( element => {
		element.addEventListener('click', function (e) {
			fetchTransactionDetails(e);
		});
	});
}

function fetchTransactionDetails(e) {
	transactionContainerLoader.start();
	requestForm = new FormData();
	requestForm.set('request_process', 'get_orders');
	requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
	requestForm.set('request_transaction_id', e.target.dataset.transactionId);
	orderApi.post(requestForm).then(response => {
		transactionContainerLoader.end();
		let transactionDetails = {};
		transactionDetails.id = 1;
		transactionDetails.transaction_code = e.target.dataset.transactionCode;
		transactionDetails.transaction_date = "2019-07-26 01:19:43"
		transactionDetails.transaction_amount = parseFloat(0);
		for (let i = 0; i < response.transaction_orders .length; i++) {
			transactionDetails.transaction_amount = (parseFloat(transactionDetails.transaction_amount) + parseFloat(response.transaction_orders[i].order_amount)).toFixed(2);
		}
		transactionDetails.orders = response.transaction_orders;
		document.querySelector('#transaction_container').innerHTML = accordion.createTransactionList(transactionDetails);
	});
}


// functions()
if (JSON.parse(window.localStorage.getItem('member')) === null) {
  window.location.assign(projectUrl+'/views/member/login/index.php');
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember('profile', JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}

transactionListLoader.start();
requestForm = new FormData();
requestForm.set('request_process', 'get_transaction');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
transactionApi.post(requestForm).then(response => {
	transactionListLoader.end();
	if (response.response_message.success) {
		response.user_transactions .forEach(transaction => {
			document.querySelector('#transaction-link').innerHTML += buttonComponent.createTransactions(transaction);
		});
		eventListenerTransactions();
	} else {
		document.querySelector('#transaction-link').innerHTML = sloganComponent.createEmptySetSlogan();
	}
});

// windows.functions