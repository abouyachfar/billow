jQuery(document).ready(function(){
    jQuery(".featured-home-checkbox").on("click", function(){
        var property_id = jQuery(this).data("id");
        var _value = false;

        if (jQuery(this).is(':checked')) {
            _value = true;
        }

        $.ajax({
            type: 'POST',
            datatype: 'json',
            url: "/en/admin/setFeaturedHome",
            data: {"property_id": property_id, "value": _value},
            cache: false,
            success: function (result) {

                return false;
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log('erreur');
            }
        });
    });

    jQuery('#featured-home-search').on('click', function(){
        var isFeaturedHomes = 0;

        if (jQuery('#filter-featured-checkbox').is(':checked')) {
            isFeaturedHomes = 1;
        }

        var owner = jQuery("#filter-owner-text").val();
        var property = jQuery("#filter-property-text").val();
        var city = jQuery("#filter-city-text").val();

        url = "/en/admin?menuIndex=3&routeName=searchFeaturedHomes&submenuIndex=-1&isFeaturedHomes="+isFeaturedHomes+"&owner="+owner+"&property="+property+"&city="+city;
        document.location = url;
    });
});