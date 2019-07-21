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
		this.cardImage = dataObject.cardImage;
		this.cardTitle = dataObject.cardTitle;
		this.cardSubtitle = dataObject.cardSubtitle;
		this.cardText = dataObject.cardText
		this.cardLink = dataObject.cardLink;
	}

	createItem() {
		return `
			<div class="card col-lg-3 mb-2 mx-1 cursor-pointer">
				<img src="${this.cardImage}" class="card-img-top pt-2">
			  <div class="card-body">
			    <h5 class="card-title">${this.cardTitle}</h5>
			    <h6 class="card-subtitle mb-2 text-muted">${this.cardSubtitle}</h6>
			    <p class="card-text">${this.cardText}</p>
			    <a href="${this.cardLink}" class="card-link">Visit Item</a>
			    <!-- <a href="#" class="card-link">Add to Cart &times;</a> -->
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

export { AlertComponent, CardComponent, FormComponent, SpinnerComponent };