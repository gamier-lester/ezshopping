// constant
var urlPath = 'http://localhost:8080/e-commerce';
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