class AccordionComponent {
	constructor() {

	}

	generate(dataObject) {
		return `
			<div class="card">
		    <div class="card-header">
		      <h2 class="mb-0">
		        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#message_${dataObject.message_id}" data-message-id="${dataObject.message_id}">
		        	text
		        </button>
		      </h2>
		    </div>
		    <div id="message_${dataObject.message_id}" class="collapse" data-parent="#messageAccordion">
		      <div class="card-body">
		        <p class="text-right">Message <i>text</i></p>
		        <p class="lead">Message...</p>
		        <p class="lead">&emsp;&emsp; Message body</p>
		      </div>
		    </div>
		  </div>
		`;
	}

	createTransactionList(transactionDetails) {
		let textElement = `
			<div class="accordion" id="transaction-${transactionDetails.id}-accordion">
			  <div class="card">
			    <div class="card-header">
			      <h2 class="mb-0">
			        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#transaction-${transactionDetails.id}-collapse">
			          ${transactionDetails.transaction_code}&emsp;<small class="text-muted">${transactionDetails.transaction_date}</small>
			        </button>
			      </h2>
			    </div>

			    <div id="transaction-${transactionDetails.id}-collapse" class="collapse show" data-parent="#transaction-${transactionDetails.id}-accordion">
			      <div class="card-body row justify-content-center">
			      	<div class="col-lg-12">
			      		Summary: <br>
			      		&emsp;&emsp; Transaction Amount: ${transactionDetails.transaction_amount}
			      	</div>`;
		transactionDetails.orders .forEach( currentIndex => {
			textElement += `
      	<div class="col-lg-5 mb-2">
	      	<div class="card">
					  <div class="row no-gutters">
					    <div class="col-md-4">
					      <img src="${currentIndex.media_link}" class="card-img p-1" alt="...">
					    </div>
					    <div class="col-md-8">
					      <div class="card-body">
					        <h5 class="card-title">${currentIndex.item_name}</h5>
					        <p class="card-text"><small class="text-muted">${currentIndex.merchant_name}</small></p>
					        <p class="card-text">P${currentIndex.item_price} x #${currentIndex.order_quantity} = ${currentIndex.order_amount}</p>
					      </div>
					    </div>
					  </div>
					</div>
				</div>`;
		});
		textElement += `
			      </div>
			    </div>
			  </div>
			</div>
		`;
		return textElement;
	}
}

class AlertComponent {
	constructor(targetElement) {
		this.targetElement = targetElement;
	}

	alert(alertData) {
		document.querySelector(`#${this.targetElement}`).innerHTML = `
			<div class="alert alert-${alertData.type} alert-dismissible fade show col-lg-12" role="alert">
			  ${alertData.message}
			  <button type="button" class="close" data-dismiss="alert">
			  	<span>&times;</span>
			  </button>
			</div>
		`;
	}
}

class ButtonComponent {
	constructor() {

	}

	createTransactions(transactionData) {
		return `
			<button data-transaction-code="${transactionData.transaction_code}" data-transaction-id="${transactionData.id}" type="button" class="btn btn-primary transaction-button btn-block col-lg-10">
			  ${transactionData.transaction_code} <span data-transaction-code="${transactionData.transaction_code}" data-transaction-id="${transactionData.id}" class="badge badge-light">${transactionData.transaction_date}</span>
			</button>
		`;
	}
}

class CardComponent {
	constructor(dataObject) {
		this.cardId = dataObject.cardId;
		this.cardImage = dataObject.cardImage;
		this.cardTitle = dataObject.cardTitle;
		this.cardSubtitle = dataObject.cardSubtitle;
		this.cardText = dataObject.cardText
		this.cardLink = dataObject.cardLink;
	}

	createItem() {
		return `
			<div id="item-${this.cardId}" data-item-id=${this.cardId} class="card col-lg-3 mb-2 mx-1 cursor-pointer">
				<img src="${this.cardImage}" data-item-id=${this.cardId} class="card-img-top pt-2">
			  <div data-item-id=${this.cardId} class="card-body">
			    <h5 data-item-id=${this.cardId} class="card-title">${this.cardTitle}</h5>
			    <h6 data-item-id=${this.cardId} class="card-subtitle mb-2 text-muted">${this.cardSubtitle}</h6>
			    <p data-item-id=${this.cardId} class="card-text">${this.cardText}</p>
			    <a data-item-id=${this.cardId} href="${this.cardLink}" class="card-link">Visit Item</a>
			    <!-- <a href="#" class="card-link">Add to Cart &times;</a> -->
			  </div>
			</div>
		`;
	}

	createUser() {
		return `
			<div class="card-body row">
				<img src="${this.cardImage}" class="col-lg-4">
		    <div class="col-lg-8 row">
		    <h5 class="card-title col-lg-12">Merchant: ${this.cardTitle}</h5>
		    <p class="card-subtitle col-lg-12">${this.cardSubtitle}</p>
		    <p class="card-text col-lg-12">Date Joined: ${this.cardText}</p>
		    <div class="col-lg-12 row justify-content-around">
		    	<button data-user-id="${this.cardId}" class="btn btn-block col-lg-12 m-0 btn-primary visit-merchant">Visit ${this.cardTitle}</button>
				</div>
			</div>
		`;
	}

	createAd() {
		return `
			<div class="card col-lg-3">
    		<div class="card-body">
        	<a data-item-id=${this.cardId} class="card-link" href="#">View ${this.cardTitle}</a>
        	<img src="${this.cardImage}" class="card-img pt-2">
        </div>
    	</div>
		`;
	}

	createCartItem(params) {
		return `
			<div id="item-${this.cardId}" class="col-lg-5">
				<div class="card mb-3">
				  <div class="row no-gutters">
				    <div class="col-md-6">
				      <img src="${this.cardImage}" class="card-img" alt="...">
				    </div>
				    <div class="col-md-6">
				      <div class="card-body">
				        <h5 class="card-title">
				        	${this.cardTitle}
				        	<button type="button" class="close" data-target-id="${this.cardId}" aria-label="Close">
				          	<span data-target-id="${this.cardId}" aria-hidden="true">&times;</span>
				        	</button>
	      				</h5>
				        <p class="card-text">
				        <small class="text-muted">Price ${params.item_price}</small>
				        x #
				        <small id="item-${this.cardId}-price" class="text-muted">${params.item_quantity}</small>
				        </p>
				        <p id="item-${this.cardId}-total" data-target-price="${params.item_price}" class="card-text">Total Amount: ${params.order_price}</p>
				        <form id="item-${this.cardId}-form">
				        	<div class="form-group">
				        		<label for="order_quantity">Order Quantity</label>
				        		<input type="number" name="order_quantity" id="order_quantity" class="form-control" min="1" value="${params.item_quantity}">
				        	</div>
				        	<button data-item-id="${this.cardId}" type="button" class="btn btn-block btn-success update-button">Update Order</button>
				        </form>
				      </div>
				    </div>
				  </div>
				</div>
			</div>
		`;
	}

	createMerchant() {
		return `
			<div class="card mb-3">
			  <div class="row no-gutters">
			    <div class="col-md-4">
			      <img src="${this.cardImage}" class="card-img" alt="Avatar">
			    </div>
			    <div class="col-md-8">
			      <div class="card-body mt-5">
			        <h3 class="card-title">${this.cardTitle} <small class="text-muted">${this.cardText}</small></h3>
							<p class="lead">${this.cardSubtitle}</p>
			      </div>
			    </div>
			  </div>
			</div>
		`;
	}
	
}

class FormComponent {
	constructor() {

	}

	generateItemForm(dataObject) {
		return `
		<div class="card card-body mb-2">
	    <div class="row">
	    	<div class="col-lg-6">
	    		<div class="image-overlay-container">
					  <img id="item_${dataObject.queueNumber}_image" src="${dataObject.item_media_link}" alt="Avatar" class="image-overlay-image">
					  <div class="image-overlay-middle">
					    <div class="image-overlay-text"><label for="item_${dataObject.queueNumber}_form_item_media">Update Item Photo</label></div>
					  </div>
					</div>
	    	</div>
	    	<div class="col-lg-6">
	    		<div id="item_${dataObject.queueNumber}_alert" class="col-lg-12"></div>
	    		<form id="item_${dataObject.queueNumber}_form" data-item-id="${dataObject.item_id}">
	    			<div class="form-group row">
						  <label for="item_${dataObject.queueNumber}_form_item_name" class="col-sm-4 col-form-label">Item Name</label>
						  <div class="col-sm-8">
						  	<input id="item_${dataObject.queueNumber}_form_item_name" type="text" class="form-control text-center" name="form_item_name" placeholder="Item name..." value="${dataObject.item_name}">
						  </div>
						</div>
	    			<div class="form-group row">
						  <label for="item_${dataObject.queueNumber}_form_item_description" class="col-sm-4 col-form-label">Description</label>
						  <div class="col-sm-8">
						  	<textarea class="form-control" id="item_${dataObject.queueNumber}_form_item_description" rows="3" name="form_item_description" placeholder="Describe your item here...">${dataObject.item_description}</textarea>
						  </div>
						</div>
	    			<div class="form-group row">
						  <label for="item_${dataObject.queueNumber}_form_item_price" class="col-sm-4 col-form-label">Price</label>
						  <div class="col-sm-8">
						  	<input id="item_${dataObject.queueNumber}_form_item_price" type="number" class="form-control text-center" name="form_item_price" placeholder="1" value="${dataObject.item_price}">
						  </div>
						</div>
						<div class="form-group">
							<input id="item_${dataObject.queueNumber}_form_item_media" class="form-control" type="file" name="item_${dataObject.queueNumber}_form_item_media" accept="image/*" hidden>
						</div>
	    		</form>
	    		<button id="item_${dataObject.queueNumber}_form_item_submit" type="button" class="btn btn-block btn-success item-update-button" data-group-id="${dataObject.queueNumber}">Update Item</button>
	    	</div>
	    </div>
	  </div>
	  `;
	}

	generateCartForm(dataObject) {
		return `
			<div id="item-${dataObject.id}" data-item-id="${dataObject.id}" class="row justify-content-around">
				<img src="${dataObject.media_link}" class="col-lg-12">
				<div class="col-lg-12 mt-3">
					<h5 class="h5">₱ ${dataObject.price}</h5>
				</div>
				<div class="col-lg-12">
					<form id="form-item-${dataObject.id}" data-item-id="${dataObject.id}">
						<div class="form-group">
							<input type="number" name="order_quantity" id="order_quantity" class="form-control" placeholder="1" min="1" max="25" required>
						</div>
						<button data-target="#form-item-${dataObject.id}" type="button" class="btn btn-block btn-success cart-button">ADD TO CART</button>
					</form>
				</div>
			</div>
		`;
	}
}

class NavigationComponent {
	constructor(projectLink) {
		this.projectLink = projectLink;
	}

	setDefault(currentPage) {
		return `
			<div class="collapse navbar-collapse" id="ez-shopping-navbar">
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item">
		        <a class="nav-link ${currentPage === 'login' ? 'active' : ''} navigation-trigger" href="#" data-target="${this.projectLink}/views/member/login/index.php">📝 Login</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link ${currentPage === 'register' ? 'active' : ''} navigation-trigger" href="#" data-target="${this.projectLink}/views/member/register/index.php">📝 Register</a>
		      </li>
		    </ul>
		  </div>
		`;
	}

	setMember(currentPage, navUser) {
		return `
			<div class="collapse navbar-collapse" id="ez-shopping-navbar">
		    <ul class="navbar-nav ml-auto">
		      <li class="nav-item">
		        <a class="nav-link ${currentPage === 'home' ? 'active' : ''} navigation-trigger" href="#" data-target="${this.projectLink}/views/shopping/home/index.php">📝 Home</a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link ${currentPage === 'cart' ? 'active' : ''} navigation-trigger" href="#" data-target="${this.projectLink}/views/shopping/cart/index.php">📝 Cart</a>
		      </li>
		      <li class="nav-item dropdown">
		      	<a class="nav-link dropdown-toggle ${currentPage === 'profile' ? 'active' : ''}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
	          	${navUser}
		        </a>
		        <div class="dropdown-menu">
		          <a class="dropdown-item navigation-trigger" href="#" data-target="${this.projectLink}/views/member/order/index.php">My Orders</a>
		          <a class="dropdown-item navigation-trigger" href="#" data-target="${this.projectLink}/views/member/profile/index.php">View Profile</a>
		          <a class="dropdown-item" href="#" onclick="logOutUser()">Logout</a>
		        </div>
		      </li>
		    </ul>
		  </div>
		`;
	}

	startListener() {
		document.querySelectorAll('#ez-shopping-navbar .navigation-trigger') .forEach( currElement => {
			currElement.addEventListener('click', e => {
				window.location.assign(e.target.dataset.target);
			});
		});
	}
}

class PaginationComponent {
	constructor(dataObject) {
		this.offset = 0;
		this.limit = parseInt(dataObject.limit);
		this.maxCount = parseInt(dataObject.maxCount);

		if (this.maxCount % this.limit) {
			this.maxCount = this.maxCount + this.limit;
		}
	}
	create() {
		var paginationHeader = `<nav><ul class="pagination justify-content-end">`;
		var paginationFooter = `</ul></nav>`;
	  var pageBody = '';
		var fetchLimit = this.limit;
	  var fetchOffset = this.offset;
	  var fetchMaxCount = this.maxCount;
	  var pageActive = true;
	  var pageLimit = parseInt(fetchMaxCount / fetchLimit);
	  if (fetchMaxCount % fetchLimit) {
	    pageLimit++;
	  }
	  if (isNaN(fetchLimit)) {
	  	let parseErr = {}
	  	parseErr.message = 'is not a number';
	  	parseErr.success = false;
	  	return parseErr;
	  } else if (isNaN(fetchOffset)) {
	  	let parseErr = {}
	  	parseErr.message = 'is not a number';
	  	parseErr.success = false;
	  	return parseErr;
	  } else if (isNaN(fetchMaxCount)) {
	  	let parseErr = {}
	  	parseErr.message = 'is not a number';
	  	parseErr.success = false;
	  	return parseErr;
	  } 
	  for (let pageNumber = 1; pageNumber < pageLimit; pageNumber++) {
	    pageBody += `<li id="page-${pageNumber}" class="page-item ${pageActive ? 'active' : ''} pagination-button"><button class="page-link" data-offset="${fetchOffset}" data-limit="${fetchLimit}">${pageNumber}</button></li>`;
	    fetchOffset = fetchOffset + fetchLimit;
	    pageActive = false;
	  }
	  // return pageButtons;
		// return paginationBody;
		return paginationHeader + pageBody + paginationFooter;
	}

	sss() {
		return 'world';
	}
}

class SloganComponent {
	constructor() {

	}

	createItemSlogan(dataObject) {
		return `
			<h4 class="h4">${dataObject.name}</h4>
			<p class="lead">&emsp;&emsp;${dataObject.description}</p>
		`;
	}

	createEmptySetSlogan(dataObject) {
		return `<p class="lead">Result seems to be empty</p>`;
	}
}

class SpinnerComponent {
	wholeScreen = false;
	oldElement = '';
	constructor(targetElement) {
		// this.id = targetId;
		this.targetElement = targetElement;
	}

	start() {
		if (document.querySelector(`#spinner-${this.targetElement}`) !== null ) {
			return false;
		}
		if (this.wholeScreen === true) {
			document.body.style.overflow = 'hidden';
		}
		this.oldElement = document.querySelector(`#${this.targetElement}`).innerHTML;
		document.querySelector(`#${this.targetElement}`).innerHTML = `
			<div id="spinner-${this.targetElement}" class="loader-wrapper">
				<span class="loader"></span>
			</div>
		`;

	}

	end() {
		if (document.querySelector(`#spinner-${this.targetElement}`) === null ) {
			return false;
		}
		if (this.wholeScreen === true) {
			document.body.style.overflow = 'auto';
		}
		document.querySelector(`#spinner-${this.targetElement}`).parentElement.innerHTML = this.oldElement;
	}
}

export { AccordionComponent, AlertComponent, ButtonComponent, CardComponent, FormComponent, NavigationComponent, PaginationComponent, SloganComponent, SpinnerComponent };