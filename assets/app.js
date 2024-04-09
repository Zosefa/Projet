
// assets/app.js
// import { registerReactControllerComponents } from '@symfony/ux-react';



/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './bootstrap/css/bootstrap.min.css';
import './styles/style.css';
import './fontawesome/css/all.css';
import './styles/register.css';


import './bootstrap/js/bootstrap.min.js';
import './fontawesome/js/all.js';


console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');
// registerReactControllerComponents(require.context('./react/controllers', true, /\.(j|t)sx?$/));
// registerReactControllerComponents();