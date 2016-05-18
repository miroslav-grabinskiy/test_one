/**
 * Created by m0sviatoslav on 17.05.16.
 */
function setGoogleGeocode(e,location) {
    $.getJSON( {
        url  : "https://maps.googleapis.com/maps/api/geocode/json",
        data : {
            sensor  : false,
            address : e.val()
        },
        success : function( data ) {
            if (!!data.results[0]) {

                var formattedAddress = data.results[0].formatted_address,
                    geoCode = JSON.stringify(data.results[0].geometry.location);

                e.val(formattedAddress);
                $(location).val(geoCode);
            }
        },
        error : function() {
            e.parent().addClass('has-error');
            console.log("error");
        }
    } );
}


function setCreateBtnColor() {

}