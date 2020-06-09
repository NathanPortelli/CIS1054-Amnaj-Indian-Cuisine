window.onload = function(){
    selectedObject = document.getElementById('typeSelect');
    dishtype = selectedObject.getAttribute("dataitem");
    for (i = 1; i < selectedObject.length; i++){
        if (selectedObject.options[i].text == dishtype){
            selectedObject.selectedIndex = i;
            break;
        }
    }   
}