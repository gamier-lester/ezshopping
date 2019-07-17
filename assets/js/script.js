// constant
var urlPath = 'http://localhost:8080/e-commerce';
var selectedFile;
// firebase

// var firebaseConfig = {
//   apiKey: "AIzaSyBdk9I4E7wKCnYYMVwpzRxYneyWrM5jcW4",
//   authDomain: "ez-shopping-11c7a.firebaseapp.com",
//   databaseURL: "https://ez-shopping-11c7a.firebaseio.com",
//   projectId: "ez-shopping-11c7a",
//   storageBucket: "",
//   messagingSenderId: "78410641074",
//   appId: "1:78410641074:web:ab3b63d1e1ddec8d"
// };

// Initialize Firebase
// firebase.initializeApp(firebaseConfig);
// end firebase

// components
async function overlayContent(item_id) {
	if (document.querySelector('#overlay-item') !== null) {
		return false;
	}
	function showOverlay() {
		document.body.style.overflowY = 'hidden';
		document.querySelector('#overlay-item').style.width = '100%';
	}

	function destroyOverlay() {
		document.body.style.overflowY = 'auto';
		document.querySelector('#overlay-item').style.width = '0';
		setTimeout(() => { document.body.removeChild(document.querySelector('#overlay-item')); }, 500);
	}
	
	// create overlay
	let overlay = document.createElement('div');
	let overlayContent = document.createElement('div');
	let overlayExit = document.createElement('a');

	overlay.appendChild(overlayExit);
	overlayExit.innerHTML = '&times;';

	overlay.appendChild(overlayContent);

	overlay.setAttribute('class', 'overlay');
	overlay.setAttribute('id', 'overlay-item');
	// overlayContent.setAttribute('class', 'overlay-content');
	overlayExit.setAttribute('class', 'closebtn');
	overlayExit.setAttribute('href', 'javascript:void(0)');

	overlayExit.addEventListener('click', () => {
		destroyOverlay();
	});

	// triggered with overlay.style.width = '100%';
	document.querySelector('body').appendChild(overlay);
	setTimeout(function() { showOverlay(); }, 100);


	/* asdasd
	overlayContent.classList.add('container', 'py-5');
	let contentSection = document.createElement('section');
	contentSection.classList.add('row');
	overlayContent.appendChild('contentSection');
	let groupA = document.createElement('div');
	groupA.setAttribute('col-lg-3');
	let groupB = document.createElement('div');
	groupB.setAttribute('col-lg-9');
	contentSection.appendChild('groupA');
	contentSection.appendChild('groupB');
	// contents of group A

	*/ // asdasd

	let requestForm = new FormData();
	requestForm.append('process', 'fetch_one');
	requestForm.append('item_id', item_id);
	request_response = await fetch(
		`${urlPath}/controllers/api.shopping.php`,
		{
      method: 'POST',
			body: requestForm
	  }).then(function(response) {
      if (response.status >= 200 && response.status < 300) {
          return response.json()
      }
      throw new Error(response.statusText)
    }).then(function(response) {
      return response;
  });

  console.log(request_response);
  item_data = request_response.item_data;
  item_media = request_response.item_media;
  item_merchant = request_response.item_merchant;
  item_related_search = request_response.item_related_search;
  
	overlayContentData = `<div class="container py-5 text-light">
		<section class="row">
			<div class="col-lg-3">
				<div class="row justify-content-around">`;
	/*
	overlayContentData += `<img src="${item_data.media_link}" class="col-lg-12">
					<img src="http://localhost:8080/e-commerce/assets/images/profile.jpg" class="col-lg-3">
					<img src="http://localhost:8080/e-commerce/assets/images/sandbox.png" class="col-lg-3">
					<img src="http://localhost:8080/e-commerce/assets/images/evilmonkey.png" class="col-lg-3">`;
	*/

	for (i = 0; i < item_media .length; i++) {
		if (item_media[i].media_type === 'primary')	{
			overlayContentData += `<img src="${item_media[i].media_link}" class="col-lg-12">`;
		} else if (item_media[i].media_type === 'secondary') {
			overlayContentData += `<img src="${item_media[i].media_link}" class="col-lg-3" onclick="showImage(this);">`;
		}
	}

	overlayContentData += `<div class="col-lg-12 mt-3">
						<h5 class="h5">₱ ${item_data.price}</h5>
					</div>
					<div class="col-lg-12">
						<form action="${urlPath}/controllers/process.add-to-cart.php" method="POST">
							<div class="form-group">
								<label for="order_quantity">Quantity</label>
								<input type="number" name="item_id" hidden value="${item_data.id}">
								<input type="number" name="item_price" hidden value="${item_data.price}">
								<input type="number" name="order_quantity" id="order_quantity" class="form-control" placeholder="1" required>
							</div>
							<button class="btn btn-block btn-success">ADD TO CART</button>
							<button class="btn btn-block">BUY NOW!</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-9">
				<p class="lead">${item_data.name}</p>
				<h4 class="h4">${item_data.description}</h4>
				<h4 class="h4">${item_data.merchant_firstname}</h4>
			</div>`;

	overlayContentData += `<div class="col-lg-12">
				<div class="row justify-content-center">`;

	for (i = 0; i < item_related_search .length; i++) {
		overlayContentData += `<a href="${urlPath}/views/shopping/items/${item_related_search[i].user_id}/${item_related_search[i].id}" class="col-lg-3"><img src="${item_related_search[i].media_link}" class="rounded-circle ads-img"></a>`;
	}

	overlayContentData += `</div>
			</div>
		</section>
	</div>`;

	overlayContent.innerHTML = overlayContentData;
	
}

function showImage(element) {
	element.parentElement.firstElementChild .setAttribute('src', element.getAttribute('src'));
}	

function uploadImage(event, key, targetElem) {
	console.log(event, key);
	const storageService = firebase.storage();
	const storageRef = storageService.ref();
	const metadata = {
		contentType: 'image/jpeg',
		cacheControl: 'public, max-age=36000000',
	};

	// document.querySelector('.file-select').addEventListener('change', handleFileUploadChange);
	// document.querySelector('.file-submit').addEventListener('click', handleFileUploadSubmit);

	if (event === 'change') {
		element = key;
		element.addEventListener('change', function(e) {
			// console.log(e.target.files[0]);
			selectedFile = e.target.files[0];
			if (targetElem !== undefined) {
				let preview = document.querySelector(`${targetElem}`);
		  	let reader  = new FileReader();

		  	reader.addEventListener("load", function () {
			    preview.src = reader.result;
			  }, false);
			  reader.readAsDataURL(selectedFile);
			}
		});
	} else if (event === 'submit') {
		// const uploadTask = storageRef.child(`images/${selectedFile.name}`).put(selectedFile); //create a child directory called images, and place the file inside this directory
	  newName = new Date() .getTime();
	  const uploadTask = storageRef.child(`images/${newName}-testImage`).put(selectedFile, metadata);
	  uploadTask.on('state_changed', (snapshot) => {
	  // Observe state change events such as progress, pause, and resume
	  }, (error) => {
	    // Handle unsuccessful uploads
	    console.log(error);
	  }, () => {
	     // Do something once upload is complete
	     console.log('success');
	     selectedFile = null;
	     uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
		    console.log('File available at', downloadURL);
		    document.querySelector(`#${targetElem}`).value = downloadURL;
		   	// targetElem.value = downloadURL;
		   	key.previousElementSibling .submit();
		   	// console.log(targetElem);
		  });
	  });
	}
}
// add item functions
function changePrimaryImage(targetElement, sourceElement) {
	console.log(sourceElement);
	let imageContainer = document.querySelector(`${targetElement}`);
	let sourceElem = sourceElement.target.files[0];
	let reader  = new FileReader();

	reader.addEventListener("load", function () {
    imageContainer.src = reader.result;
  }, false);
  reader.readAsDataURL(sourceElem);
}

async function addNewItem(triggerElement) {
	console.log(triggerElement);
	const storageService = firebase.storage();
	const storageRef = storageService.ref();
	const metadata = {
		contentType: 'image/jpeg',
		cacheControl: 'public, max-age=36000000',
	};
	let alertMessage = `<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
											  Main image could not be empty!
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
											</div>`;

	async function uploadImage(imageData) {
		mediaArray = [];
		for (i = 0; i < imageData .length; i++) {
			newName = new Date() .getTime();
		  const uploadTask = storageRef.child(`images/${newName}`).put(imageData[i], metadata);
		  uploadTask.on('state_changed', (snapshot) => {
		  // Observe state change events such as progress, pause, and resume
		  }, (error) => {
		    // Handle unsuccessful uploads
		    console.log(error);
		  }, async () => {
		     // Do something once upload is complete
	    	console.log('success');
	    	await uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
		    	console.log('File available at', downloadURL);
		    	mediaArray.push(downloadURL);
		   	// targetElem.value = downloadURL;
		   	// console.log(targetElem);
		   		if (i < ((imageData .length) - 1)) {
		   			add_new_item_form.submit();
		   		}
		  	});
		  });
		}
		return mediaArray;
	}

	triggerElement.style.display = 'none';
	if (form_item_container_media_primary.files .length === 0) {
		triggerElement.style.display = 'block';
		triggerElement.parentElement.innerHTML += alertMessage;
		return false;
	}

	// let primary_media = await this.uploadImage(form_item_container_media_primary.files);

	// form_item_media_primary.value = JSON.stringify(primary_media);
	// if (form_item_container_media_secondary.files .length > 0) {
	// 	let secondary_media = await this.uploadImage(form_item_container_media_secondary.files);
	// 	form_item_media_secondary.value =  JSON.stringify(secondary_media);
	// }
	// add_new_item_form.submit();
	// // console.log('var: ',primary_media);
	// Promise.all([primary_media]).then(function(result) {
	// 	console.log(result);
	// });

	newName = new Date() .getTime();
  const uploadTask = storageRef.child(`images/${newName}`).put(form_item_container_media_primary.files[0], metadata);
  uploadTask.on('state_changed', (snapshot) => {
  // Observe state change events such as progress, pause, and resume
  }, (error) => {
    // Handle unsuccessful uploads
    console.log(error);
  }, () => {
     // Do something once upload is complete
  	console.log('success');
  	uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
    	console.log('File available at', downloadURL);
    	form_item_media_primary.value = downloadURL;
    	add_new_item_form.submit();
    	// mediaArray.push(downloadURL);
   	// targetElem.value = downloadURL;
   	// console.log(targetElem);
  	});
  });

}

function toggleSubmitButton(element) {
	toggleElement = document.querySelector(`${element}`);
	toggleElement.classList.remove('display-none');
	console.log(toggleElement);
}