<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UPB AuLOG</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>

    <!-- sidebar toggle -->
    <input type="checkbox" id="nav-toggle">

    <!-- sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <h2><span class="lab la-accusoft"></span> <span>AuLOG</span></h2>
        </div>

        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="main.php"><span class="las la-igloo"></span>
                    <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="admin.php" class="active"><span class="las la-users"></span>
                    <span>Admin</span></a>
                </li>
            </ul>
        </div>
    </div>

    <!-- main content -->
    <div class="main-content">
        <!-- navigation bar -->
        <header>
                
            <!-- sidebar label and number of tags config page title -->
            <h2>
                <label for="nav-toggle"> <span class="las la-bars"></span> </label>
                Number of Tags Config
            </h2>
            
            
            <!-- site logo -->
            <div class="logo-wrapper">
                <h4>UP Baguio Library</h4>
                <small>Admin</small>
            </div>
        </header>

        <!-- primary content -->
        <main>
            <div class="recent-grid">
                <div class="Users card">
                    <!-- table title -->
                    <div class="card-header">
                        <h2><span class="las la-users"></span> Charging Time </h2>
                    </div>

                    <!-- table content -->
                    <div class="card-body">
                        <table width="100%">
                            <!-- table heading -->
                            <thead>
                                <tr>
                                    <td>Numbe of Tags</td>
                                </tr>
                            </thead>

                            <!-- table body -->
                            <tbody>
                                <?php
                                    require 'functions.php';
                                    $number_of_tags = getNumberOfTags(); // student info

                                    echo "<tr>";
                                    echo "<td>".$number_of_tags."</td>";
                                    echo "<td> <a href='number_of_tags_edit.php?
                                    number_of_tags=".$number_of_tags.
                                    "'>Edit</a></td>";
                                    echo "</tr>";
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>