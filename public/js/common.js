
document.addEventListener("DOMContentLoaded", function(event) { 
    if( document.getElementsByClassName("show_file_errors").length > 0 )
    {
        AddShowErrorsEvents();
    }
});

const AddShowErrorsEvents = () => {
    let error_buttons = document.getElementsByClassName("show_file_errors");
    for ( var i = 0; i < error_buttons.length; i++)
    {
        error_buttons[i].addEventListener('click', showFileErrors);
    }
};

const showFileErrors = (event) => {
    let tr_errors = document.getElementsByClassName("tr_errors");
    for ( var i = 0; i < tr_errors.length; i++)
    {
        tr_errors[i].style.display = "none";
    }

    const clicked_button = event.target;
    document.getElementById(clicked_button.dataset.errorPanelId).style.display = "block";
};