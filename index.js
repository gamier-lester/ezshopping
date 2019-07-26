import config from './config/config.js';
import { NavigationComponent } from './assets/js/components.js';

const projectUrl = config.production ? config.projectUrl.production : config.projectUrl.development;
const pageNav = new NavigationComponent(projectUrl);


if (JSON.parse(window.localStorage.getItem('member')) === null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setDefault();
  pageNav.startListener();
} else if (JSON.parse(window.localStorage.getItem('member')) !== null) {
  document.querySelector('#page-navigation .container').innerHTML += pageNav.setMember(false, JSON.parse(window.localStorage.getItem('member')) .username);
  pageNav.startListener();
}