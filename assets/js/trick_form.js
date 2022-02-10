import $ from "jquery";

$(document).ready(function(){
    $('#add_medias').on('click', function (e) {
        e.preventDefault();
        $("#edit_media_fields").removeClass('d-none');
    });
});