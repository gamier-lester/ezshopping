import  ApiCall  from '../../../assets/js/api.js';
import { CardComponent, SpinnerComponent } from '../../../assets/js/components.js';

// variables
const itemContainerLoading = new SpinnerComponent('item-container');
const itemsApi = new ApiCall('api.shopping.php');
let itemCount = 0;
let requestForm = new FormData();
// functions


// functions();

itemContainerLoading.start();
requestForm.set('request_process', 'fetch_default');
itemsApi.post(requestForm).then( response => {
  let elementText = '';
  for (let i = 0; i < response.items .length; i++) {
    let itemData = {};
    itemData.cardImage = response.items[i].media_link;
    itemData.cardTitle = response.items[i].name;
    itemData.cardSubtitle = response.items[i].price;
    itemData.cardText = response.items[i].description;
    itemData.cardLink = response.items[i].merchant_firstname;

    let card = new CardComponent(itemData);
    elementText += card.createItem();
  }
  itemContainerLoading.end();
  document.querySelector('#item-container').innerHTML = elementText;
});

requestForm.set('request_process', 'fetch_count');
itemsApi.post(requestForm).then( response => {
  itemCount = response;
});

/*
// implementing functions to bind with html
function testingz() {
  console.log(itemCount);
}

window.testingz = testingz;
*/