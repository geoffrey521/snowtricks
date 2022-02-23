import $ from 'jquery';

function createAddFile(fileCountVideos)
{
    // grab the prototype template
    let newWidget = $("#trick_links").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCountVideos);
    $("#trick_links").append(newWidget);

    let newInput = document.getElementById(`trick_links_${fileCountVideos}`);
    let newLabel = newInput.labels[0];
    newInput.placeholder = 'Insert youtube or dailymotion url';
    newLabel.innerText = `video ${fileCountVideos}`;
    newLabel.classList.add('d-none');
}

$(document).ready(function(e){
    let fileCountVideos = 1;
    $('#add_video').on('click', function (e) {
        e.preventDefault();
        fileCountVideos++;
        createAddFile(fileCountVideos);
    });

    if (!document.querySelector('#trick_links_1')) {
        createAddFile(fileCountVideos);
    }

    if (document.querySelector(`#trick_links_${fileCountVideos}`)) {
        let newLabel = document.getElementById(`trick_links_${fileCountVideos}`).labels[0];
        newLabel.innerText = `video ${fileCountVideos}`;
        newLabel.classList.add('d-none');
    }
});