var load = function (s, ident) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            s.getElementById('f_ibm').innerHTML = this.responseText;
            validateForm()
            console.log('success' + this.status);
        } else {
            console.log('error' + this.status)
        }
    };
    xhttp.open("GET", "getForm/?form=" + ident, true);
    xhttp.send();
}
function validateForm() {
    var button = document.querySelector('input[type=submit]');
    
    for (let index = 0; index < inputText.length; index++) {
        if (inputText[index].id == 'control_EMAIL') {

            inputText[index].type = 'email';
        }
    }

    var inputText = document.querySelectorAll('input[type=text]');
    var inputNumber = document.querySelectorAll('input[type=number]');
    var textArea = document.getElementsByTagName('textarea')[0];
    var inputEmail = document.querySelectorAll('input[type=email]');
    var select = document.querySelectorAll('select');
    var inputCheck = document.querySelectorAll('input[type=checkbox]');
    var radioInput = document.querySelectorAll('input[type=radio]');

    button.addEventListener('click', function (event) {
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
            if (inputText.length > 0 && !validText(inputText)) { event.preventDefault() }
        }
        if (inputNumber) {
            if (inputNumber.length > 0 && !validNumber(inputNumber)) { event.preventDefault() }
        }
        if (inputEmail) {
            if (inputEmail.length > 0 && !validEmail(inputEmail)) { event.preventDefault() }
        }
        if (inputCheck) {
            if (inputCheck.length > 0 && !validCheckbox(inputCheck)) { event.preventDefault() }
        }
        if (radioInput) {
            if (radioInput.length > 0 && !validRadio(radioInput)) { event.preventDefault() }
        }
        if (select) {
            if (select.length > 0 && !validSelect(select)) { event.preventDefault() }
        }
        if (textArea) {
            if (!validTextArea(textArea)) { event.preventDefault(); }
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


function validTextArea(textArea) {
    if (textArea.value.length <= 0) {
        addValidation(textArea);
        return false;
    } else {
        textArea.style.border = "1px solid #ccc";
        return true;
    }
}

function validNumber(number) {
    let valid = true;
    for (let index = 0; index < number.length; index++) {
        if (number[index].value.length == 0 && !/\D/.test(number[index].value)) {
            addValidation(number[index]);
            valid = false;
        } else {
            number[index].style.border = "1px solid #ccc";
            valid = true;
        }
    }
    return valid;
}


function validEmail(email) {
    var formatEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    for (let index = 0; index < email.length; index++) {
        if (email[index].value.match(formatEmail)) {
            email[index].style.border = "1px solid #ccc";
            return true;
        } else {
            addValidation(email[index]);
            return false;
        }
    }
}

function validCheckbox(checkbox) {
    
    let validCheck = false;
        for (let index = 0; index < checkbox.length; index++) {
            if (checkbox[index].checked) {
                checkbox[index].parentNode.style.border = "1px solid #ccc";
                validCheck = true;
            } else{      
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
    for (let index = radio.length - 1; index > -1; index--) {
        if (radio[index].checked) {
            cnt = index;
            index = -1;
            if (radio[cnt].value == null) {
                addValidation(radio[index]);
                validRadio = false;
            } else {
                radio[cnt].parentNode.style.border = "1px solid #ccc";
                validRadio = true;
            }
        } else {
            addValidation(radio[index]);
            validRadio = false;
        }
    }
    return validRadio;
}

function validSelect(select) {
    let validSelect = true;
    for (let index = 0; index < select.length; index++) {
        if (select[index].selectedIndex == "") {
            addValidation(select[index]);
            validSelect = false;
        } else {
            select[index].style.border = "1px solid #ccc";
        }
    }
    return validSelect;
}

function addValidation(element) {
    let validationDiv = document.createElement("p");
    let validationTxt = document.createTextNode("Verificar el campo " + element.getAttribute('label') + ". No puede ser vacio y es de tipo " + element.type);
    validationDiv.appendChild(validationTxt);
    element.style.border = "1px solid red";
    document.body.insertBefore(validationDiv, document.getElementById('f_ibm'));

    if (element.type == 'checkbox' || element.type == 'radio') { element.parentNode.style.border = "1px solid red" }
}