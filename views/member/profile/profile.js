import  ApiCall  from '../../../assets/js/api.js';
import { AlertComponent, SpinnerComponent } from '../../../assets/js/components.js';

// variables
// const registerButtonLoading = new SpinnerComponent('register-button');
const profileContainerAlert = new AlertComponent('profile-alert-container');
const profileMediaContainerLoading = new SpinnerComponent('profile-media-container');
const memberApi = new ApiCall('api.member.php');
let requestForm = new FormData();
let alertData = {};

// functions


// functions ()
requestForm.set('request_process', 'fetch_primary_media');
requestForm.set('request_member_id', JSON.parse(window.localStorage.getItem('member')) .id);
profileMediaContainerLoading.start();
memberApi.post(requestForm).then( response => {
	profileMediaContainerLoading.end();
	let media_link = (response.response_message.success) ? response.response_message.success : 'https://firebasestorage.googleapis.com/v0/b/ez-shopping-11c7a.appspot.com/o/images%2Favatar.png?alt=media&token=8239916f-7b64-4960-b0c2-b89a9cfb6b4f';
	document.querySelector('#profile-media-container').innerHTML =	`
	<img id="display_picture" src="${media_link}" alt="Avatar" class="image-overlay-image">
  <div class="image-overlay-middle">
    <div class="image-overlay-text"><label for="hidden_profile_input">Change Image</label></div>
  </div>
  <form>
  	<input id="upload_media_link" type="text" name="media_link" hidden>
    <input type="file" id="hidden_profile_input" accept="image/*" required hidden>
  </form>
  <button id="hidden-submit" class="btn btn-block btn-success display-none mt-2">Upload Image</button>`;
});