<!DOCTYPE html>
<?php ?>
<html lang="pl">
<?php showHead("Dodaj książkę", "Dodaj informacje o książce na serwer", "noindex"); ?>




<body>
    <?php showHeader("Dodaj książkę", "Dodaj informacje o książce na serwer"); ?>
    <?php
    showButtons('book-add');
    if ($message)
        showMessage($message, $messageType);
    ?>
    <div class="center">
 
    <?php 
      if($authorList == false) {  }
    else {
        if(!(count($authorList) > 0)) {
            echo "Brak autorów w bazie danych.";
        }else {
           
    ?>
        <form action="index.php?action=book-add" method="POST" enctype="multipart/form-data">
        <label for ="isbn">Numer isbn <br>
        <input type="text" name="isbn"> <br>
        <label for="title">Tytuł</label> <br>
        <input type="text" name = "title"> <br>
        <label for="author">Autorzy:</label><br>
        <?php
// var_dump($_POST);
    foreach($authorList as $author) {;
   
    ?>

<label for="author" value=<?php $author["id_autor"]?>><?php
echo $author['imie'] . " " . $author["nazwisko"];
?></label>
<input type="checkbox" name="author[]" value=<?php echo $author["id_autor"]?>>

<?php } }} ?>
<br>

<label for="kategoria">Kategoria:</label><br>
<select name="kategoria" >>
<?php
foreach($genreList as $genre) {;
  

?>
 <option value ='<?php echo $genre["id_kategoria"]?>' ><?php echo $genre["nazwa"] ?></option>
 <?php }?>


 </select><br>
<label for="publishingHouse">Wydawnictwo:</label><br>
<select name="publishingHouse">
<?php
foreach($wydawnictwoList as $wydawnictwo) {;
  

?>
 <option value = '<?php echo $wydawnictwo["id_wydawnictwo"] ?>
 '><?php echo $wydawnictwo["nazwa"] ?></option>
 <?php }?>
</select>
<br>
        <label for="description">Opis</label>
        <br>


        <textarea name="description" id="" cols="30" rows="10"></textarea>
        <br>
        <label for="rok">Rok</label><br>
        <input name="year" type="number"> <br>
        <label for="ilosc">Ilosc egzemplarzy</label> <br>
        <input name="ilosc" type="number">
            <br>
            <input type="hidden" name="action" value="book-add">
            <input type="submit" value="Dodaj Książke"> 

        </form>
    </div>
</body>

</html>