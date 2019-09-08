
function validateForm() {    
    var parser = new DOMParser();    
        
    var button = document.querySelector('input[type=submit]');
    var form = document.getElementById('formulario');
    var inputText = document.querySelectorAll('input[type=text]');
    
    for (let index = 0; index < inputText.length; index++) {
        if (inputText[index].id == 'control_EMAIL') {
            
            inputText[index].type = 'email';
        }
    }
 
    var inputNumber = document.querySelectorAll('input[type=number]');    

    var textArea = document.getElementsByTagName('textarea')[0];  

    // test inpput number
    // var inputNumber =  inputText[0].type = "number";
    // inputNumber = inputText[0];    
    var inputEmail = document.querySelectorAll('input[type=email]');
    
    var select = document.querySelectorAll('select');
    var inputCheck = document.querySelectorAll('input[type=checkbox]');
    //var inputCheck = document.forms[0].elements['materias[]'];
    debugger
    var radioInput = document.forms[0].subscribe;    
    //inputText.oninvalid = validText(inputText);    
    button.addEventListener('click', function(event) {      
        var validated = document.getElementsByTagName("p");
        if (validated) {
            for (let index = 0; index < validated.length; index++) {
                const element = validated[index];
                var e = element; 
                if (e) {
                    e.innerHTML = "";     
                }
            }          
        } 

        if (inputText) {
            if (inputText.length > 0 && !validText(inputText )) {            
                event.preventDefault();            
            }
        }
        if (inputNumber) {
            if ( inputNumber.length > 0  && !validNumber(inputNumber) ) {
                event.preventDefault();   
            }
        }

        if (inputEmail) {            
            if (inputEmail.length > 0 && !validEmail(inputEmail) ){
                event.preventDefault();   
            }
        }
        if (inputCheck) {            
            if (inputCheck.length > 0 && !validRadio(inputCheck) ){
                event.preventDefault();
            }
        }

        if (radioInput) {                
            if (radioInput.length > 0 && !validRadio(radioInput) ){
                event.preventDefault();
            }
        }


        if (select) {
            if ( select.length > 0 && !validSelect(select) ) {
                event.preventDefault();
            }
        }

        if (textArea) {            
            if (!validTextArea(textArea)) {
                event.preventDefault();
            }
        }
  
    });
    
}

function validText(text) {
    let valid = true;
    for (let index = 0; index < text.length; index++) {
        if (text[index].id == 'control_EMAIL') {
            text[index].type = 'email';
        } else {
            if (text[index].value.length != 0 && /^[a-z\s]*$/i.test(text[index].value)) {
                text[index].style.border = "1px solid #ccc";
                valid = true;
            } else {
                addValidation(text[index]);
                valid = false;
            }
        }
    }

    return valid;
}


function validTextArea(textArea){    
    
    if (textArea.value.length <= 0) {
        console.log("ivalid text");                 
        addValidation(textArea);
        return false;
    }else{
        textArea.style.border = "1px solid #ccc";    
        return true;
    }
}

function validNumber(number) {    
    let valid = true;    
        console.log("Length numero " + number.length);
        for (let index = 0; index < number.length; index++) {          
            if (number[index].value.length == 0 && !/\D/.test(number[index].value)) {
                console.log("No es numero");
                addValidation(number[index]);
                console.log(number[index]);
                valid = false;
            } else{               
                console.log("Es numero");      
                number[index].style.border = "1px solid #ccc";                                        
                valid =  true;
            }
        }
        return valid;   
}


function validEmail(email){
    var formatEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;  
    for (let index = 0; index < email.length; index++) {
        if (email[index].value.match(formatEmail)){
            email[index].style.border = "1px solid #ccc";
            return true;  
        }else{                
            console.log("Invalid email");
            addValidation(email[index]);
            console.log(email);
            return false;
        }   
    } 
}

function validCheckbox(checkbox){
    
    let validCheck = false;
        console.log("checkboxs " + checkbox.length);
        for (let index = 0; index < checkbox.length; index++) {
            if (checkbox[index].checked) {
                checkbox[index].parentNode.style.border = "1px solid #ccc";
                validCheck = true;
            }else{      
                console.log("invalid checkbox");
                console.log(checkbox[index]);
                addValidation(checkbox[index]);      
            }
        } 
        return validCheck;   
}


function validRadio(radio) {  
    var cnt = 1;
    let validRadio = true;
    for (let index = radio.length-1; index > -1; index--) {
        if (radio[index].checked) {
            cnt = index;
            index = -1;              
            if (radio[cnt].value == null){            
                console.log("ivalid radio");                 
                addValidation(radio[index]);
                validRadio = false;
            }else {            
                radio[cnt].parentNode.style.border = "1px solid #ccc";
                validRadio = true;
            }                
        }else{
            console.log("ivalid radio");                 
            addValidation(radio[index]);
            validRadio = false;
        }
    }

    return validRadio;
  
}

function validSelect(select){
    let validSelect = true;
    for (let index = 0; index < select.length; index++) {
        if (select[index].selectedIndex == "") {
            console.log("invalid select");
            console.log(select[index]);
            addValidation(select[index]);
            validSelect = false;
        }else{
            select[index].style.border = "1px solid #ccc";
        }
    }

    return validSelect;
}

function addValidation(element){
    let validationDiv = document.createElement("p");            
    let validationTxt = document.createTextNode("Verificar el campo "+ element.getAttribute('label') + ". No puede ser vacio y debe ser de tipo " + element.type);    
    validationDiv.appendChild(validationTxt);          
    element.style.border = "1px solid red";
    document.body.insertBefore(validationDiv, document.getElementById('f_ibm'));

    if (element.type == 'checkbox' || element.type == 'radio') {
        element.parentNode.style.border =  "1px solid red";
    }
    
}
