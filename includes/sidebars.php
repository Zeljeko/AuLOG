<?php

if ($page === 'main') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a href='main.php' class='active'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                        <a href='#' id='admin'><span class='las la-user'></span>
                        <span>Admininstrator Options</span></a>
                    </li>
                    <li>
                    <div id='passwordField' style='display: none;'>
                        <div class='input-pass-wrapper'>
                            <input type='password' id='passwordInput' placeholder='Enter password'>
                        </div>
                    </div>
                    </li>
                    <div id='adminOptions' style='display:none;'>
                        <li>
                            <a href='student.php'><span class='las la-users'></span>
                            <span>Student Information</span></a>
                        </li>
                        <li>
                            <a href='log.php'><span class='las la-list'></span>
                            <span>Charging Logs</span></a>
                        </li>
                        <li>
                            <a href='config.php'><span class='las la-cog'></span>
                            <span>Configuration</span></a>
                        </li>
                        <li>
                            <a href='report.php'><span class='las la-chart-line'></span>
                            <span>Reports</span></a>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    ";

} elseif ($page === 'studInfo') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a href='main.php'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a class='active' href='student.php'><span class='las la-users'></span>
                        <span>Student Information</span></a>
                    </li>
                    <li>
                        <a href='log.php'><span class='las la-list'></span>
                        <span>Charging Logs</span></a>
                    </li>
                    <li>
                        <a href='config.php'><span class='las la-cog'></span>
                        <span>Configuration</span></a>
                    </li>
                    <li>
                        <a href='report.php'><span class='las la-chart-line'></span>
                        <span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    ";
}  elseif ($page === 'log') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a href='main.php'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a href='student.php'><span class='las la-users'></span>
                        <span>Student Information</span></a>
                    </li>
                    <li>
                        <a class='active' href='log.php'><span class='las la-list'></span>
                        <span>Charging Logs</span></a>
                    </li>
                    <li>
                        <a href='config.php'><span class='las la-cog'></span>
                        <span>Configuration</span></a>
                    </li>
                    <li>
                        <a href='report.php'><span class='las la-chart-line'></span>
                        <span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    ";
}  elseif ($page === 'config') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a href='main.php'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a href='student.php'><span class='las la-users'></span>
                        <span>Student Information</span></a>
                    </li>
                    <li>
                        <a href='log.php'><span class='las la-list'></span>
                        <span>Charging Logs</span></a>
                    </li>
                    <li>
                        <a class='active' href='config.php'><span class='las la-cog'></span>
                        <span>Configuration</span></a>
                    </li>
                    <li>
                        <a href='report.php'><span class='las la-chart-line'></span>
                        <span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    ";
}  elseif ($page === 'reports') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a href='main.php'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a href='student.php'><span class='las la-users'></span>
                        <span>Student Information</span></a>
                    </li>
                    <li>
                        <a href='log.php'><span class='las la-list'></span>
                        <span>Charging Logs</span></a>
                    </li>
                    <li>
                        <a href='config.php'><span class='las la-cog'></span>
                        <span>Configuration</span></a>
                    </li>
                    <li>
                        <a class='active' href='report.php'><span class='las la-chart-line'></span>
                        <span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    ";
}  elseif ($page === 'tagEdit') {
    echo "
    <!-- sidebar toggle -->
        <input type='checkbox' id='nav-toggle' checked>

        <!-- sidebar -->
        <div class='sidebar'>
            <div class='sidebar-brand'>
                <h2><span class='las la-atom'></span> <span>AuLOG</span></h2>
                <small>UPB Library Automated Charging Log System System</small>
            </div>

            <div class='sidebar-menu'>
                <ul>
                    <li>
                        <a class='active' href='main.php'><span class='las la-database'></span>
                        <span>Dashboard</span></a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a href='student.php'><span class='las la-users'></span>
                        <span>Student Information</span></a>
                    </li>
                    <li>
                        <a href='log.php'><span class='las la-list'></span>
                        <span>Charging Logs</span></a>
                    </li>
                    <li>
                        <a href='config.php'><span class='las la-cog'></span>
                        <span>Configuration</span></a>
                    </li>
                    <li>
                        <a href='report.php'><span class='las la-chart-line'></span>
                        <span>Reports</span></a>
                    </li>
                </ul>
            </div>
        </div>
    ";
}  

?>