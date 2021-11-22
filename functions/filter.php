<style>

</style>

<?php 
  if(isset($_GET['cat'])) {
    if($_GET['cat'] == 1) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bananas'>Bananas</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Oranges'>Oranges</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Apples'>Apples</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cherries'>Cherries</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Strawberries'>Strawberries</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Blueberries'>Blueberries</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Blackberries'>Blackberries</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Raspberries'>Raspberries</a>";
    } elseif($_GET['cat'] == 2) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Broccoli'>Broccoli</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Lettuce'>Lettuce</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Onions'>Onions</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cauliflower'>Cauliflower</a>";
    } elseif($_GET['cat'] == 3) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Chicken'>Chicken</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Beef'>Beef</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Pork'>Pork</a>";
    } elseif($_GET['cat'] == 4) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Salmon'>Salmon</a>";
    } elseif($_GET['cat'] == 5) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Prawns'>Prawns</a>";
    } elseif($_GET['cat'] == 6) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Rolls'>All Rolls</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bread'>All Breads</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Tiger'>Tiger Bread</a>";
    } elseif($_GET['cat'] == 7) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Whole'>Whole</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Skimmed'>Skimmed</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Semi'>Semi Skimmed</a>";
    } elseif($_GET['cat'] == 8) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Salty'>Salty</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Unsalted'>Unsalted</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Lurpak'>Lurpak</a>";
    } elseif($_GET['cat'] == 9) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro='></a>";
    } elseif($_GET['cat'] == 10) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Medium'>Medium</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Large'>Large</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Free'>Free Range</a>";
    } elseif($_GET['cat'] == 11) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Soft'>Soft Cheese</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Mozzarella'>Mozzarella</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Mature'>Mature</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Mild'>Mild</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Extra'>Extra Mature</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cathedral'>Cathedral City</a>";
    } elseif($_GET['cat'] == 12) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Low'>Low Fat</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Free'>Fat Free</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Danone'>Danone</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Activia'>Activia</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=No'>Zero Sugar</a>";
    } elseif($_GET['cat'] == 13) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Chocolate'>All Chocolate</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Eclairs'>Eclairs</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Donuts'>Donuts</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Egg'>Egg Custard Tarts</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Choux'>Choux Buns</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Limoncello'>Limoncello</a>";
    } elseif($_GET['cat'] == 14) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Spaghetti'>Spaghetti</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Lasagne'>Lasagne</a>";
    } elseif($_GET['cat'] == 15) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Corn'>Corn Flakes</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cheerios'>Cheerios</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Kelloggs'>Kellogs</a>";
    } elseif($_GET['cat'] == 16) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Beans'>Baked Beans</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Soup'>All Soups</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Tomato Soup'>Tomato Soups</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Chicken Soup'>Chicken Soup</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Heinz'>Heinz</a>";
    } elseif($_GET['cat'] == 17) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Grain'>Long Grain</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Brown'>Brown</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Basmati'>Basmati</a>";
    } elseif($_GET['cat'] == 18) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Penne'>Penne</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Fusilli'>Fusilli</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Napolina'>Napolina</a>";
    } elseif($_GET['cat'] == 19) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Dolmio'>Dolmio</a>";
    } elseif($_GET['cat'] == 20) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Oregano'>Oregano</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Mixed'>Mixed Herbs</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Salt'>Salt</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Pepper'>Pepper</a>";
    } elseif($_GET['cat'] == 21) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Gold'>Gold</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Roast'>Roast</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Classic'>Classic</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Ground'>All Ground</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Decaf'>Decaffeinated</a>";
    } elseif($_GET['cat'] == 22) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=PG'>PG Tips</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Yorkshire'>Yorkshire Tea</a>";
    } elseif($_GET['cat'] == 23) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Malted'>Malted Milk</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Tea'>Rich Tea</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Custard'>Custard Creams</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bourbon'>Bourbon</a>";
    } elseif($_GET['cat'] == 24) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Coke'>Coke</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cola'>Cola</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Pepsi'>Pepsi</a>";
    } elseif($_GET['cat'] == 25) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Whisky'>Whisky</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Gin'>Gin</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Vodka'>Vodka</a>";
    } elseif($_GET['cat'] == 26) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bathroom'>Bathroom</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bac'>Anti-Bacterial</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Flash'>All Flash</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Cif'>All Cif</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Dettol'>All Dettol</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Fairy'>All Fairy</a>";
    } elseif($_GET['cat'] == 27) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Bar'>Bar Soap</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Body'>Body Wash</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Dove'>All Dove</a>";
    } elseif($_GET['cat'] == 28) {
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Size 5'>Size 5</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Size 6'>Size 6</a>";
	echo "<a class='filter_link' href='all_products.php?location=$location&pro=Pampers'>All Pampers</a>";
    }

  } 
?>