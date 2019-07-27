<?php
require_once 'process.php';
$mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysql_error($mysqli));
$result = $mysqli->query("SELECT * FROM data ORDER BY position") or die($mysqli->error);

  if(isset($_POST['update2'])) {
    foreach($_POST['position'] as $position ) {
      $index = $position[0];
      $newPosition = $position[1];

      $mysqli->query("UPDATE data SET position = '$newPosition' WHERE id = $index") or die($mysqli->error);
    }
    exit();
  }
?>

<!doctype html>
<html lang="hu">
  <head>
    <title>CRUD</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://bootswatch.com/4/simplex/bootstrap.min.css">
    
  </head>
  <body>
    <?php
    $mysqli = new mysqli('localhost', 'root', '', 'crud') or die(mysql_error($mysqli));
    $result = $mysqli->query("SELECT * FROM data ORDER BY position") or die($mysqli->error);
    ?>
      <div class="container mt-5">
        <div class="row justify-content-center">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Név</th>
                <th>Város</th>
                <th colspan="2">Művelet</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $rowCount = 0;
              while ($row = $result->fetch_assoc()): ?>
                <tr class="border" data-index="<?php echo $row['id']; ?>" data-position="<?php echo $row['position']; ?>">
                  <td> <?php echo $row['name']; ?></td>
                  <td> <?php echo $row['location']; ?></td>
                  <td>
                    <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn btn-info" >Szerkesztés</a>
                    <a href="process.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" >Törlés</a>
                  </td>
                  
                </tr>
              <?php 
                $rowCount ++; 
                endwhile;
              ?>
            </tbody>
          </table>
        </div>

        <div class="row justify-content-center">
            <form action="process.php" method="post">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <input type="hidden" name="position" value="<?php echo $rowCount; ?>">
                <div class="form-group">
                    <label for="name">Név</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>" placeholder="Mi a neve?" >
                </div>
                <div class="form-group">
                    <label for="location">Város</label>
                    <input type="text" name="location" id="location" class="form-control" value="<?php echo $location; ?>" placeholder="Hol lakik?">
                </div>
                <div class="form-group">
                  <?php if($update == true): ?>
                    <button type="submit" name="update" class="btn btn-warning">Frissítés</button>
                  <?php else: ?>
                    <button type="submit" name="save" class="btn btn-success">Mentés</button>
                  <?php endif ?>
                </div>
            </form>
        </div>
      </div>

      <?php if(isset($_SESSION['message'])): ?>

      <div class="mt-5 alert alert-<?php echo $_SESSION['msg_type']; ?>">
        <?php 
          echo $_SESSION['message']; 
          unset($_SESSION['message']);  
        ?>
      </div>
      <?php endif ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
      $(document).ready(function () {
        $('table tbody').sortable({
          update: function(event, ui) {
            $(this).children().each(function(index) {
              if($(this).attr('data-position') != (index + 1)) {
                $(this).attr('data-position', (index + 1)).addClass('updated');
              }
            });

            saveNewPositions();
          }
        });
      });

      function saveNewPositions() {
        var positions = [];
        $('.updated').each(function() {
          positions.push([$(this).attr('data-index'), $(this).attr('data-position')]);
          $(this).removeClass('updated');
        });

        $.ajax({
          url: 'index.php',
          method: 'POST',
          dataType: 'text',
          data: {
            update2: 1,
            position: positions
          }, success: function (response) {
            console.log(response);
          }
        });
      }
    </script>
  </body>
</html>