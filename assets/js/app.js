/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import $ from 'jquery';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

// $(function(){
//     // On recupere la position du bloc par rapport au haut du site
//     var position_top_raccourci = $("#navigation").offset().top;
    
//     //Au scroll dans la fenetre on déclenche la fonction
//     $(window).scroll(function ()
//     {
//         //si on a defile de plus de 150px du haut vers le bas
//         if ($(this).scrollTop() > position_top_raccourci)
//         {
//             //on ajoute la classe "fixNavigation" a <div id="navigation">
//             $('#navigation').addClass("fixNavigation"); 
//         }
//         else
//         {
//             //sinon on retire la classe "fixNavigation" a <div id="navigation">
//             $('#navigation').removeClass("fixNavigation");
//         }
//     });
// });

