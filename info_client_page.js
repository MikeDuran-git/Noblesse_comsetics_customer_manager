//expand the size of the input text 
function Expand(obj){
    if (!obj.savesize) obj.savesize=obj.size;
    obj.size=Math.max(obj.savesize,obj.value.length);
}

function modify_content(){
    document.getElementById("modify_content_button").innerHTML=
    "<button id='save_content_button' onclick='save_content()' style='margin-top: 2%;' >Sauvegarder</button>";

    // print the buttons to modify the respectives attributes
    show_change_client_name_button();
    show_change_client_tel_button();
    show_change_client_surname_button();

}

function save_content(){
    document.getElementById("modify_content_button").innerHTML='            <button onclick="modify_content()" style="margin-top: 2%;" >MODIFIER</button>';
    // hide the buttons to modify the respectives attributes
    //hide the client_name modifiers
        hide_change_client_name_button();
        hide_client_name_input();
    
    //hide the client_tel modifiers
        hide_change_client_tel_button();
        hide_client_tel_input();
    
    //hide the client_surname modifiers
        hide_change_client_surname_button();
        hide_client_surname_input();
    

}
//functions that interact with the clients name
    function hide_change_client_name_button(){
        document.getElementById("change_client_name_button_id").style="display:none";
    }

    function show_change_client_name_button(){
        document.getElementById("change_client_name_button_id").style="display:true";
    }

    function hide_client_name_input(){
        document.getElementById("name_input").style="display:none;";
    }

    function show_client_name_input(){
        hide_change_client_name_button();
        document.getElementById("name_input").style="display:true;";
    }

//functions that interact with the clients telephone number
    function hide_change_client_tel_button(){
        document.getElementById("change_client_tel_button_id").style="display:none";
    }

    function show_change_client_tel_button(){
        document.getElementById("change_client_tel_button_id").style="display:true";
    }

    function hide_client_tel_input(){
        document.getElementById("tel_input").style="display:none;";
    }

    function show_client_tel_input(){
        hide_change_client_tel_button();
        document.getElementById("tel_input").style="display:true;";
    }

//functions that interact with the clients surname
    function hide_change_client_surname_button(){
        document.getElementById("change_client_surname_button_id").style="display:none";
    }

    function show_change_client_surname_button(){
        document.getElementById("change_client_surname_button_id").style="display:true";
    }

    function hide_client_surname_input(){
        document.getElementById("surname_input").style="display:none;";
    }

    function show_client_surname_input(){
        hide_change_client_surname_button();
        document.getElementById("surname_input").style="display:true;";
    }
