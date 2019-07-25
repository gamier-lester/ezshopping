import  ApiCall  from '../../../assets/js/api.js';
import { AlertComponent, FormComponent, NavigationComponent, SpinnerComponent } from '../../../assets/js/components.js';
import config from '../../../config/config.js';

// variables
// const registerButtonLoading = new SpinnerComponent('register-button');
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const profileContainerAlert = new AlertComponent('profile-alert-container');
const profileDetailsContainerAlert = new AlertComponent('profile-details-alert-container');
const contentContainerAlert = new AlertComponent('content-alert-container');
const formComponent = new FormComponent;
const messageContainerAlert = new AlertComponent('message-alert-container');
const profileMediaContainerLoading = new SpinnerComponent('profile-media-container');
const profileDetailsLoading = new SpinnerComponent('profile-details-container');
const updateProfileLoading = new SpinnerComponent('update-profile-button');
const uploadImageLoading = new SpinnerComponent('hidden-submit');
const addItemLoading = new SpinnerComponent('add-item-button');
const memberApi = new ApiCall('api.member.php');
const itemApi = new ApiCall('api.item.php');
let requestForm = new FormData();
let alertData = {};
const storageService = firebase.storage();
const storageRef = storageService.ref();
const metadata = {
  contentType: 'image/jpeg',
  cacheControl: 'public, max-age=36000000',
};

// functions
function addItem(formData) {
  let addItemButton = document.querySelector('#add-item-button');
  let newName = new Date() .getTime();
  addItemButton.disabled = true;
  addItemLoading.start();
  let requestData = document.querySelector(`#${formData}`);
  if (requestData.form_item_name.value === '') {
    addItemLoading.end();
    addItemButton.disabled = false;
    requestData.form_item_name.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item name can\'t be empty!';
    contentContainerAlert.alert(alertData);
    return false;
  } else if (requestData.form_item_description.value === '') {
    addItemLoading.end();
    addItemButton.disabled = false;
    requestData.form_item_description.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item description can\'t be empty!';
    contentContainerAlert.alert(alertData);
    return false;
  } else if (requestData.form_item_price.value === '') {
    addItemLoading.end();
    addItemButton.disabled = false;
    requestData.form_item_price.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item price can\'t be empty!';
    contentContainerAlert.alert(alertData);
    return false;
  } else if (requestData.form_item_container_media_primary.files .length === 0) {
    addItemLoading.end();
    addItemButton.disabled = false;
    document.querySelector('#add-item-image').classList.add('border');
    document.querySelector('#add-item-image').classList.add('border-danger');
    alertData.type = 'danger';
    alertData.message = 'Plese select Image for this item!';
    contentContainerAlert.alert(alertData);
    return false;
  }

  let imageData = requestData.form_item_container_media_primary.files[0];
  const uploadTask = storageRef.child(`images/item-${newName}`).put(imageData, metadata);
  uploadTask.on('state_changed', (snapshot) => {
  }, (error) => {
    // Handle unsuccessful uploads
    alertData.type = 'danger';
    alertData.message = 'Error: Failed to upload image';
    contentContainerAlert.alert(alertData);
    addItemLoading.end();
  }, () => {
     // Do something once upload is complete
    uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
      requestForm = new FormData();
      requestForm.set('request_process', 'add_item_detail');
      requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
      requestForm.set('request_item_name', requestData.form_item_name.value);
      requestForm.set('request_item_description', requestData.form_item_description.value);
      requestForm.set('request_item_price', requestData.form_item_price.value);
      itemApi.post(requestForm).then( response => {
        requestForm = new FormData();
        requestForm.set('request_process', 'add_item_media');
        requestForm.set('request_item_id', response.item_id);
        requestForm.set('request_item_media', downloadURL);
        itemApi.post(requestForm).then( mediaResponse => {
          alertData.type = (response.response_message.success) ? 'success' : 'danger' ;
          alertData.message = response.response_message.message;
          contentContainerAlert.alert(alertData);
          addItemLoading.end();
        });
      });
    });
  });
}

function changeImage(imageSource, targetElement) {
  let data = document.querySelector(`#${imageSource}`);
  let imageElem = document.querySelector(`#${targetElement}`);
  if (data.files .length > 0) {
    let newImage = data.files[0];
    let reader = new FileReader();
    reader.addEventListener("load", () => {
      imageElem.src = reader.result;
    }, false);
    reader.readAsDataURL(newImage);
  }
}

function toggleFormAlert(event) {
  if (event.classList.contains('alert-danger')) {
    event.classList.remove('alert-danger');
  } else if (event.classList.contains('border')) {
    event.classList.remove('border');
    event.classList.remove('border-danger');
  }
}

function toggleNavActive(element) {
  let navs = document.querySelectorAll('.profile-nav');
  for (let i = 0; i < navs .length; i++) {
    if (navs[i].classList.contains('active')) {
      navs[i].classList.remove('active');
      navs[i].disabled = false;
    }
  }
  $('.collapse').collapse('hide');
  element.classList.add('active');
  element.disabled = true;
  let showItem = element.dataset.target;
  $(`${showItem}`).collapse('show');
}

function updateItemDetails(formData, updateButton){
  updateButton.disabled = true;
  let requestData = document.querySelector(`#item_${formData}_form`);
  let dynamicAlert = new AlertComponent(`item_${formData}_alert`);
  let dynamicLoader = new SpinnerComponent(updateButton.id);

  dynamicLoader.start();
  if (requestData.form_item_name.value === '') {
    requestData.form_item_name.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item name couldn\'t be empty!';
    dynamicAlert.alert(alertData);
    dynamicLoader.end();
    updateButton.disabled = false;
    return false
  } else if (requestData.form_item_description.value === '') {
    requestData.form_item_description.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item description couldn\'t be empty!';
    dynamicAlert.alert(alertData);
    dynamicLoader.end();
    updateButton.disabled = false;
    return false
  } else if (requestData.form_item_price.value === '') {
    requestData.form_item_price.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Item price couldn\'t be empty!';
    dynamicAlert.alert(alertData);
    dynamicLoader.end();
    updateButton.disabled = false;
    return false
  }
  requestForm.set('request_process', 'update_item_details');
  requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
  requestForm.set('request_item_id', requestData.dataset.itemId);
  requestForm.set('request_item_name', requestData.form_item_name.value);
  requestForm.set('request_item_description', requestData.form_item_description.value);
  requestForm.set('request_item_price', requestData.form_item_price.value);
  itemApi.post(requestForm).then( response => {
    if (response.response_message.success) {
      alertData.type = (response.response_message.success) ? 'success' : 'danger';
      alertData.message = response.response_message.message;
      dynamicAlert.alert(alertData);
    } else if (!response.response_message.success) {
      alertData.type = (response.response_message.success) ? 'success' : 'danger';
      alertData.message = response.response_message.message;
      dynamicAlert.alert(alertData);
    }
    updateButton.disabled = false;
    dynamicLoader.end();
  });
}

function updateProfile(formData, updateButton) {
  let requestData = document.querySelector(`#${formData}`);
  updateButton.disabled = true;  
  updateProfileLoading.start();
  if (requestData.form_profile_email.value === '') {
    updateProfileLoading.end();
    updateButton.disabled = false;
    requestData.form_profile_email.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Email couldn\'t be empty!';
    profileDetailsContainerAlert.alert(alertData);
    return false;
  } else if (requestData.form_profile_firstname.value === '') {
    updateProfileLoading.end();
    updateButton.disabled = false;
    requestData.form_profile_firstname.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Firstname couldn\'t be empty!';
    profileDetailsContainerAlert.alert(alertData);
    return false;
  } else if (requestData.form_profile_lastname.value === '') {
    updateProfileLoading.end();
    updateButton.disabled = false;
    requestData.form_profile_lastname.classList.add('alert-danger');
    alertData.type = 'danger';
    alertData.message = 'Lastname couldn\'t be empty!';
    profileDetailsContainerAlert.alert(alertData);
    return false;
  }
  requestForm.set('request_process', 'update_user_data');
  requestForm.set('request_member_email', requestData.form_profile_email.value);
  requestForm.set('request_member_firstname', requestData.form_profile_firstname.value);
  requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
  requestForm.set('request_member_lastname', requestData.form_profile_lastname.value);
  memberApi.post(requestForm).then( response => {
    if (response.response_message.success) {
      updateProfileLoading.end();
      updateButton.disabled = false;
      alertData.type = response.response_message.success ? 'success' : 'danger';
      alertData.message = response.response_message.message;
      profileDetailsContainerAlert.alert(alertData);
    } else if (!response.response_message.success) {
      updateProfileLoading.end();
      updateButton.disabled = false;
      alertData.type = 'danger';
      alertData.message = response.response_message.message;
      profileDetailsContainerAlert.alert(alertData);
    }
  });
}

function uploadImage(data) {
  uploadImageLoading.start();
  let imageData = document.querySelector(`#${data}`).files[0];
  let newName = new Date() .getTime();
  const uploadTask = storageRef.child(`images/${newName}-revisions`).put(imageData, metadata);
  uploadTask.on('state_changed', (snapshot) => {
  }, (error) => {
    // Handle unsuccessful uploads
    alertData.type = 'danger';
    alertData.message = 'Error: Failed to upload image';
    profileContainerAlert.alert(alertData);
    uploadImageLoading.end();
  }, () => {
     // Do something once upload is complete
     uploadTask.snapshot.ref.getDownloadURL().then(function(downloadURL) {
      requestForm.set('request_process', 'update_primary_media');
      requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
      requestForm.set('request_member_media', downloadURL);
      memberApi.post(requestForm).then( response => {
        uploadImageLoading.end();
        alertData.type = (response.response_message.success) ? 'success' : 'danger' ;
        alertData.message = response.response_message.message;
        profileContainerAlert.alert(alertData);
      });
    });
  });
}

function showSubmit(element) {
  let submitButton = document.querySelector(`#${element}`);
  submitButton.classList.remove('display-none');
}

// functions ()
if (JSON.parse(window.localStorage.getItem('member')) === null) {
  window.location.assign(projectUrl+'/views/member/login/index.php');
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember('profile', JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}

requestForm.set('request_process', 'fetch_primary_media');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
profileMediaContainerLoading.start();
memberApi.post(requestForm).then( response => {
	profileMediaContainerLoading.end();
	let media_link = (response.response_message.success) ? response.media_link.media_link : 'https://firebasestorage.googleapis.com/v0/b/ez-shopping-11c7a.appspot.com/o/images%2Favatar.png?alt=media&token=8239916f-7b64-4960-b0c2-b89a9cfb6b4f';
	document.querySelector('#profile-media-container').innerHTML =	`
	<img id="display_picture" src="${media_link}" alt="Avatar" class="image-overlay-image">
  <div class="image-overlay-middle">
    <div class="image-overlay-text"><label for="hidden_profile_input">Change Image</label></div>
  </div>`;
});

profileDetailsLoading.start();
requestForm.set('request_process', 'fetch_user_data');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
requestForm.set('request_member_access_token', JSON.parse(window.localStorage.getItem('member')) .access_token);
memberApi.post(requestForm).then( response => {
  if (response.response_message.success) {
    profileDetailsLoading.end();
    let profileDetailsForm = document.querySelector('#profile-details-container');
    profileDetailsForm.form_profile_username.value = response.member_details.member_username;
    profileDetailsForm.form_profile_email.value = response.member_details.member_email;
    profileDetailsForm.form_profile_firstname.value = response.member_details.member_firstname;
    profileDetailsForm.form_profile_lastname.value = response.member_details.member_lastname;
  } else if (!response.response_message.success) {
    profileDetailsLoading.end();
    alertData.type = 'Warning';
    alertData.message = response.response_message.message;
  }
});

requestForm.set('request_process', 'fetch_user_items');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
let itemData = {};
itemApi.post(requestForm).then( response => {
  let itemsHTML = '';
  for (let i = 0; i < response.items .length; i++) {
    itemData.queueNumber = i;
    itemData.item_description = response.items[i].item_description;
    itemData.item_id = response.items[i].item_id;
    itemData.item_media_link = response.items[i].media_link;
    itemData.item_name = response.items[i].item_name;
    itemData.item_price = response.items[i].item_price;
    itemsHTML += formComponent.generateItemForm(itemData);
  }
  document.querySelector('#view_items').innerHTML += itemsHTML;
  document.querySelectorAll('.form-control') .forEach( element => {
    element.addEventListener('click', function (event) {
      if (event.target.classList.contains('alert-danger')) {
        event.target.classList.remove('alert-danger');
      }
    });
  });
  document.querySelectorAll('.item-update-button') .forEach( element => {
    element.addEventListener('click', function (event) {
      updateItemDetails(event.target.dataset.groupId, event.target);
    });
  });
});

requestForm.set('request_process', 'fetch_user_message');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
memberApi.post(requestForm).then( response => {
  // console.log(response);
  if (response.response_message.success) {
    alertData.type = response.response_message.success ? 'success' : 'danger';
    alertData.message = response.response_message.message;
    messageContainerAlert.alert(alertData);
  } else if (!response.response_message.success) {
    alertData.type = response.response_message.success ? 'success' : 'danger';
    alertData.message = response.response_message.message;
    messageContainerAlert.alert(alertData);
  }
});


// set functions to window
window.addItem = addItem;
window.changeImage = changeImage;
window.showSubmit = showSubmit;
window.uploadImage = uploadImage;
window.toggleFormAlert = toggleFormAlert;
window.updateProfile = updateProfile;
window.toggleNavActive = toggleNavActive;
window.updateItemDetails = updateItemDetails;