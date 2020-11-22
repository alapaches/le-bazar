const routes = require('../public/js/fos_js_routes.json');
import Routing from '../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router.min.js';
import { data } from 'jquery';

Routing.setRoutingData(routes);

$(function() {
    var lieuPieceRoute = Routing.generate('objet_get_lieu_by_piece');
    $('#objet_piece').on('change', function() {
        var pieceSelector = $(this);
        $.ajax({
            url: lieuPieceRoute,
            type: "GET",
            dataType: "JSON",
            data: {
                pieceId: pieceSelector.val()
            },
            success: function (lieux) {
                var lieuxSelect = $("#objet_lieu");

                // Remove current options
                lieuxSelect.html('');
                
                // Empty value ...
                lieuxSelect.append('<option value>Selectionner un endroit de la pièce sélectionnée...</option>');
                
                
                $.each(lieux, function (key, lieu) {
                    lieuxSelect.append('<option value="' + lieu.id + '">' + lieu.nom + '</option>');
                });
            },
            error: function (err) {
                alert("Une erreur est survenue ...");
            }
        });
    });
});