window.onload = () => {
// manage delete buttons
    let links = document.querySelectorAll("[data-delete]");
// links loop
    for(link of links){
        // add event on click
        link.addEventListener("click", function(e) {
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
                    if(data.success)
                        this.parentElement.remove();
                    else
                        alert(data.error);
                }).catch(e => alert(e))
            }
        });
    }

}