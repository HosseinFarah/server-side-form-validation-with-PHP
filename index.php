<?php
include 'debuggeri.php';
include 'db.php';
register_shutdown_function('debuggeri_shutdown');

$title = "Sakila Main Page";

if (isset($_GET['btn'])) {
    $searchKey = $_GET['searchKey'];
    $searchKey = $yhteys->real_escape_string(strip_tags($_GET['searchKey']));
    $sql = "SELECT title,description,release_year,rating FROM film WHERE title LIKE '%$searchKey%' OR description LIKE '%$searchKey%'";
    $result = my_query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <h1>Sakila Film Search</h1>
        <h5 class="alert alert-primary">
            <?php
            $query = 'SELECT count(*) as count FROM film';
            $res = my_query($query);
            if ($res->num_rows > 0) {
                $row = $res->fetch_assoc();
                echo "Total films found: " . $row['count'];
            } else {
                echo "No films found";
            }

            ?>
        </h5>
        <form class="row g-3 needs-validation" novalidate>
            <div class="col-md-4">
                <label for="searchKey" class="form-label">Search</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control" name="searchKey" id="searchKey" title="Please enter a search key." placeholder="Enter the name or description of the movie!" required>
                    <div class="invalid-feedback">
                    Enter the name or description of the movie!
                    </div>
                </div>
            </div>
            <div class="col-12 mt-3">
                <button class="btn btn-primary" type="submit" name="btn">Search</button>
            </div>
        </form>
        <p>
            <?php
            if (isset($searchKey)) {
                $count = $result->num_rows;
                echo "Result: " . "<strong>" . $count . "</strong>" . " records found.";
            }
            ?>
        <div class="row mt-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Release Year</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($result)) {
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['release_year'] . "</td>";
                                echo "<td>" . $row['rating'] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No films found</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html>