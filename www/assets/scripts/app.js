console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
/**
 * Import Scripts
 */
import './bootstrap.js';
import Flash from "./sweetalert2.js";
/**
 * Import StyleSheets
 */
import '../styles/bootstrap/5.3.7.sass';

customElements.define('app-flash', Flash)

// console.clear();
