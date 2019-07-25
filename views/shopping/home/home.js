import  ApiCall  from '../../../assets/js/api.js';
import { CardComponent, NavigationComponent, PaginationComponent, SpinnerComponent } from '../../../assets/js/components.js';
import config from '../../../config/config.js';

// variables
const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);
const itemContainerLoading = new SpinnerComponent('item-container');
const paginateContainerLoading = new SpinnerComponent('page-pagination');
const itemsApi = new ApiCall('api.shopping.php');
let itemCount = 0;
let requestForm = new FormData();

// functions
function appendItemLink(event) {
  let itemLink = window.open(`${projectUrl}/views/shopping/item/index.php`, '_blank');
  itemLink.itemId = event.target.dataset.itemId;
}

function itemCardAddEvent() {
  document.querySelectorAll('#item-container .card') .forEach( element => {
    element.addEventListener('click', e => {
      appendItemLink(e);
    });
  });
}

function createItem(dataObject) {
  let elementText = '';
  for (let i = 0; i < dataObject.items .length; i++) {
    let itemData = {};
    itemData.cardId = dataObject.items[i].id;
    itemData.cardImage = dataObject.items[i].media_link;
    itemData.cardTitle = dataObject.items[i].name;
    itemData.cardSubtitle = dataObject.items[i].price;
    itemData.cardText = dataObject.items[i].description;
    itemData.cardLink = dataObject.items[i].merchant_firstname;
    let card = new CardComponent(itemData);
    elementText += card.createItem();
  }
  return elementText;
}

function sortItems(orderBy, triggerElement) {
  requestForm = new FormData();
  requestForm.set('request_process', 'fetch_default');
  requestForm.set('request_order', orderBy);
  itemContainerLoading.start();
  itemsApi.post(requestForm).then( response => {
    itemContainerLoading.end();
    document.querySelector('li.pagination-button.active').classList.remove('active');
    document.querySelector('li.pagination-button#page-1').classList.add('active');
    document.querySelector('button.sort-buttons.active').classList.remove('active');
    triggerElement.classList.add('active');
    document.querySelector('#item-container').innerHTML = createItem(response);
    itemCardAddEvent();
  });
}

// functions();
if (JSON.parse(window.localStorage.getItem('member')) === null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setDefault();
  pageNav.startListener();
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember('home', JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}

itemContainerLoading.start();
requestForm = new FormData();
requestForm.set('request_process', 'fetch_default');
itemsApi.post(requestForm).then( response => {
  let elementText = createItem(response);
  itemContainerLoading.end();
  document.querySelector('#item-container').innerHTML = elementText;
  itemCardAddEvent()
});

requestForm = new FormData();
requestForm.set('request_process', 'fetch_count');
paginateContainerLoading.start();
itemsApi.post(requestForm).then( response => {
  let paginateData = {};
  paginateData.limit = 10;
  paginateData.maxCount = response.item_count;
  let pagePaginate = new PaginationComponent(paginateData);
  paginateContainerLoading.end();
  document.querySelector('#page-pagination').innerHTML = pagePaginate.create();
  document.querySelectorAll('.pagination-button') .forEach( element => {
    element.addEventListener('click', function (event) {
      document.querySelector('li.pagination-button.active').classList.remove('active');
      event.target.parentElement.classList.add('active');
      requestForm = new FormData();
      requestForm.set('request_process', 'fetch_default');
      requestForm.set('request_limit', event.target.dataset.limit);
      requestForm.set('request_offset', event.target.dataset.offset);
      itemsApi.post(requestForm).then ( response => {
        document.querySelector('#item-container').innerHTML = createItem(response);
        window.scrollTo(0,0);
        itemCardAddEvent();
      });
    });
  });
});


console.log(config);
/*
// implementing functions to bind with html
function testingz() {
  console.log(itemCount);
}

window.testingz = testingz;
*/
window.sortItems = sortItems;