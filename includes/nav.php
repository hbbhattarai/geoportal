    <nav id='navcontainer' class="navbar navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">ZHI-CHAR INFORMATION SYSTEM</span>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if (logged_in()) {
                            echo "<li><a href='/{$root_directory}/mycontent.php'>{$_SESSION['username']}'s Content</a></li>";
                            echo "<li><a href='/{$root_directory}/logout.php'>Logout</a></li>";
                        } else {
                            echo "<li><a href='/{$root_directory}/login.php'>Login</a></li>";
                            echo "<li><a href='/{$root_directory}/register.php'>Register</a></li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
