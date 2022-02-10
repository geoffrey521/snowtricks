import $ from 'jquery';

function createAddFile(fileCount)
{
    // grab the prototype template
    let newWidget = $("#trick_videos").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCount);
    $("#trick_videos").append(newWidget);

    let newInput = document.getElementById(`trick_videos_${fileCount}`);
    let newLabel = newInput.labels[0];
    newInput.placeholder = 'https://www.youtube.com/watch?v=V9xuy-rVj9w';
    newLabel.innerText = `video ${fileCount}`;
    newLabel.classList.add('d-none');

}

$(document).ready(function(e){
    let fileCount = 1;
    $('#add_video').on('click', function (e) {
        e.preventDefault();
        fileCount++;
        createAddFile(fileCount);
    });
    createAddFile(fileCount);

});