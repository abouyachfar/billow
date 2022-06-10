$(document).ready(function(){
    jQuery("#do-payment").on("click", function(){
        jQuery("#stripe-errors").text("");
        jQuery("#stripe-errors").addClass("hidden");
        
        // Creation de paiement par carte
        var cle = jQuery('#cle_publique').val();
        var pack_id = jQuery(this).data('id');

        Stripe.setPublishableKey(cle);

        var frm = jQuery('#do-payment');

        Stripe.card.createToken({
            number: $('#code_carte').val(),
            cvc: $('#code_verif').val(),
            exp_month: $('#mois').val(),
            exp_year: $('#annee').val()
          }, function (status, response) {
            if (response.error) { // Ah une erreur !
              // On affiche les erreurs
              jQuery("#stripe-errors").text(response.error.message);
              jQuery("#stripe-errors").removeClass("hidden");
            } else { // Le token a bien été créé
              var token = response.id; // On récupère le token
              // On crée un champs cachée qui contiendra notre token
              frm.append($('<input type="hidden" name="stripeToken" />').val(token));
              frm.get(0).submit(); // On soumet le formulaire
            }
          });
    });
});