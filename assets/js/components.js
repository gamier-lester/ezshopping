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

export { AlertComponent, CardComponent, SpinnerComponent };