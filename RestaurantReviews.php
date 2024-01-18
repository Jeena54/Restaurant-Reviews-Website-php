<?php
$showData = false;
$selectedRes = $minValue = $maxValue = '';
if (isset($_POST["btnSubmitRestaurant"]) && ($_POST["btnSubmitRestaurant"] != "0")) {
    $selectedRes = $_POST['selectedRestaurant'];
    $showData = true;
} else {
    echo "";
    $selectedRes = "";
}

include("./common/header.php");
?>
<section class="container">
    <h1 class="text-center">Online Restaurant Review</h1>
    <br>
    <p>Select a restaurant from the dropdown list to view/edit its review</p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group row">
            <label for="selectedRestaurant" class="col-md-3 col-form-label">Restaurant : </label>
            <div class="col-md-5">
                <select name="selectedRestaurant" id="selectedRestaurant" onchange="restaurantChoosen()"
                    class="form-control">
                    <option value="0">Select...</option>
                    <?php
                    $restaurantReviewsData = simplexml_load_file('restaurant_reviews.xml');
                    foreach ($restaurantReviewsData->restaurant as $myRestaurant) {
                        echo '<option value="' . $myRestaurant->restaurant_name . '"';
                        if (isset($_POST['selectedRestaurant']) && ($_POST['selectedRestaurant'] == $myRestaurant->restaurant_name)) {
                            echo "selected='selected'";
                        }
                        echo ">" . $myRestaurant->restaurant_name . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <button type="submit" hidden id="submitbtn" name='btnSubmitRestaurant'></button>
    </form>
</section>


<?php
if ($showData == true) {
    $restaurantReviewsData = simplexml_load_file('restaurant_reviews.xml');
    foreach ($restaurantReviewsData as $restaurantData) {
        if ($selectedRes == $restaurantData->restaurant_name) { ?>
            <section class="container showDataSection">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                    <div class="form-group row">
                        <label for="street" class="col-md-3 col-form-label">Street Address:</label>
                        <div class="col-md-5">
                            <input type="text" id="street" class="form-control"
                                value="<?php echo $restaurantData->address->street ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="city" class="col-md-3 col-form-label">City:</label>
                        <div class="col-md-5">
                            <input type="text" id="city" class="form-control" value="<?php echo $restaurantData->address->city ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="province" class="col-md-3 col-form-label">Province:</label>
                        <div class="col-md-5">
                            <input type="text" id="province" class="form-control"
                                value="<?php echo $restaurantData->address->province ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="postalCode" class="col-md-3 col-form-label">Street:</label>
                        <div class="col-md-5">
                            <input type="text" id="postalCode" class="form-control"
                                value="<?php echo $restaurantData->address->postal_code ?>">

                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="summary" class="col-md-3 col-form-label">Summary:</label>
                        <div class="col-md-5">
                            <textarea name="summary" id="summary" cols="30" rows="10"
                                class="form-control"><?php echo $restaurantData->summary ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rating" class="col-md-3 col-form-label">Rating : </label>
                        <div class="col-md-5">
                            <select name="rating" id="rating" class="form-control">
                                <?php
                                $ratings = range(1, 5);
                                for ($x = 1; $x <= 5; $x++) {
                                    echo '<option value="' . $x . '"';
                                    if ($x == $restaurantData->rating) {
                                        echo "selected='selected'";
                                    }
                                    echo ">" . $x . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 col-form-label"></div>
                        <div class="col-md-5" style="width: 180px;">
                            <input type='submit' class='btn btn-primary' name='save' value='Save Changes' />
                        </div>
                    </div>
                </form>
            </section>

        <?php }
    }
    ?>



<?php } else {
    echo "";
}
?>

<script>
    function restaurantChoosen() {
        mySubmitButton = document.getElementById("submitbtn");
        mySubmitButton.click();
    }
</script>
<?php
include('./common/footer.php');