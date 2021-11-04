<div class="search-container mx-auto">
  <form action="" class=" " method="GET">
      <div class = "d-flex d-inline justify-content-between search-form">
        <input type="text" class="form-control search-bar d-inline q" id="inputFirstName" placeholder="Search for Item" name="q" value="<?php if (isset($q)) echo $q ?>">
        <!-- <input type="hidden" value="<?php echo $category; ?>" name="category"> -->
        <button class="btn search text-end" name="searchItem"><img src="./svg/search (1).svg" alt=""></button>
      </div>   
      <div class="form-check mt-3">
        <input class="form-check-input" type="radio" name="itemType" value = "pet" id="itemTypePet" checked>
        <label class="form-check-label" for="itemTypePet">
          Pet
        </label>
      </div>
      <div class="form-check mt-3">
        <input class="form-check-input" type="radio" name="itemType" value = "product" id="itemTypeProduct" >
        <label class="form-check-label" for="itemTypeProduct">
          Product
        </label>
      </div>  
  </form>                      
</div>