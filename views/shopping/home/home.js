import  ApiCall  from '../../../assets/js/api.js';
import { CardComponent, PaginationComponent, SpinnerComponent } from '../../../assets/js/components.js';

// variables
const itemContainerLoading = new SpinnerComponent('item-container');
const itemsApi = new ApiCall('api.shopping.php');
let itemCount = 0;
let requestForm = new FormData();

// functions
function createItem(dataObject) {
  let elementText = '';
  for (let i = 0; i < dataObject.items .length; i++) {
    let itemData = {};
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

function paginate(data) {
  var fetchLimit = 10;
  var fetchOffset = 0;
  var fetchMaxCount = data;
  var pageButtons = ''  ;
  var pageActive = true;
  var pageLimit = parseInt(fetchMaxCount / fetchLimit);
  if (fetchMaxCount % fetchLimit) {
    pageLimit++;
  }
  console.log(fetchLimit, fetchOffset, fetchMaxCount, pageLimit);
  for (let pageNumber = 1; pageNumber <= pageLimit; pageNumber++) {
    pageButtons += `<li class="page-item ${pageActive ? 'active' : ''}"><button class="page-link pagination-button" data-offset="${fetchOffset}" data-limit="${fetchLimit}">${pageNumber}</button></li>`;
    fetchOffset = fetchOffset + fetchLimit;
    pageActive = false;
  }
  return pageButtons;
}

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
  let paginateData = {};
  paginateData.limit = 10;
  paginateData.maxCount = response.item_count;
  let pagePaginate = new PaginationComponent(paginateData);
  document.querySelector('#page-pagination').innerHTML = pagePaginate.create();
  document.querySelectorAll('.pagination-button') .forEach( element => {
    element.addEventListener('click', function (event) {
      document.querySelector('li.pagination-button.active').classList.remove('active');
      event.target.parentElement.classList.add('active');
      requestForm.set('request_process', 'fetch_default');
      requestForm.set('request_limit', event.target.dataset.limit);
      requestForm.set('request_offset', event.target.dataset.offset);
      itemsApi.post(requestForm).then ( response => {
        document.querySelector('#item-container').innerHTML = createItem(response);
        window.scrollTo(0,0);
      });
    });
  });
});

/*
// implementing functions to bind with html
function testingz() {
  console.log(itemCount);
}

window.testingz = testingz;
*/