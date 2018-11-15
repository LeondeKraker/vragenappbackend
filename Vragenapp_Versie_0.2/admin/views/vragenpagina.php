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
    }
    ?>
    <body>
        <div id="vraagAanmaken" style="float: left">
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
                <?php $opleidingen = $vraag->getAlleOpleidingen();?>
                <select name="opleidingKiezen">
                <?php foreach ($opleidingen as $opleidingen2) {
                ?>
                <option name="opleiding" value="<?php echo $opleidingen2->getOpleidingId()?>"> <?php echo $opleidingen2->getOpleiding();?></option>
                <?php 
                }?> 
                </select>
                <br/>
                <br/>
                <input type="submit" name="toevoegen" value="Toevoegen">
            </form>
        </div>
        <div id="allevragen" style="float: right;">
            <table border="1">
                <tr>
                    <th> Vraag</th>
                    <th> Tijd </th>
                    <th> Opleiding </th>
                <?php $vragen = $vraag->getAlleVragen();
                foreach($vragen as $vragen2){
                    ?>
                </tr>
                <tr>
                    <td> <?php echo $vragen2->getVraagId(); ?> </td>
                </tr>
                <?php }?>
            </table>
        </div>
    </body>
</html>