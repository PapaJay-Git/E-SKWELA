function showHe2llo(e){
  var hello = document.getElementById('123');
  if (e == 1) {
    hello.value = "1";
  }else if (e == 2) {
    hello.value = "2";
  }else if (e == 3) {
    hello.value = "3";
  }else if (e == 4) {
    hello.value = "4";
  }else {
    hello.style.display = "none";
  }
}
var create_questions = document.getElementById('create_question');
var created_questions = document.getElementById('created_questions');
var share_quiz = document.getElementById('share_quiz');
function showcreated(){
      created_questions.style.display = "block";
      create_questions.style.display = "none";
      share_quiz.style.display = "none"
}
function showcreatenow(){
      created_questions.style.display = "none";
      create_questions.style.display = "block";
      share_quiz.style.display = "none"
}
function showquiz(){
      created_questions.style.display = "none";
      create_questions.style.display = "none";
      share_quiz.style.display = "block"
}

function showhide() {
  //details form
  var hide = document.getElementById('formm');
  //question form
  var hide2 = document.getElementById('quess');
  var dtls = document.getElementById('detailss');

  if (hide.style.display === "none") {
      hide.style.display = "block";
      dtls.value = "Show Questions";
      hide2.style.display = "none";
      } else {
       hide.style.display = "none";
       dtls.value = "Show Details";
       hide2.style.display = "block";
      }
}
var questions = document.getElementById('cars');
var optn = questions.options[questions.selectedIndex].text;

var tf = document.getElementById('TF');
var mc = document.getElementById('multi');
var enu = document.getElementById('enume');
var idef = document.getElementById('iden');
function leaveChange(select){
  if(select.value==1){
    tf.style.display = "block";
    mc.style.display = "none";
    enu.style.display = "none";
    idef.style.display = "none";
  }else if (select.value==2) {
    tf.style.display = "none";
    mc.style.display = "block";
    enu.style.display = "none";
    idef.style.display = "none";
  }else if (select.value==3) {
    tf.style.display = "none";
    mc.style.display = "none";
    enu.style.display = "block";
    idef.style.display = "none";
  }else if (select.value==4) {
    tf.style.display = "none";
    mc.style.display = "none";
    enu.style.display = "none";
    idef.style.display = "block";
  }else{
    alert("No selected value");
    tf.style.display = "none";
    mc.style.display = "none";
    enu.style.display = "none";
    idef.style.display = "none";
  }
}

function choicesChange(select){
  var one1 = document.getElementById('A1');
  var one2 = document.getElementById('B2');
  var one3 = document.getElementById('C3');
  var one4 = document.getElementById('D4');
  var one5 = document.getElementById('E5');
  if(select.value==1){
    one1.style.display = "block";
    one2.style.display = "none";
    one3.style.display = "none";
    one4.style.display = "none";
    one5.style.display = "none";
    document.getElementById("A11").required = true;
    document.getElementById("A12").required = false;
    document.getElementById("A13").required = false;
    document.getElementById("A14").required = false;
    document.getElementById("A15").required = false;
    document.getElementById("A1_enumpoints").required = true;
    document.getElementById("B2_enumpoints").required = false;
    document.getElementById("C3_enumpoints").required = false;
    document.getElementById("D4_enumpoints").required = false;
    document.getElementById("E5_enumpoints").required = false;
  }else if (select.value==2) {
    one1.style.display = "block";
    one2.style.display = "block";
    one3.style.display = "none";
    one4.style.display = "none";
    one5.style.display = "none";
    document.getElementById("A11").required = true;
    document.getElementById("A12").required = true;
    document.getElementById("A13").required = false;
    document.getElementById("A14").required = false;
    document.getElementById("A15").required = false;
    document.getElementById("A1_enumpoints").required = true;
    document.getElementById("B2_enumpoints").required = true;
    document.getElementById("C3_enumpoints").required = false;
    document.getElementById("D4_enumpoints").required = false;
    document.getElementById("E5_enumpoints").required = false;
  }else if (select.value==3) {
    one1.style.display = "block";
    one2.style.display = "block";
    one3.style.display = "block";
    one4.style.display = "none";
    one5.style.display = "none";
    document.getElementById("A11").required = true;
    document.getElementById("A12").required = true;
    document.getElementById("A13").required = true;
    document.getElementById("A14").required = false;
    document.getElementById("A15").required = false;
    document.getElementById("A1_enumpoints").required = true;
    document.getElementById("B2_enumpoints").required = true;
    document.getElementById("C3_enumpoints").required = true;
    document.getElementById("D4_enumpoints").required = false;
    document.getElementById("E5_enumpoints").required = false;
  }else if (select.value==4) {
    one1.style.display = "block";
    one2.style.display = "block";
    one3.style.display = "block";
    one4.style.display = "block";
    one5.style.display = "none";
    document.getElementById("A11").required = true;
    document.getElementById("A12").required = true;
    document.getElementById("A13").required = true;
    document.getElementById("A14").required = true;
    document.getElementById("A15").required = false;
    document.getElementById("A1_enumpoints").required = true;
    document.getElementById("B2_enumpoints").required = true;
    document.getElementById("C3_enumpoints").required = true;
    document.getElementById("D4_enumpoints").required = true;
    document.getElementById("E5_enumpoints").required = false;
  }else if (select.value==5) {
    one1.style.display = "block";
    one2.style.display = "block";
    one3.style.display = "block";
    one4.style.display = "block";
    one5.style.display = "block";
    document.getElementById("A11").required = true;
    document.getElementById("A12").required = true;
    document.getElementById("A13").required = true;
    document.getElementById("A14").required = true;
    document.getElementById("A15").required = true;
    document.getElementById("A1_enumpoints").required = true;
    document.getElementById("B2_enumpoints").required = true;
    document.getElementById("C3_enumpoints").required = true;
    document.getElementById("D4_enumpoints").required = true;
    document.getElementById("E5_enumpoints").required = true;
  }else{
    alert("No selected value");
    one1.style.display = "none";
    one2.style.display = "none";
    one3.style.display = "none";
    one4.style.display = "none";
    one5.style.display = "none";
  }
}
