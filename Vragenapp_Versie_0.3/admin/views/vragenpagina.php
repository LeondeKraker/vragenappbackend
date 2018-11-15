<html>
    <head>

    </head>
    <?php
    // Include model:
    include VRAGEN_PLUGIN_MODEL_DIR . "/Vraag.php";
    // declare class variable
    $vraag = new Vraag();
    // Set base url to current file and add page specific vars
    $base_url = get_admin_url() . 'admin.php';
    $params = array('page' => basename(__FILE__, ".php"));
    // Add params to base url
    $base_url = add_query_arg($params, $base_url);
    // Get the GET data in filtered array
    $get_array = $vraag->getGetValues();
    //*/
    // Keep track of current action.
    $action = false;
    if (!empty($get_array)) {
        // Check actions
        if (isset($get_array['action'])) {
            $action = $vraag->handleGetAction($get_array);
        }
    }
    // Get the POST data in filtered array
    $post_array = $vraag->getPostValues();
    // Collect Errors
    $error = false;
    // Check the POST data
    if (!empty($post_array)) {
        // Check the add form:
        $add = false;
        if (isset($post_array['toevoegen'])) {
            // Save event categorie
            $result = $vraag->voegVraagToe($post_array);
            if ($result) {
                // Save was succesfull
                $add = true;
            } else {
                // Indicate error
                $error = true;
            }
        }
        if (isset($post_array['bijwerken'])) {
            // update
            $vraag->werkVraagBij($post_array);
        }
    }
    ?>
    <body>
        <div id="vraagAanmaken" style="float: left; margin-top: 10px;">
            <h1> Vragenpagina </h1>
            <h3> Maak een vraag aan </h3>
            <form action="<?php echo $base_url; ?>" method="post">
                Vraag <br/>
                <input type="text" name="vraag">
                <br/>
                Datum en tijd <br/>
                <input type="text" name="verstuurTijd">
                <br/>
                <br/>
                <input type="radio" name="vraagSoort" id="openVraag" value="1"> Open vraag
                <br/>
                <br/>
                <input type="radio" name="vraagSoort" id="geslotenVraag" value="0"> Gesloten vraag
                <br/>
                <br/>
                <?php $opleidingen = $vraag->getAlleOpleidingen(); ?>
                <select name="opleidingKiezen">
                <?php foreach ($opleidingen as $opleidingen2) {
                    ?>
                <option name="opleiding" value="<?php echo $opleidingen2->getOpleidingId() ?>"> <?php echo $opleidingen2->getOpleiding(); ?></option>
                
                <?php 
            } ?> 
                </select>
                <br/>
                <br/>
                <input type="submit" name="toevoegen" value="Toevoegen">
            </form>
        </div>
        <div id="allevragen" style="float: right; margin-right: 200px; margin-top: 100px;">
        <h2>Vragenoverzicht</h2>
        <?php
        echo (($action == 'bijwerken') ? '<form action="' . $base_url . '" method= "post">' : '')
        ?>
            <table border="1">
                <tr>
                    <th> Vraag</th>
                    <th> Tijd </th>
                    <th> Opleiding </th>
                    <th> Soort </th>
                <?php $vragen = $vraag->getAlleVragen();
                foreach ($vragen as $vragen2) {
                     // Create update link
                    $params = array('action' => 'bijwerken', 'vraagId' => $vragen2->getVraagId());
                    // variabele met welke soort vraag het is (open/gesloten)
                    $vraagSoort = $vragen2->getVraagSoort();
                    // Add params to base url update link
                    $upd_link = add_query_arg($params, $base_url);
                    // Create delete link
                    $params = array('action' => 'verwijderen', 'vraagId' => $vragen2->getVraagId());
                    // Add params to base url delete link
                    $del_link = add_query_arg($params, $base_url);

                    if ($vraagSoort === "1") {
                        $vraagSoort = "Open vraag";
                    } else {
                        $vraagSoort = "Gesloten vraag";
                    }

                    if (($action == 'bijwerken') && ($vragen2->getVraagId() == $get_array['vraagId'])) {
                        ?>
                </tr>
                <tr>
                    <td style="display:none;"> <input type="hidden" name="vraagId" value=" <?php echo $vragen2->getVraagId(); ?>"></td>
                    <td><input type="text" name="vraag" value="<?php echo $vragen2->getVraag(); ?>"></td>
                    <td><input type="text" name="verstuurTijd" value="<?php echo $vragen2->getVerstuurTijd(); ?>"></td>
                    <td> <select name="opleiding">
                        <?php foreach ($opleidingen as $opleidingenUpdate) {
                            ?>
                        <option name="opleiding" value="<?php echo $opleidingenUpdate->getOpleidingId() ?>"> <?php echo $opleidingenUpdate->getOpleiding(); ?></option>
                        <?php 
                    } ?> 
                    </select>
                    </td>
                    <td>
                        <?php if ($vraagSoort == "Open vraag"){ ?>
                        <input type="radio" name="vraagSoort" id="openVraag" value="1" checked="checked"> Open vraag
                        <?php } else{ ?>
                            <input type="radio" name="vraagSoort" id="openVraag" value="1"> Open vraag
                        <?php } ?>
                        <br />
                        <?php if ($vraagSoort == "Gesloten vraag"){ ?>
                        <input type="radio" name="vraagSoort" id="geslotenVraag" value="1" checked="checked"> Gesloten vraag
                        <?php } else{ ?>
                            <input type="radio" name="vraagSoort" id="geslotenVraag" value="0"> Gesloten vraag
                        <?php } ?>
                    </td>
                    <td><input type="submit" name="bijwerken" value="bijwerken"></td>
                </tr>
                    <?php 
                } else { ?>
                <tr>
                    <td> <?php echo $vragen2->getVraag(); ?> </td>
                    <td> <?php echo $vragen2->getVerstuurTijd(); ?> </td>
                    <td> <?php echo $vragen2->getOpleiding(); ?> </td>
                    <td> <?php echo $vraagSoort ?> </td>
                    <td style="display:none;"> <?php echo $vragen2->getVraagId(); ?></td>
                    <?php 
                }
                if ($action !== 'bijwerken') { ?>
                    <td><a href="<?php echo $upd_link; ?>">Bijwerken</a></td>
                    <td><a href="<?php echo $del_link; ?>">Verwijderen</a></td>
                    <?php 
                }
                ?>
                </tr>
                <?php 
            } ?>
            </table>

        </div>
    </body>
</html>