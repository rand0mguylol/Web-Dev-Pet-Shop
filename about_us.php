<?php session_start(); ?>
<?php $title = "About Us"; ?>
<?php require_once "./components/header.php"; ?>
<?php require_once "./components/navbar.php"; ?>
<div class="container mt-3 mb-3">
    <h1 class="text-center">About Us</h1>
    <div class="row">
        <div class="col-6 mt-3">
            <img src="./images/home/pet_owner.png" class="img-fluid rounded mx-auto d-block" alt="Pet and Owner">
        </div>
        <div class="col-6 mt-3 mb-3">
            <p class="text-justify">
                PetterTogether is a pet store dedicated to providing its customers with healthy and
                caring companions that deserve their own loving family. We aim to provide the best services related to
                all things pets. To complement this objective, we also sell a variety of high-quality products ranging
                from pet food, pet accessories, and even pet care products aimed to help these little companions live
                their best life.
            </p>
            <p class="text-justify">
                With the convenience of our customers in mind, we offer to deliver their new companions and products
                right to their doorsteps. We seek to also expand the range of services offered by our store to pet
                grooming and pet sitting so look forward to that.
            </p>
            <p class="text-justify">
                Our website is designed to be user-friendly. Responsiveness is the key to our website as we intend to
                provide the best online experience to all our valuable customers. We are certain you will find that
                our shop will be a pleasure to browse and shop through.
            </p>
        </div>
    </div>
</div>

<?php require_once "./components/footer.php"; ?>

<?php require_once "./script/general_scripts.php"; ?>
<script src="./js/aos.js"></script>
</body>

</html>