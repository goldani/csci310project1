<?php
	$tickerSymbol = $_GET['tickerSymbol'];
    $cols = array(0, 4);
    $graphData = array();
    if(($csvFile = fopen("https://www.quandl.com/api/v3/datasets/WIKI/" . $tickerSymbol . ".csv?api_key=YBpG5H4-swq98HWmE9sy", "r")) !== FALSE) {
        while(($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
            $numCols = count($data);
            $row = array();
            for($c = 0; $c < $numCols; $c++)
                if(in_array($c, $cols))
                    $row[] = $data[$c];
            $graphData[] = $row;
        }
        fclose($csvFile);
    }
    array_shift($graphData);
    echo json_encode($graphData);
?>
