var modals;

window.addEventListener("load", (e)=> {
    modals = document.querySelectorAll(".modal");
    let close_modal = document.querySelectorAll(".close_modal");
    close_modal.forEach(function(button) {
        button.addEventListener("click", function () {
            modals.forEach(modal => {
                if(modal.contains(button)) modal.style.display = "none";
            });
        });
    });
});

function openModal(id) {
    console.log(id);
    let modal = document.querySelector("#" + id);
    if(modal != null) {
        modal.style.display = "flex";
    }
    else {
        throw "Unable to access the requested modal";
    }
}