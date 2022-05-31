<?php

$servername = "localhost";
$dbusername = "trippinduke";
$dbpassword = "";
$dbname = "my_trippinduke";
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

function connect()
{
  global $conn;

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
}

function authorize($username)
{
  global $conn;

  $sql = "SELECT id, username, permission FROM users WHERE username = '" . $username . "'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
      setcookie("id", $row["id"], time() + (86400 * 30));
      setcookie("user", $row["username"], time() + (86400 * 30));
      setcookie("permission", $row["permission"], time() + (86400 * 30));
      link_cart_to_account();
    }
  } else {
    echo "Auth error";
  }
}

function unauthorize($username)
{
  if (isset($_COOKIE["id"])) {
    setcookie("id", "", time() - 3600);
    setcookie("user", "", time() - 3600);
    setcookie("permission", "", time() - 3600);
  }
}

function register($first_name, $last_name, $username, $email, $password)
{
  global $conn;

  $sql = "INSERT INTO users (first_name, last_name, username, email, password)
  VALUES ('" . $first_name . "','" . $last_name . "','" . $username . "','" . $email . "','" . md5($password) . "')";

  if ($conn->query($sql) === TRUE) {
    authorize($username);
    header("location:index.php");
  } else {
    echo "error:" . $conn->error;
  }
}

function login($username, $password)
{
  global $conn;

  $sql = "SELECT password FROM users WHERE username = '" . $username . "'";
  $result = $conn->query($sql);
  $psw = "";

  if ($result->num_rows == 1) {
    while ($row = $result->fetch_assoc()) {
      $psw = $row["password"];
    }
  } else {
    echo "Unknown error";
  }
  if (md5($password) == $psw) {
    authorize($username);
    header("location:index.php");
  } else {
    echo "<p style='background-color:red'>Invalid credentials</p>";
  }
}

function get_user($id)
{
  global $conn;

  $sql = "SELECT * FROM users WHERE id = " . $id;
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    return $result->fetch_assoc();
  } else {
    echo "Unknown error";
  }
}

function get_artists_by_genre($genre, $limit)
{
  global $conn;
  $str = "";
  $sql = "SELECT artists.name 
          FROM artists 
          JOIN products ON artists.id = products.artist_id 
          JOIN genres ON products.genre_id = genres.id 
          WHERE genres.name = '$genre'
          LIMIT $limit";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= $row["name"] . ", ";
    }
    $str .= "...";
  } else {
    echo "0 results";
  }
  return $str;
}

function get_cover_by_genre($genre)
{
  global $conn;
  $sql = "SELECT products.id AS pid 
          FROM products 
          JOIN genres ON products.genre_id = genres.id 
          WHERE genres.name = '" . $genre . "'
          ORDER BY rand()
          LIMIT 1";
  $str = "";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= "assets/covers/" . $row["pid"] . ".jpg";
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_cover()
{
  global $conn;
  $sql = "SELECT id 
          FROM products 
          ORDER BY rand()
          LIMIT 1";
  $str = "";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= "assets/covers/" . $row["id"] . ".jpg";
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_latest($limit)
{
  global $conn;
  $sql = "SELECT products.id AS pid, products.title, artists.name, products.price 
          FROM products 
          JOIN artists ON products.artist_id = artists.id 
          ORDER BY year DESC
          LIMIT $limit";
  $str = "";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= '
      <div class="item">
          <div class="thumb">
              <div class="hover-content">
                  <ul>
                      <li><a href="single-product.php?p=' . $row['pid'] . '"><i class="fa fa-eye"></i></a></li>
                      <li><a href="add_to_cart.php?action=add&p=' . $row['pid'] . '&q=1"><i class="fa fa-shopping-cart"></i></a></li>';

      if (isset($_COOKIE["permission"]) && $_COOKIE["permission"] > 1)
        $str .= '<li><a href="op_product.php?action=delete&p=' . $row['pid'] . '"><i class="fa fa-trash"></i></a></li>';

      $str .=
        '</ul>
              </div>
              <img src="assets/covers/' . $row['pid'] . '.jpg" alt="">
          </div>
          <div class="down-content">
              <h4>' . $row['title'] . '</h4>
              <span>' . $row['name'] . '</span>
              <ul class="stars">
                  <span>€' . $row['price'] . '</span>
              </ul>
          </div>
      </div>';
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_products($genre)
{
  global $conn;
  $sql = "SELECT products.id AS pid, products.title, artists.name, products.price
          FROM products 
          JOIN artists ON products.artist_id = artists.id 
          JOIN genres ON products.genre_id = genres.id ";
  if ($genre != null)
    $sql .= "WHERE genres.name = '$genre' ";
  $sql .= "ORDER BY year DESC ";
  $str = "";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= '
      <div class="col-lg-4">
        <div class="item">
            <div class="thumb">
                <div class="hover-content">
                    <ul>
                        <li><a href="single-product.php?p=' . $row['pid'] . '"><i class="fa fa-eye"></i></a></li>
                        <li><a href="add_to_cart.php?action=add&p=' . $row['pid'] . '&q=1"><i class="fa fa-shopping-cart"></i></a></li>';

      if (isset($_COOKIE["permission"]) && $_COOKIE["permission"] > 1)
        $str .= '<li><a href="op_product.php?action=delete&p=' . $row['pid'] . '"><i class="fa fa-trash"></i></a></li>';

      $str .=
        '</ul>
                </div>
                <img src="assets/covers/' . $row['pid'] . '.jpg" alt="">
            </div>
            <div class="down-content">
                <h4>' . $row['title'] . '</h4>
                <span>' . $row['name'] . '</span>
                <ul class="stars">
                    <span>€' . $row['price'] . '</span>
                </ul>
            </div>
        </div>
      </div>';
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_product($id)
{
  global $conn;
  $sql = "SELECT * 
          FROM products 
          WHERE id = $id";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
    }
  } else {
    echo "0 results";
  }
}

function get_product_attribute($id, $attribute)
{
  global $conn;
  $sql = "SELECT $attribute 
          FROM products 
          JOIN artists ON products.artist_id = artists.id 
          WHERE products.id = $id";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      return $row[$attribute];
    }
  } else {
    echo "No results";
  }
}

function new_cart()
{
  global $conn;

  $sql = "INSERT INTO carts (id)
  VALUES (NULL)";

  if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
  } else {
    echo "error:" . $conn->error;
  }
  return $last_id;
}

function get_cart_products()
{
  global $conn;
  $str = "";
  $sql = "SELECT *, contains.quantity
          FROM products 
          JOIN contains ON products.id = contains.product_id 
          WHERE contains.cart_id = " . $_COOKIE["cart"];

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= '
      <div class="col-lg-4">
        <div class="item">
            <div class="thumb">
                <div class="hover-content">
                    <ul>
                        <li><a href="single-product.php?p=' . $row['id'] . '"><i class="fa fa-eye"></i></a></li>
                        <li><a href="add_to_cart.php?action=remove&p=' . $row["id"] . '"><i class="fa fa-trash"></i></a></li>
                    </ul>
                </div>
                <img src="assets/covers/' . $row['id'] . '.jpg" alt="">
            </div>
            <div class="down-content">
                <h4>' . $row['title'] . '</h4>
                <span>Qt. ' . $row['quantity'] . '</span>
                <ul class="stars">
                    <span>€' . $row['price'] . '</span>
                </ul>
            </div>
        </div>
      </div>';
    }
  } else {
    echo "No items.";
  }
  return $str;
}

function link_cart_to_account()
{
  global $conn;

  $sql = "UPDATE users 
  SET cart_id = " . $_COOKIE['cart'] . " 
  WHERE id = " . $_COOKIE['id'];

  if ($conn->query($sql) === TRUE) {
  } else {
    echo "error:" . $conn->error;
  }
}

function cart_is_empty()
{
  global $conn;

  $sql = "SELECT count(*) 
          FROM contains 
          WHERE cart_id = " . $_COOKIE["cart"];

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    return false;
  } else {
    return true;
  }
}

function get_artists()
{
  global $conn;
  $str = "";
  $sql = "SELECT id, name 
          FROM artists
          ORDER BY name";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_genres()
{
  global $conn;
  $str = "";
  $sql = "SELECT id, name 
          FROM genres
          ORDER BY name";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function add_product($title, $artist, $genre, $year, $price, $quantity)
{
  global $conn;

  $sql = "INSERT INTO products (title, artist_id, genre_id, year, price, quantity)
  VALUES ('" . $title . "','" . $artist . "','" . $genre . "','" . $year . "','" . $price . "','" . $quantity . "')";

  if ($conn->query($sql) === TRUE) {
    $_SESSION["last_id"] = $conn->insert_id;
  } else {
    echo "error:" . $conn->error;
  }
}

function add_artist($name)
{
  global $conn;

  $sql = "INSERT INTO artists (name)
  VALUES ('" . $name . "')";

  if ($conn->query($sql) === TRUE) {
    $_SESSION["last_artist_id"] = $conn->insert_id;
  } else {
    echo "error:" . $conn->error;
  }
}

function get_last_id()
{
  global $conn;
  $str = "";
  $sql = "SELECT id
          FROM products
          ORDER BY id DESC
          LIMIT 1";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= $row["id"];
    }
  } else {
    echo "0 results";
  }
  return $str;
}

function get_user_name($id)
{
  global $conn;
  $str = "";
  $sql = "SELECT first_name, last_name
          FROM users
          WHERE id = " . $id . "
          LIMIT 1";

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= $row["first_name"] . " " . $row["last_name"];
    }
  } else {
    return "";
  }
  return $str;
}

function get_checkout_products()
{
  global $conn;
  $str = "";
  $sql = "SELECT *, contains.quantity
          FROM products 
          JOIN contains ON products.id = contains.product_id 
          WHERE contains.cart_id = " . $_COOKIE["cart"];

  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $str .= '
      <div class="item">
          <div class="thumb">
              <div class="hover-content">
                  <ul>
                      <li><a href="single-product.php?p=' . $row['id'] . '"><i class="fa fa-eye"></i></a></li>
                      <li><a href="add_to_cart.php?action=add&p=' . $row['id'] . '&q=1"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
              </div>
              <img src="assets/covers/' . $row['id'] . '.jpg" alt="">
          </div>
          <div class="down-content">
              <h4>' . $row['title'] . '</h4>
              <span>' . $row['name'] . '</span>
              <ul class="stars">
                  <span>€' . $row['price'] . '</span>
              </ul>
          </div>
      </div>';
    }
  } else {
    echo "No items.";
  }
  return $str;
}

function new_order($full_name, $address)
{
  global $conn;

  $sql = "INSERT INTO orders (full_name, cart_id, address)
  VALUES ('" . $full_name . "','" . $_COOKIE["cart"] . "','" . $address . "')";

  if ($conn->query($sql) === TRUE) {
    $_SESSION["last_id"] = $conn->insert_id;
  } else {
    echo "error:" . $conn->error;
  }
}