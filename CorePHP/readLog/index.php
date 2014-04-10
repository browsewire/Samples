<html>
    <body>
        <div
            style="padding: 10px; text-align: center; border: 2px solid; width: 50%; margin-left: 25%; margin-top: 5%; height: 20%; margin-bottom: 1%;">
            <!----------------- Start - File Upload Form --------------->
            <form action="" method="post" enctype="multipart/form-data">
                <label for="file">Choose the Log File : </label>
                <input type="file" name="logFile" id="logFile"><br><br><br>
                <input type="submit" name="submit" value="Submit">
            </form>
            <!----------------- End - File Upload Form --------------->
        </div>
        <!----------------- Start - Display the Log Results --------------->
        <label style="margin-left:5%;">Log File Data : </label>
        <br/><br/>
        <?php
        //Check if the file is selected/uploaded
        if (isset($_POST['submit']) && $_FILES['logFile']['size'] > 0) {
            if ($_FILES["logFile"]["error"] > 0) {
                echo "Error: " . $_FILES["logFile"]["error"] . "<br>";
            } else {
                //Open the file for reading
                $file = fopen($_FILES['logFile']['tmp_name'], "r") or exit("Unable to open file!");
                //Read the file line-by-line until it reaches the end of file
                while (!feof($file)) {
                    //Create an array of all records
                    $arrRecords[] = fgets($file);
                }
                //close the file
                fclose($file);
            }
            //unset the POST data variable
            unset($_POST);
            //Iterate through each record to collect ips,dates and urls in corresponding arrays
            for ($i = 0; $i < count($arrRecords); $i++) {
                $record = $arrRecords[$i];

                $arrTempSplit1 = explode(' - - [', $record);
                $ip[$i] = $arrTempSplit1[0];

                $arrTempSplit2 = explode(':', $arrTempSplit1[1]);
                $date[$i] = $arrTempSplit2[0];

                $arrTempSplit3 = explode('" "', $arrTempSplit2[4]);
                $url[$i] = 'http:' . $arrTempSplit3[0];
            }

            //Create temporary storage array variables
            $arrPrevIp = array();
            $arrPrevDate = array();
            $arrPrevUrl = array();

            //Create an array variable to store Hits/Day
            $arrHitPerDay = array();

            /*----------------- Start - Get Hits/Day for each URL ----------*/
            for ($j = 0; $j < count($date); $j++) {
                if (in_array($date[$j], $arrPrevDate) && in_array($url[$j], $arrPrevUrl)) {
                    $arrHitPerDay[$date[$j]][$url[$j]] = $arrHitPerDay[$date[$j]][$url[$j]] + 1;
                } else {
                    $arrPrevDate[] = $date[$j];
                    $arrPrevUrl[] = $url[$j];
                    $arrHitPerDay[$date[$j]][$url[$j]] = 1;
                }
            }
            /*----------------- End - Get Hits/Day for each URL ----------*/
            ///Reset all the temporary array variables
            $arrPrevIp = array();
            $arrPrevDate = array();
            $arrPrevUrl = array();

            //Create an array variable to store Visitors/Day
            $arrVisitorsPerDay = array();

            /*----------------- Start - Get Visitors/Day for each URL ----------*/
            for ($j = 0; $j < count($date); $j++) {
                if (in_array($date[$j], $arrPrevDate) && in_array($url[$j], $arrPrevUrl) && in_array($ip[$j], $arrPrevIp)) {
                    $arrVisitorsPerDay[$date[$j]][$url[$j]][$ip[$j]] = $arrVisitorsPerDay[$date[$j]][$url[$j]][$ip[$j]] + 1;
                } else {
                    $arrPrevDate[] = $date[$j];
                    $arrPrevUrl[] = $url[$j];
                    $arrPrevIp[] = $ip[$j];
                    $arrVisitorsPerDay[$date[$j]][$url[$j]][$ip[$j]] = 1;
                }
            }
            /*----------------- End - Get Visitors/Day for each URL ----------*/

            //Create an array variable to store Average Hits/Visitor
            $arrAverageHitsPerVisitor = array();

            /*----------------- Start - Get Average Hits/Visitor for each URL ----------*/
            foreach ($arrHitPerDay as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    $arrAverageHitsPerVisitor[$key][$key1] = $arrHitPerDay[$key][$key1] / count($arrVisitorsPerDay[$key][$key1]);
                }
            }
            /*----------------- End - Get Average Hits/Visitor for each URL ----------*/


            ?>
            <!------------------------ Start - Display Number of Hits/Day ------------------------>
            <div style="text-align: left; width: 90%; border: 1px solid gray; margin-left: 5%;margin-top: 2%;">
                <div
                    style="text-align: center; font-weight: bold; border: 1px solid gray; background: none repeat scroll 0% 0% lightgray;">
                    Number of Hits/Day
                </div>

                <div style="text-align: center;float: left; width: 20%;border-bottom: 1px solid;">Date</div>
                <div style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px solid;">Url</div>
                <div style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px solid;">Hits</div>
                <br/>
                <?php
                foreach ($arrHitPerDay as $date => $urlHits) {
                    if (isset($date) && $date != '') {
                        foreach ($urlHits as $url => $hits) {
                            if (isset($url) && $hits != '') {
                                ?>
                                <div
                                    style="text-align: center;float: left; width: 20%;border-bottom: 1px dotted;"><?php echo $date; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo $url; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo $hits; ?></div>
                                <br/>
                            <?php
                            }
                        }
                    }
                }
                ?>
                <div style="clear:both;"></div>
            </div>
            <!------------------------ End - Display Number of Hits/Day ------------------------>

            <!------------------------ Start - Display Number of Unique Visitors/Day ------------------------>
            <div style="text-align: left; width: 90%; border: 1px solid gray; margin-left: 5%;margin-top: 2%;">
                <div
                    style="text-align: center; font-weight: bold; border: 1px solid gray; background: none repeat scroll 0% 0% lightgray;">
                    Number of Unique Visitors/Day
                </div>

                <div style="text-align: center;float: left; width: 20%;border-bottom: 1px solid;">Date</div>
                <div style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px solid;">Url</div>
                <div style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px solid;">Visitors</div>
                <br/>
                <?php
                foreach ($arrVisitorsPerDay as $date => $urlVisitors) {
                    if (isset($date) && $date != '') {
                        foreach ($urlVisitors as $url => $visitors) {
                            if (isset($url) && $visitors != '') {
                                ?>
                                <div
                                    style="text-align: center;float: left; width: 20%;border-bottom: 1px dotted;"><?php echo $date; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo $url; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo count($visitors); ?></div>
                                <br/>
                            <?php
                            }
                        }
                    }
                }
                ?>
                <div style="clear:both;"></div>
            </div>
            <!------------------------ End - Display Number of Unique Visitors/Day ------------------------>

            <!------------------------ Start - Display Number of Average Hits/Visitors ------------------------>
            <div style="text-align: left; width: 90%; border: 1px solid gray; margin-left: 5%;margin-top: 2%;">
                <div
                    style="text-align: center; font-weight: bold; border: 1px solid gray; background: none repeat scroll 0% 0% lightgray;">
                    Number of Average Hits/Visitors
                </div>

                <div style="text-align: center;float: left; width: 20%;border-bottom: 1px solid;">Date</div>
                <div style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px solid;">Url</div>
                <div style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px solid;">Average
                    Hits/Visitors
                </div>
                <br/>
                <?php
                foreach ($arrAverageHitsPerVisitor as $date => $urlHitsPerVisitors) {
                    if (isset($date) && $date != '') {
                        foreach ($urlHitsPerVisitors as $url => $hitsPerVisitor) {
                            if (isset($url) && $hitsPerVisitor != '') {
                                ?>
                                <div
                                    style="text-align: center;float: left; width: 20%;border-bottom: 1px dotted;"><?php echo $date; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 59%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo $url; ?></div>
                                <div
                                    style="text-align: center;float: left; width: 19%;margin-left: 1%;border-bottom: 1px dotted;"><?php echo $hitsPerVisitor; ?></div>
                                <br/>
                            <?php
                            }
                        }
                    }
                }
                ?>
                <div style="clear:both;"></div>
            </div>
            <!------------------------ End - Display Number of Average Hits/Visitors ------------------------>
        <?php


        } else {
            echo "<label style='margin-left:5%;'>No file uploaded yet !</label>";
        }
        ?>
        <div style="clear:both;"></div>
        <!----------------- End - Display the Log Results --------------->

    </body>
</html> 

