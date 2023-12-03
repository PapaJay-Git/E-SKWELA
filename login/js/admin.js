//storing all captcha characters in array
let allCharacters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
                     'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd',
                     'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
                     't', 'u', 'v', 'w', 'x', 'y', 'z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                     var captcha4 = document.querySelector("#captcha_admin");
                     var statusTxt4 = document.getElementById("admin_text");
                     var input4 = document.getElementById("admin_input");
                     var admin_button = document.getElementById('admin_check');
                     var admin_submit = document.getElementById('admin_submit');

                     function getCaptcha4(){
                       for (let i = 0; i < 6; i++) { //getting 6 random characters from the array
                         let randomCharacter = allCharacters[Math.floor(Math.random() * allCharacters.length)];
                         captcha4.innerText += randomCharacter; //passing 6 random characters inside captcha innerText
                       }
                     }
                     getCaptcha4(); //calling getCaptcha when the page open
                     //calling getCaptcha & removeContent on the reload btn click
                     function change_admin() {
                     captcha4.innerText = "";
                     getCaptcha4();
                     }
                     function clicked_admin() {
                       if (input4.value == captcha4.innerText) {
                         statusTxt4.innerHTML = "Correct Captcha!";
                         statusTxt4.style.color = "green";
                         admin_button.style.display = "none";
                         admin_submit.style.display = "block";
                         admin_submit.type = "submit";
                       }else {
                         statusTxt4.style.color = "red";
                         statusTxt4.innerHTML = "Wrong Captcha!";
                       }
                     }
