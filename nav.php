<div class="topnav" id="myTopnav">
        <a href="http://localhost/php/sakila/" class="active">Home</a>
        <div class="dropdownmenu">
            <a href="#" class="dropbtn">Categories of movies</a>
            <div class="dropdown-content">
                <?php
                $sql_cat = "SELECT name FROM category";
                $result_cat = my_query($sql_cat);
                if ($result_cat->num_rows > 0) {
                    while ($row_cat = $result_cat->fetch_assoc()) {
                        echo "<a href='#'>" . $row_cat['name'] . "</a>";
                    }
                }
                ?>
            </div>
        </div>
        <a href="http://localhost/php/sakila/new.php">Add new movie</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </div>