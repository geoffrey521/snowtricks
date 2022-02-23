import $ from 'jquery';

function createAddFile(fileCountImages)
{
    // grab the prototype template
    let newWidget = $("#trick_photos").attr('data-prototype');
    // replace the "__name__" used in the id and name of the prototype
    newWidget = newWidget.replace(/__name__/g, fileCountImages);
    $("#trick_photos").append(newWidget);

    let newLabel = document.getElementById(`trick_photos_${fileCountImages}`).labels[0];
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

    if (!document.querySelector('#trick_photos_1')) {
        createAddFile(fileCountImages);
    }

    if (document.querySelector(`#trick_photos_${fileCountImages}`)) {
        let newLabel = document.getElementById(`trick_photos_${fileCountImages}`).labels[0];
        newLabel.innerText = `image ${fileCountImages}`;
        newLabel.classList.add('d-none');
    }
});

$('.data-delete').click(function(e) {
    let elm = this;
    e.preventDefault();
    // ask user validation
    if(confirm("Do you want to delete this media?")){
        // Send ajax request to the link with DELETE method
        fetch(this.getAttribute("href"), {
            method: "DELETE",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({"_token": this.dataset.token})
        }).then(
            // get JSON response
            response => response.json()
        ).then(data => {
            if(data.success) {
                $(elm).closest('.media-container').remove();
            }
            else
                alert(data.error);
        }).catch(e => alert(e))
    }
});

$('.promote-image').click(function(e) {
    e.preventDefault();
    if(confirm("Do you want to set this image as promoted?")){
        fetch(this.getAttribute("href"), {
            method: "POST",
            headers: {
                "X-Requested-With": "XMLHttpRequest",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({"_token": this.dataset.token})
        }).then(
            // get JSON response
            response => response.json()
        ).then(data => {
            if(data.success) {
                window.location.reload();
            }
            else
                alert(data.error);
        }).catch(e => alert(e))
    }
})