window.onload = function()
{
    var backButton = document.getElementById('back-button');
    var forwButton = document.getElementById('forw-button');

    var minId = parseInt(backButton.getAttribute("minimum-id"));
    var maxId = parseInt(forwButton.getAttribute("maximum-id"));

    var getpreviouspage = backButton.getAttribute('onclick');
    var getnextpage = forwButton.getAttribute('onclick');

    var prevId = parseInt(getpreviouspage.split("=")[2]);
    var nextId = parseInt(getnextpage.split("=")[2]);

    if (prevId < minId){
        backButton.disabled = true;
    }

    if (nextId > maxId){
        forwButton.disabled = true;
    }
}