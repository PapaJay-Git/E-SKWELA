<div id="create_question" style="display: none;">
  <h5>Question Creation</h5>
<label for="cars">Quiz Types:</label>
<select name="quizChosenType" id="cars" onchange="leaveChange(this)">
  <option disabled selected value> -- options -- </option><?php
  // loop for dropdown option,
  while ($valueType = mysqli_fetch_assoc($quizTypes)) {?>
  <option value="<?php echo $valueType['quiz_type_id']; ?>"><?php echo $valueType['type_title'] ?></option><?php
  }?>
</select>
<!-- True or false form -->
<?php $one = 1; ?>
  <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $one ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="TF" style="display: none;">
    <label>True or False</label><br>
    <label>Question</label><br>
    <textarea name="TFQ" maxlength="250" style="width: 100%; height: 100px;" required></textarea><br>
    <input type="radio" name="TFcorrect" value="true" required>
    <label>TRUE</label>
    <input type="radio" name="TFcorrect" value="false">
    <label>FALSE</label><br>
    <label>Points</label>
    <input type="number" name="TFpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
    <input type="submit" class="btn-success" name="TF_Submit" value="Save">
  </form>
<!-- Multiple choice form -->
  <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $one ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="multi" style="display: none;">
    <label>Multiple Choice</label><br>
    <label>Question</label><br>
    <textarea name="MCQ" style="width: 100%; height: 100px;" required></textarea><br>
    <label>Choices</label><br>
    A: <input type="radio" name="multi_correct" value="A" required>
    <textarea name="A" style="width: 80%; height: 70px;" required></textarea><br>
    B: <input type="radio" name="multi_correct" value="B">
    <textarea name="B" style="width: 80%; height: 70px;" required></textarea><br>
    C: <input type="radio" name="multi_correct" value="C">
    <textarea name="C" style="width: 80%; height: 70px;" required></textarea><br>
    D: <input type="radio" name="multi_correct" value="D">
    <textarea name="D" style="width: 80%; height: 70px;" required></textarea><br>
    <label>Points</label>
    <input type="number" name="Multipoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
    <input type="submit" class="btn-success" name="Multi_Submit" value="Save">
  </form>
<!-- Enumeration form -->
  <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $one ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="enume" style="display: none;">
    <label>Enumeration</label><br>
    <label>Question</label><br>
    <textarea name="ENUMQ" style="width: 100%; height: 100px;" required></textarea><br>
    <label for="box2">Case Sensitive: </label>
    <input type="checkbox" name="check" value="checked" id="box2"><br>
    <label>Answer/s</label>
    <select name="enumNumbers" id="enumChoices" onchange="choicesChange(this)">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5">5</option>
    </select><br>
    <div id="A1" style="display: block;">
    <textarea id="A11" name="A1" style="width: 80%; height: 70px;" required></textarea>
    <input id="A1_enumpoints" type="number" style="width: 17%;" name="A1_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required><br>
    </div>
    <div id="B2" style="display: none;">
    <textarea id="A12" name="B2" style="width: 80%; height: 70px;"></textarea>
    <input id="B2_enumpoints" type="number" style="width: 17%;"name="B2_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"<br>
    </div>
    <div id="C3" style="display: none;">
    <textarea id="A13" name="C3" style="width: 80%; height: 70px;"></textarea>
    <input id="C3_enumpoints" type="number" style="width: 17%; " name="C3_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
    </div>
    <div id="D4" style="display: none;">
    <textarea id="A14" name="D4" style="width:80%; height: 70px;"></textarea>
    <input id="D4_enumpoints" type="number" style="width: 17%;" name="D4_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
    </div>
    <div id="E5" style="display: none;">
    <textarea id="A15" name="E5" style="width: 80%; height: 70px;"></textarea>
    <input id="E5_enumpoints" type="number" style="width: 17%;" name="E5_Enumpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points"><br>
    </div>
    <input type="submit" class="btn-success" name="Enum_Submit" value="Save">
  </form>
  <!-- Identification form -->
  <form class="form-horizontal" action="quiz_add_query.php?view_id=<?php echo $one ?>&quiz_id=<?php echo $quiziddd ?>&tc_id=<?php echo $iddd ?>" method="post" id="iden" style="display: none;">
    <label>Identification</label><br>
    <label>Question</label><br>
    <textarea name="IDNQ" style="width: 100%; height: 100px;" required></textarea><br>
    <label for="box1">Case Sensitive: </label>
    <input type="checkbox" name="check" value="checked" id="box1"><br>
    <label>Answer</label><br>
    <textarea name="answerIDN"  style="width: 100%; height: 100px;" required></textarea><br>
    <label>Points</label>
    <input type="number" name="IDENpoints" min="1" max="100" onpaste="return false;" onDrag="return false" onDrop="return false" autocomplete="off" placeholder="points" required></p>
    <input type="submit" class="btn-success" name="Iden_Submit" value="Save">
  </form>
</div>
