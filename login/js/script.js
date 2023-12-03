//storing all captcha characters in array
let allCharacters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
                     'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'a', 'b', 'c', 'd',
                     'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
                     't', 'u', 'v', 'w', 'x', 'y', 'z', 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

var captcha1 = document.querySelector("#captcha_teacher");
var statusTxt1 = document.getElementById("teacher_text");
var input1 = document.getElementById("teacher_input");
var teacher_button = document.getElementById('teacher_check');
var teacher_submit = document.getElementById('teacher_submit');

function getCaptcha1(){
  for (let i = 0; i < 6; i++) { //getting 6 random characters from the array
    let randomCharacter = allCharacters[Math.floor(Math.random() * allCharacters.length)];
    captcha1.innerText += randomCharacter; //passing 6 random characters inside captcha innerText
  }
}
getCaptcha1(); //calling getCaptcha when the page open
//calling getCaptcha & removeContent on the reload btn click
function change_teacher() {
captcha1.innerText = "";
getCaptcha1();
}
function clicked_teacher() {
  if (input1.value == captcha1.innerText) {
    statusTxt1.innerHTML = "<i class='fas fa-check-circle'></i> Correct Captcha!";
    statusTxt1.style.color = "green";
    teacher_button.style.display = "none";
    teacher_submit.type = "submit";
    teacher_submit.style.display = "block";

  }else {
    statusTxt1.style.color = "red";
    statusTxt1.innerHTML = "<i class='fas fa-times-circle'></i> Wrong Captcha!";
  }
}

var captcha2 = document.querySelector("#captcha_student");
var statusTxt2 = document.getElementById("student_text");
var input2 = document.getElementById("student_input");
var student_button = document.getElementById('student_check');
var student_submit = document.getElementById('student_submit');

function getCaptcha2(){
  for (let i = 0; i < 6; i++) { //getting 6 random characters from the array
    let randomCharacter = allCharacters[Math.floor(Math.random() * allCharacters.length)];
    captcha2.innerText += randomCharacter; //passing 6 random characters inside captcha innerText
  }
}
getCaptcha2(); //calling getCaptcha when the page open
//calling getCaptcha & removeContent on the reload btn click
function change_student() {
captcha2.innerText = "";
getCaptcha2();
}
function clicked_student() {
  if (input2.value == captcha2.innerText) {
    statusTxt2.innerHTML = "<i class='fas fa-check-circle'></i> Correct Captcha!";
    statusTxt2.style.color = "green";
    student_button.style.display = "none";
    student_submit.style.display = "block";
    student_submit.type = "submit";
  }else {
    statusTxt2.style.color = "red";
    statusTxt2.innerHTML = "<i class='fas fa-times-circle'></i> Wrong Captcha!";
  }
}

  var captcha3 = document.querySelector("#captcha_parent");
  var statusTxt3 = document.getElementById("parent_text");
  var input3 = document.getElementById("parent_input");
  var parent_button = document.getElementById('parent_check');
  var parent_submit = document.getElementById('parent_submit');

  function getCaptcha3(){
    for (let i = 0; i < 6; i++) { //getting 6 random characters from the array
      let randomCharacter = allCharacters[Math.floor(Math.random() * allCharacters.length)];
      captcha3.innerText += randomCharacter; //passing 6 random characters inside captcha innerText
    }
  }
  getCaptcha3(); //calling getCaptcha when the page open
  //calling getCaptcha & removeContent on the reload btn click
  function change_parent() {
  captcha3.innerText = "";
  getCaptcha3();
  }
  function clicked_parent() {
    if (input3.value == captcha3.innerText) {
      statusTxt3.innerHTML = "<i class='fas fa-check-circle'></i> Correct Captcha!";
      statusTxt3.style.color = "green";
      parent_button.style.display = "none";
      parent_submit.style.display = "block";
      parent_submit.type = "submit";
    }else {
      statusTxt3.style.color = "red";
      statusTxt3.innerHTML = "<i class='fas fa-times-circle'></i> Wrong Captcha!";
    }
  }

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
                                 statusTxt4.innerHTML = "<i class='fas fa-check-circle'></i> Correct Captcha!";
                                 statusTxt4.style.color = "green";
                                 admin_button.style.display = "none";
                                 admin_submit.style.display = "block";
                                 admin_submit.type = "submit";
                               }else {
                                 statusTxt4.style.color = "red";
                                 statusTxt4.innerHTML = "<i class='fas fa-times-circle'></i> Wrong Captcha!";
                               }
                             }
