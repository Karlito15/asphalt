/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './bootstrap.js';
import Flash from "./sweetalert2.js";

// import '../styles/app.css';
// import '../styles/app.sass';

customElements.define('app-flash', Flash)
console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
