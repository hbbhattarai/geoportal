    <nav id='navcontainer' class="navbar navbar-fixed-top" style="height:20px">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand"> GEOSPATIAL BHUTAN | <a>Druk Geo-Portal</a></span>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                
                <ul class="nav navbar-nav navbar-right">
                     <li><a href="public.php">Portal</a></li>
                     <li><a href="contact.php">Contact</a></li>
                    <?php
                        if (logged_in()) {
                            echo "<li><a href='./mycontent.php'>{$_SESSION['username']}'s Content</a></li>";
                            echo "<li><a href='./logout.php'>Logout</a></li>";
                        } else {
                            echo "<li><a href='./login.php'>Login</a></li>";
                            echo "<li><a href='./register.php'>Register</a></li>";
                        }
                    ?>
                         
                   
                </ul>
            </div>
        </div>
    </nav>
