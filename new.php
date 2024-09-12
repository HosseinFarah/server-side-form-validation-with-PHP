<?php
error_reporting(E_ALL);
include 'debuggeri.php';
include 'db.php';
register_shutdown_function('debuggeri_shutdown');
$title = "Create New Film";

$display = "d-none";
$message = "";
$success = "success";
$lisays = $lisattiin_token = $lahetetty = false;
$errors = array();

include "virheilmoitukset.php";
echo "<script>const virheilmoitukset = $virheilmoitukset_json</script>";



$pakolliset = array("title", "description", "release_year", "language_id", "rental_duration", "rental_rate", "length", "replacement_cost", "rating", "special_features");

$title = $description = $release_year = $language_id = $rental_duration = $rental_rate = $length = $replacement_cost = $rating = $special_features = "";
$special_features_array = [];

if (isset($_POST['painike']) == true) {
    $title = $_POST["title"] ?? "";
    $kentta_1 = "title";
    if (in_array($kentta_1, $pakolliset) and empty($title)) {
        $errors[$kentta_1] = "Title is required";
    } else {
        if (isset($patterns[$kentta_1]) and !preg_match($patterns[$kentta_1], $title)) {
            $errors[$kentta_1] = "Title must have at least 3 characters and at most 255 characters, and it can contain only letters, numbers, and special characters .,!?";
        } else {
            $title = $yhteys->real_escape_string(strip_tags(trim($title)));
        }
    }

    $description = $_POST["description"] ?? "";
    $kentta_2 = "description";
    if (in_array($kentta_2, $pakolliset) and empty($description)) {
        $errors[$kentta_2] = "Description is required";
    } else {
        if (isset($patterns[$kentta_2]) and !preg_match($patterns[$kentta_2], $description)) {
            $errors[$kentta_2] = "Description must have at least 5 characters and at most 1000 characters,and it can contain only letters, numbers, and special characters .,!?";
        } else {
            $description = $yhteys->real_escape_string(strip_tags(trim($description)));
        }
    }

    $release_year = $_POST["release_year"] ?? "";
    $kentta_3 = "release_year";
    if (in_array($kentta_3, $pakolliset) and empty($release_year)) {
        $errors[$kentta_3] = "Release year is required";
    } else {
        if (isset($patterns[$kentta_3]) and !preg_match($patterns[$kentta_3], $release_year)) {
            $errors[$kentta_3] = "Release year must be bigger than 1950";
        } else {
            $release_year = $yhteys->real_escape_string(strip_tags(trim($release_year)));
        }
    }

    $language_id = $_POST["language_id"] ?? "";
    $kentta_4 = "language_id";
    if (in_array($kentta_4, $pakolliset) and empty($language_id)) {
        $errors[$kentta_4] = "Language is required";
    } else {
        if (isset($patterns[$kentta_4]) and !preg_match($patterns[$kentta_4], $language_id)) {
            $errors[$kentta_4] = "Language ei kelpaa";
        } else {
            $language_id = $yhteys->real_escape_string(strip_tags(trim($language_id)));
        }
    }

    $rental_duration = $_POST["rental_duration"] ?? "";
    $kentta_5 = "rental_duration";
    if (in_array($kentta_5, $pakolliset) and empty($rental_duration)) {
        $errors[$kentta_5] = "Rental duration is required";
    } else {
        if (isset($patterns[$kentta_5]) and !preg_match($patterns[$kentta_5], $rental_duration)) {
            $errors[$kentta_5] = "Rental duration must be between 1 and 7";
        } else {
            $rental_duration = $yhteys->real_escape_string(strip_tags(trim($rental_duration)));
        }
    }

    $rental_rate = $_POST["rental_rate"] ?? "";
    $kentta_6 = "rental_rate";
    if (in_array($kentta_6, $pakolliset) and empty($rental_rate)) {
        $errors[$kentta_6] = "Rental rate is required";
    } else {
        if (isset($patterns[$kentta_6]) and !preg_match($patterns[$kentta_6], $rental_rate)) {
            $errors[$kentta_6] = "Rental rate must be between 1 and 5";
        } else {
            $rental_rate = $yhteys->real_escape_string(strip_tags(trim($rental_rate)));
        }
    }

    $length = $_POST["length"] ?? "";
    $kentta_7 = "length";
    if (in_array($kentta_7, $pakolliset) and empty($length)) {
        $errors[$kentta_7] = "Length is required";
    } else {
        if (isset($patterns[$kentta_7]) and !preg_match($patterns[$kentta_7], $length)) {
            $errors[$kentta_7] = "Length must be between 5 and 200";
        } else {
            $length = $yhteys->real_escape_string(strip_tags(trim($length)));
        }
    }

    $replacement_cost = $_POST["replacement_cost"] ?? "";
    $kentta_8 = "replacement_cost";
    if (in_array($kentta_8, $pakolliset) and empty($replacement_cost)) {
        $errors[$kentta_8] = "Replacement cost is required";
    } else {
        if (isset($patterns[$kentta_8]) and !preg_match($patterns[$kentta_8], $replacement_cost)) {
            $errors[$kentta_8] = "Replacement cost must be between 9.99 and 29.99";
        } else {
            $replacement_cost = $yhteys->real_escape_string(strip_tags(trim($replacement_cost)));
        }
    }

    $rating = $_POST["rating"] ?? "";
    $kentta_9 = "rating";
    if (in_array($kentta_9, $pakolliset) and empty($rating)) {
        $errors[$kentta_9] = "Rating is required";
    } else {
        if (isset($patterns[$kentta_9]) and !preg_match($patterns[$kentta_9], $rating)) {
            $errors[$kentta_9] = "Rating must be G, PG, PG-13, R, or NC-17";
        } else {
            $rating = $yhteys->real_escape_string(strip_tags(trim($rating)));
        }
    }
    $special_features = isset($_POST["special_features"]) ? implode(',', $_POST["special_features"]) : '';
    $kentta_10 = "special_features";
    if (in_array($kentta_10, $pakolliset) and empty($special_features)) {
        $errors[$kentta_10] = "Special features is required";
    } else {
        // No regex validation needed for an array
        $special_features = $yhteys->real_escape_string(strip_tags(trim($special_features)));
        $special_features_array = explode(',', $special_features);
    }
    if (!empty($errors)) {
        debuggeri($errors);
    } else {
        $lisays = true;
        $display = "";
        $message = "Film successfully added!";
        $success = "success";

        $stmt = $yhteys->prepare("INSERT INTO film (title, description, release_year, language_id, rental_duration, rental_rate, length, replacement_cost, rating, special_features) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiididss", $title, $description, $release_year, $language_id, $rental_duration, $rental_rate, $length, $replacement_cost, $rating, $special_features);

        if ($stmt->execute()) {
            $message = "Film successfully added!";


            //After successful insert, reset the form
            $_POST = array();

            $title = $description = $release_year = $language_id = $rental_duration = $rental_rate = $length = $replacement_cost = $rating = $special_features = "";
            $special_features_array = [];
        } else {
            echo "Error creating film!";
        }
        $stmt->close();
    }
}





?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>

<body>
    <?php include 'nav.php'; ?>
    <div class="container">
        <div class="row">
            <h1>Create New Film</h1>
            <div id="ilmoitukset" class="col-md-12 alert alert-<?= $success; ?> alert-dismissible fade show <?= $display ?? ""; ?>" role="alert">
                <p><?= $message; ?></p>
            </div>
            <div class="col-md-12 d-flex justify-content-center align-items-center">

                <form method="post" class="row g-5" novalidate>
                    <div class="col-sm-8">
                        <label for="title" class="form-label">Title</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control <?= is_invalid('title'); ?>" name="title" id="title" title="Please enter a title." placeholder="Type your title!" value="<?= $title; ?>" pattern="<?= pattern('title'); ?>" required>
                            <div class="invalid-feedback">
                                <?= $errors['title'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="description" class="form-label">Description</label>
                        <div class="input-group has-validation">
                            <textarea class="form-control <?= is_invalid('description'); ?>" name="description" id="description" title="Please enter a description." placeholder="Type your description!" pattern="<?= pattern('description'); ?>" required><?= $description; ?></textarea>
                            <div class="invalid-feedback">
                                <?= $errors['description'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="release_year" class="form-label">Release Year</label>
                        <div class="input-group has-validation">
                            <input type="text" class="form-control <?= is_invalid('release_year'); ?>" name="release_year" id="release_year" title="Please enter a release year." placeholder="Type your release year!" value="<?= $release_year; ?>" pattern="<?= pattern('release_year'); ?>" required>
                            <div class="invalid-feedback">
                                <?= $errors['release_year'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="language_id" class="form-label">Language</label>
                        <div class="input-group has-validation">
                            <select class="form-select <?= is_invalid('language_id'); ?>" name="language_id" id="language_id" title="Please select a language." required>
                                <option value="">Select a language</option>
                                <?php
                                $query_language = "SELECT * FROM language";
                                $result_language = my_query($query_language);
                                if ($result_language->num_rows > 0) {
                                    while ($row = $result_language->fetch_assoc()) {
                                        $selected = ($language_id == $row['language_id']) ? 'selected' : '';
                                        echo "<option value='" . $row['language_id'] . "' $selected>" . $row['name'] . "</option>";
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $errors['language_id'] ?? ""; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <label for="rental_duration" class="form-label">Rental Duration</label>
                        <div class="input-group has-validation">
                            <select class="form-select <?= is_invalid('rental_duration'); ?>" name="rental_duration" id="rental_duration" required>
                                <option value="">Select a rental duration</option>
                                <?php for ($i = 1; $i <= 7; $i++): ?>
                                    <option value="<?= $i; ?>" <?= $i == $rental_duration ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $errors['rental_duration'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="rental_rate" class="form-label">Rental Rate</label>
                        <div class="input-group has-validation">
                            <input type="number" class="form-control <?= is_invalid('rental_rate'); ?>" name="rental_rate" id="rental_rate" value="<?= $rental_rate; ?>" title="Please enter a rental rate (0.99-4.99)" placeholder="Type your rental rate!" required>
                            <div class="invalid-feedback">
                                <?= $errors['rental_rate'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="length" class="form-label">Length</label>
                        <div class="input-group has-validation">
                            <input type="number" class="form-control <?= is_invalid('length'); ?>" name="length" id="length" value="<?= $length; ?>" title="Please enter a length (5-200)" placeholder="Type your length!" required>
                            <div class="invalid-feedback">
                                <?= $errors['length'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="replacement_cost" class="form-label">Replacement Cost</label>
                        <div class="input-group has-validation">
                            <input type="number" class="form-control <?= is_invalid('replacement_cost'); ?>" name="replacement_cost" id="replacement_cost" value="<?= $replacement_cost; ?>" title="Please enter a replacement cost (9.99-29.99)" placeholder="Type your replacement cost!" required>
                            <div class="invalid-feedback">
                                <?= $errors['replacement_cost'] ?? ""; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <label for="rating" class="form-label">Rating</label>
                        <div class="input-group has-validation">
                            <select class="form-select <?= is_invalid('rating'); ?>" name="rating" id="rating" required>
                                <?php
                                $ratings = array("", "G", "PG", "PG-13", "R", "NC-17");
                                foreach ($ratings as $rating_option) {
                                    $selected = ($rating_option == $rating) ? 'selected' : '';
                                    echo "<option value='$rating_option' $selected>$rating_option</option>";
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= $errors['rating'] ?? ""; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <label for="special_features" class="form-label">Special Features</label>
                        <div class="input-group has-validation">
                            <?php
                            $special_features_options = array("Trailers", "Commentaries", "Deleted Scenes", "Behind the Scenes");
                            foreach ($special_features_options as $special_feature_option) {
                                $checked = (in_array($special_feature_option, $special_features_array)) ? 'checked' : '';
                                echo "<div class='form-check'>";
                                echo "<input class='form-check-input' type='checkbox' name='special_features[]' id='$special_feature_option' value='$special_feature_option' $checked>";
                                echo "<label class='form-check-label' for='$special_feature_option'>$special_feature_option</label>";
                                echo "</div>";
                            }
                            ?>
                            <div class="invalid-feedback">
                                <?= $errors['special_features'] ?? ""; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 mb-3">
                        <button class="btn btn-primary" type="submit" name="painike">Create</button>
                    </div>
                </form>

                <?php include 'footer.php'; ?>
            </div>
        </div>
    </div>
</body>

</html>