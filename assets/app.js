/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';
import './styles/select2.min.css';


// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const $ = require('jquery');
require('bootstrap');
// require('jquery-ui/ui/widgets/autocomplete');
require('./select2.full.min.js');
require('./select2-locales/fr.js');

const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import { data } from 'jquery';

Routing.setRoutingData(routes);
// Routing.generate('rep_log_list');


$(function() {
    var test = Routing.generate('objet_search');
    var tab = {};
    var sub = [];
    $("#search-object").select2({
        language: "fr",
        placeHolder: 'Rechercher',
        minimumInputLength: 3,
        ajax: {
            url: test,
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                return {
                    search: params.term
                }
            },
            processResults: function(data) {
                var resData = [];
                resData.push(data);
                return {
                    results: $.map(resData, function(item) {
                        return {
                            text: item.nom,
                            id: item.id
                        }
                    })
                };
            }
        }
    });
    $("#search-object").on("select2:select", function(e) {
        
    })
});