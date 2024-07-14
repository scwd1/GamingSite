<?php


// Head Navigation
/* ---------------- */

function head() {
	require('head.php');
}

function footer() {
	require('footer.php');
}

function headbar($inf) {
    echo '<nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>                        
          </button>
          <a class="navbar-brand" href="#">Next Gen Gaming Site</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Store</a></li>
            <li><a href="#">Character</a></li>
            <li><a href="#">Items</a></li>
            <li><a href="#">Quests</a></li>
            <li><a href="#">Social</a></li>
            <li><a href="#">Options</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
          </ul>
        </div>
      </div>
    </nav>';
}
?>