 <?php


$row = 1;
if (($handle = fopen("quotes.csv", "r")) !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
    $size = count($stocksInfo);
    echo '------------------------------'. "\n";
    $row++;

    $data[0] = str_replace('"', "", $data[0]);
    $data[1] = str_replace('"', "", $data[1]);
    $results .= $data[0] . " " . $data[1] . " " . $data[2] . " " . $data[3] . " " . $data[4] . "\n";
    //Stock information from API

    echo $results;
  }
  fclose($handle);
}

?>
