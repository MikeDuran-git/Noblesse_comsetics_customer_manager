//expand the size of the input text 
function Expand(obj){
    if (!obj.savesize) obj.savesize=obj.size;
    obj.size=Math.max(obj.savesize,obj.value.length);
}

function modify_content(){
    //the button modify must be seen
    show_saving_button()
    // print the buttons to modify the respectives attributes
    show_change_client_name_button();
    show_change_client_tel_button();
    show_change_client_surname_button();
    show_change_client_Email_button()
    show_change_client_date_button()
    show_add_rm_rdv();
}

function save_content(){
    //the button to modify must be seen
        show_mod_button()
    // hide the buttons to modify the respectives attributes
        hide_all_change_buttons();
}

//functions to alter the modification button
function show_mod_button(){
        document.getElementById("modify_content_button").innerHTML='            <button onclick="modify_content()" style="margin-top: 2%;" >MODIFIER</button>';
}

function show_saving_button(){
        document.getElementById("modify_content_button").innerHTML=
        "<button id='save_content_button' onclick='save_content()' style='margin-top: 2%;' >Sauvegarder</button>";
}

function hide_all_change_buttons(){
    //hide the add and remove rdv buttons
    hide_add_rm_rdv();

    //hide the client_name modifiers
        hide_change_client_name_button();
        hide_client_name_input();
    
    //hide the client_tel modifiers
        hide_change_client_tel_button();
        hide_client_tel_input();
    
    //hide the client_surname modifiers
        hide_change_client_surname_button();
        hide_client_surname_input();
    
    //hide the client_Email modifiers
        hide_change_client_Email_button();
        hide_client_Email_input();
    
    //hide the client_date modifiers
        hide_change_client_date_button();
        hide_client_date_input();

}

//functions to interact with the buttons add and remove
    function hide_add_rm_rdv(){
        document.getElementById("bouton_clients").style="visibility:hidden;";
    }

    function show_add_rm_rdv(){
        document.getElementById("bouton_clients").style="visibility:visible;";
    }

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
        //hide all other buttons
            hide_change_client_tel_button();
            hide_change_client_surname_button();
            hide_change_client_Email_button();
            hide_change_client_date_button();
            hide_add_rm_rdv();
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
        //hide all other buttons
                hide_change_client_name_button();
                hide_change_client_surname_button();
                hide_change_client_Email_button();
                hide_change_client_date_button();
                hide_add_rm_rdv();
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
                //hide all other buttons
                hide_change_client_tel_button();
                hide_change_client_name_button();
                hide_change_client_Email_button();
                hide_change_client_date_button();
                hide_add_rm_rdv();
    }


//functions that interact with the clients Email
    function hide_change_client_Email_button(){
        document.getElementById("change_client_Email_button_id").style="display:none";
    }

    function show_change_client_Email_button(){
        document.getElementById("change_client_Email_button_id").style="display:true";
    }

    function hide_client_Email_input(){
        document.getElementById("Email_input").style="display:none;";
    }

    function show_client_Email_input(){
        hide_change_client_Email_button();
        document.getElementById("Email_input").style="display:true;";
        //hide all other buttons
                hide_change_client_tel_button();
                hide_change_client_surname_button();
                hide_change_client_name_button();
                hide_change_client_date_button();
                hide_add_rm_rdv();
    }

//functions that interact with the clients date
    function hide_change_client_date_button(){
        document.getElementById("change_client_date_button_id").style="display:none";
    }

    function show_change_client_date_button(){
        document.getElementById("change_client_date_button_id").style="display:true";
    }

    function hide_client_date_input(){
        document.getElementById("date_input").style="display:none;";
    }

    function show_client_date_input(){
        hide_change_client_date_button();
        document.getElementById("date_input").style="display:true;";
        //hide all other buttons
                hide_change_client_tel_button();
                hide_change_client_surname_button();
                hide_change_client_Email_button();
                hide_change_client_name_button();
                hide_add_rm_rdv();
    }
