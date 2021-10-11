$(document).ready(function () {
    readData();
    $("#contact_form").submit(function (event) {
        var id = document.getElementById('id_field').value;
        var number = document.getElementById('number_field').value;
        var name = document.getElementById('name_field').value;
        event.preventDefault();
        if (number != "" && name != "") {
            var formData = {
                action: "add-or-update",
                id: id,
                number: number,
                name: name,
            };
            $.post("../ExeFile.php", formData, function (data) {
                document.getElementById("contact_form").reset();
                readData();
                displayMessage(data);
            });
        }
        else {
            alert('Please provide required fields.');
        }
    });
});

function readData() {
    var keywords = document.getElementById('keyword_field').value
    var formData = {
        action: "fetch-all",
        keywords: keywords
    };
    $.get("../ExeFile.php", formData, function (data) {
        document.getElementById('tbody').innerHTML = data;
    });
}

function fetchSingleContact(id) {
    var r = confirm("Are you sure to edit contact number?");
    if (r == true) {
        var formData = {
            action: "fetch-single-contact",
            id: id
        };
        $.get("../ExeFile.php", formData, function (data) {
            var obj = JSON.parse(data);
            document.getElementById('id_field').value = obj.id;
            document.getElementById('number_field').value = obj.prefix + obj.number;
            document.getElementById('name_field').value = obj.name;
        });
    }
}

function deleteSingleContact(id) {
    var r = confirm("Are you sure to delete contact number?");
    if (r == true) {
        var formData = {
            action: "delete-single-contact",
            id: id
        };
        $.get("../ExeFile.php", formData, function (data) {
            readData();
            displayMessage(data);
        });
    }
}

function displayMessage(message) {
    document.getElementById('message').innerHTML = message;
}