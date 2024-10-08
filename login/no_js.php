<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Javascript disabled</title>
    <style media="screen">
    *{
    transition: all 0.6s;
}

html {
    height: 100%;
}

body{
    font-family: 'Lato', sans-serif;
    color: #888;
    margin: 0;
}

#main{
    display: table;
    width: 100%;
    height: 100vh;
    text-align: center;
}

.fof{
	  display: table-cell;
	  vertical-align: middle;
}

.fof h1{
	  font-size: 50px;
	  display: inline-block;
	  padding-right: 12px;
	  animation: type .5s alternate infinite;
}

@keyframes type{
	  from{box-shadow: inset -3px 0px 0px #888;}
	  to{box-shadow: inset -3px 0px 0px transparent;}
}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.button5 {background-color: #555555;} /* Black */
    </style>
  </head>
  <body>
    <div id="main">
    	<div class="fof">
        		<h1>Error 404</h1><br>
            <h1>Please turn on Javascript on your Browser!</h1><br>
            <button type="button" class="button button5" onClick="goBack()">DONE</button>
    	</div>
</div>
  </body>
</html>
<script>
function goBack() {
window.history.back();
}
</script>
