import $ from 'jquery';

function createAddFile(fileCountImages)
{
    // grab the prototype template
    let newWidget = $("#trick_images").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCountImages);
    $("#trick_images").append(newWidget);

    let newLabel = document.getElementById(`trick_images_${fileCountImages}`).labels[0];
    newLabel.innerText = `image ${fileCountImages}`;
    newLabel.classList.add('d-none');
}

$(document).ready(function(e){
    let fileCountImages = 1;
    $('#add_image').on('click', function (e) {
        e.preventDefault();
        fileCountImages++;
        createAddFile(fileCountImages);
    });

    if (!document.querySelector('#trick_images_1')) {
        createAddFile(fileCountImages);
    }

    if (document.querySelector(`#trick_images_${fileCountImages}`)) {
        let newLabel = document.getElementById(`trick_images_${fileCountImages}`).labels[0];
        newLabel.innerText = `image ${fileCountImages}`;
        newLabel.classList.add('d-none');
    }
});