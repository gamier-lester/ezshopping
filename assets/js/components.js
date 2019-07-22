// function createElement(element, ) {
// 	alertElement = 
// 	<div class="alert alert-danger alert-dismissible fade show col-lg-12" role="alert">
// 	  <?php echo $_SESSION['add-to-cart_error-message']; ?>
// 	  <button type="button" class="close" data-dismiss="alert">
// 	  	<span>&times;</span>
// 	  </button>
// 	  <?php unset($_SESSION['add-to-cart_error-message']); ?>
// 	</div>
// }

// class Hero {
// 	constructor(name, level) {
// 		this.name = name;
// 		this.level = level;
// 	}

// 	greet() {
//         return `${this.name} says hello.`;
//     }
// }

const projectUrl = 'http://localhost:8080/e-commerce';
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
		    	<button data-user-id="${this.cardId}" class="btn btn-block col-lg-5 m-0 btn-primary visit-merchant">Visit ${this.cardTitle}</button>
	        <button data-user-id="${this.cardId}" class="btn btn-block col-lg-5 m-0 btn-success message-merchant">Message ${this.cardTitle}</button>
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
}

class FormComponent {
	constructor() {

	}

	generateItemForm(dataObject) {
		return `
		<div class="card card-body">
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
		        <a class="nav-link ${currentPage === 'cart' ? 'active' : ''} navigation-trigger" href="#" data-target="${this.projectLink}/views/shopping/">📝 Cart</a>
		      </li>
		      <li class="nav-item dropdown">
		      	<a class="nav-link dropdown-toggle ${currentPage === 'profile' ? 'active' : ''}" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
	          	${navUser}
		        </a>
		        <div class="dropdown-menu">
		          <a class="dropdown-item navigation-trigger" href="#" data-target="${this.projectLink}/views/member/orders/index.php">My Orders</a>
		          <a class="dropdown-item navigation-trigger" href="#" data-target="${this.projectLink}/views/member/profile/index.php">View Profile</a>
		          <a class="dropdown-item navigation-trigger" href="#" data-target="${this.projectLink}/views/member/logout/index.php">Logout</a>
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
		if (this.wholeScreen === true) {
			document.body.style.overflow = 'auto';
		}
		document.querySelector(`#spinner-${this.targetElement}`).parentElement.innerHTML = this.oldElement;
	}
}

export { AlertComponent, CardComponent, FormComponent, NavigationComponent, PaginationComponent, SloganComponent, SpinnerComponent };