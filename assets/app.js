import './styles/app.scss';
const $ = require('jquery');
global.$ = global.jQuery = $;

import './bootstrap';
/* import 'bootstrap/dist/css/bootstrap.min.css'; */

import './slick/slick.min.js';
import './responsive-slick';

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
