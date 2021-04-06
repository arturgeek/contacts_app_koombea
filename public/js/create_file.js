var fileInput = null;
var fileContents = null;

document.addEventListener("DOMContentLoaded", function(event) { 
    if( document.getElementById("mapping_panel") )
    {
        AddInputActionEvents();
    }
});

function AddInputActionEvents()
{
    fileInput = document.getElementById("contacts_file");
    if( fileInput != null )
    {
        fileInput.addEventListener('change', readFile);
    }
    document.getElementById("mapping_panel").style.display = "none";
    document.getElementById("btn_upload_file").style.display = "none";
}

const readFile = function () {
    var reader = new FileReader();
    reader.onload = function () {
        processFile(reader.result);
    };
    // start reading the file. When it is done, calls the onload event defined above.
    reader.readAsBinaryString(fileInput.files[0]);
};

const processFile = function( contents ){
    var fullPath = document.getElementById('contacts_file').value;
    if (fullPath) {
        var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
        var filename = fullPath.substring(startIndex);
        if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
            filename = filename.substring(1);
        }
        document.getElementById("name").value = filename;
    }
    getFileHeaders(contents);
};

const getFileHeaders = function( headers ){
    headers = headers.split("\n")[0].split(";");
    headers.forEach(function callback(header, index, headers) {
        console.log(header);
        const mapper_row = document.createElement("div");
        mapper_row.classList.add("mapper_row");
        const header_input = document.createElement("input");
        header_input.type = "text";
        header_input.disabled = "disabled";
        header_input.value = header;
        mapper_row.appendChild(header_input);
        mapper_row.appendChild(getHeadersMapField());
        
        const mapping_panel = document.getElementById("mapping_panel");
        mapping_panel.style.display = "block";
        mapping_panel.appendChild(mapper_row);
        document.getElementById("file_panel").style.display = "none";
    });
};

const options = { "na": "Non Applicable", "name": "Nombre", "date_of_birth": "Fecha de Nacimiento", "phone": "Telefono", "address": "Dirección", "cc_num": "Tarjeta de Crédito", "email": "Email" };
const getHeadersMapField = function(){
    let select = document.createElement("select");
    const keys = Object.keys(options);
    keys.forEach( function( key, index, keys ){
        var opt = options[key];
        var el = document.createElement("option");
        el.textContent = opt;
        el.value = key;
        select.appendChild(el);
    });
    select.addEventListener('change', validateFile);
    return select;
};

const required = ["name", "date_of_birth", "phone", "address", "cc_num", "email"];
const validateFile = function(){
    var map_rows = document.getElementsByClassName("mapper_row");
    let selected_fields = [];
    let map = {};
    for ( var i = 0; i < map_rows.length; i++)
    {
        let file_header_name = map_rows[i].children[0].value;
        let file_header_field = map_rows[i].children[1].value;
        selected_fields.push(file_header_field);
        map[file_header_field] = file_header_name;
    }
    let filtered = required.filter(value => selected_fields.includes(value));
    console.log( required.length == filtered.length, required.length, filtered );
    if( required.length == filtered.length )
    {
        document.getElementById("mapping").value = JSON.stringify(map);
        document.getElementById("btn_upload_file").style.display = "block";
    }
};