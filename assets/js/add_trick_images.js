import $ from 'jquery';

function createAddFile(fileCount)
{
    // grab the prototype template
    var newWidget = $("#trick_images").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCount);
    $("#trick_images").append(newWidget);

    let newLabel = document.getElementById(`trick_images_${fileCount}`).labels[0];
    newLabel.innerText = `image ${fileCount}`;
    newLabel.classList.add('d-none');
}

$(document).ready(function(e){
    let fileCount = 1;
    $('#add_image').on('click', function (e) {
        e.preventDefault();
        fileCount++;
        createAddFile(fileCount);
    });
    createAddFile(fileCount);
});