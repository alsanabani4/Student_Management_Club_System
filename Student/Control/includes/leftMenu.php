<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php if ($page == 'dashboard') {
                                echo 'active';
                            } ?>">
                    <a href="index.php"><i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>

                <!-- <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"> <i class="menu-icon fa fa-user"></i>Admin</a>
                            <ul class="sub-menu children dropdown-menu">
                                <li><i class="fa fa-plus"></i><a href="createAdmin.php">Add Administrator</a></li>
                                <li><i class="fa fa-eye"></i><a href="viewAdmin.php">View Administrator</a></li>
                            </ul>
                        </li> -->


















                <li class="menu-title">RESULT</li>
                <li class="menu-item-has-children dropdown <?php if ($page == 'result') {
                                                                echo 'active';
                                                            } ?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-file"></i>Scores</a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-plus"></i> <a href="createScore.php">Add Score</a></li>
                        <li><i class="fa fa-eye"></i> <a href="viewScore.php">View Score</a></li>


                    </ul>
                </li>



                <li class="menu-title">ACCOUNT</li>

                <li>
                    <a href="logout.php"> <i class="menu-icon fa fa-power-off"></i>Logout </a>
                </li>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>