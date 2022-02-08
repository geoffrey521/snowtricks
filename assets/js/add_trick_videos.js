import $ from 'jquery';

function createAddFile(fileCount)
{
    // grab the prototype template
    var newWidget = $("#trick_videos").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCount);

    $("#trick_videos").append(newWidget);

    // Once the file is added
    $('#trick_videos___name__' + fileCount).on('change', function() {
        // Create another instance of add file button and company
        createAddFile(parseInt(fileCount)+1);
    });
}

$(document).ready(function(e){
    $('#add_video').on('click', function (e) {
        e.preventDefault();
        createAddFile(parseInt(fileCount)+1);
    });
    createAddFile(fileCount);
    fileCount++;
});