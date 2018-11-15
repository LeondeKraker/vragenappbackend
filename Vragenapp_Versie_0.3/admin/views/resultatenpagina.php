<html>
    <head>

    </head>
    <?php
    // Include model:
    include VRAGEN_PLUGIN_MODEL_DIR . "/Resultaten.php";
    // declare class variable
    $resultaten = new Resultaten();
    // Set base url to current file and add page specific vars
    $base_url = get_admin_url() . 'admin.php';
    $params = array('page' => basename(__FILE__, ".php"));
    // Add params to base url
    $base_url = add_query_arg($params, $base_url);
    // Get the POST data in filtered array
   // $post_array = $vraag->getPostValues();

    ?>
    <body>
        <div id="allevragen">
        <h1>Resultaten</h1>
            <table border="1">
                <tr>
                    <th> Opleiding</th>
                    <th> User ID </th>
                    <th> Vraag </th>
                    <th> Antwoord </th>
                <?php $vragen = $vraag->getResultaten();
                foreach($vragen as $vragen2){
                    ?>
                </tr>
                <tr>
                    <td> <?php echo $vragen2->getOpleiding(); ?> </td>
                    <td> <?php echo $vragen2->getUserId(); ?> </td>
                    <td> <?php echo $vragen2->getVraag(); ?> </td>
                    <td> <?php echo $vragen2->getAntwoord(); ?> </td>
                </tr>
                <?php }?>
            </table>
        </div>
    </body>
</html>