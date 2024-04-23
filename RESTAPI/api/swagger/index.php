<?php
//swagger : Api documentation
$doNotScan = ['swagger'];
$apiFolder = scandir(PROJECT_PATH . '/api/');
unset($apiFolder[0], $apiFolder[1]);


?>
<h3><i> Welcome To Api Documentation</i></h3>
<hr />
<p><b>BASE URL</b>: <?php echo getBaseURL(); ?></p>
<?php foreach ($apiFolder as $index => $file): ?>
    <?php if (!is_dir(PROJECT_PATH . '/api/' . $file)): ?>
        <details style="margin-top:5px;">
            <summary style="background-color:grey;color:white;border:2px solid black;cursor:pointer;width:100%;">
                <?php echo ucfirst(basename($file, '.php')); ?> Api
            </summary>
            <ol>

                <?php foreach (getApiFunctions(PROJECT_PATH . '/api/' . $file) as $index => $func_name): ?>
                    <li style="margin-top:2px;">
                        <details>
                            <summary
                                style="background-color:yellow;color:red;border:2px solid black;cursor:pointer;width:20%;border-radius:2px;">
                                <a
                                    href="<?php echo getBaseURL('api/' . basename($file, '.php')); ?>?client=swagger&method=<?php echo strtoupper(substr(basename($func_name, '.php'), strlen(basename($file, '.php')))); ?>">
                                    <?php echo ucfirst($func_name); ?></a>
                                (<span
                                    style="background-color:white;color:black;"><?php echo strtoupper(substr(basename($func_name, '.php'), strlen(basename($file, '.php')))); ?></span>)
                            </summary>


                            HTTP/1.1
                            <mark
                                style="background-color:cyan;"><?php echo strtoupper(substr(basename($func_name, '.php'), strlen(basename($file, '.php')))); ?></mark>
                            <br />
                            <br />
                            <b>Payload</b> :
                            <?php if (count(getFillableColumns(PROJECT_PATH . '/api/' . $file, $func_name)) > 0): ?>
                                <ol>
                                    <?php foreach (getFillableColumns(PROJECT_PATH . '/api/' . $file, $func_name) as $index => $fillable): ?>
                                        <li> <mark><?php echo $fillable; ?></mark></li>
                                    <?php endforeach; ?>
                                </ol>
                            <?php else: ?>
                                                                No
                            <?php endif; ?>
                            <!--URL PARAMS START BLOCK;-->
                                  <br/>
                              <b>URL-params:</b>
                            <br />
                            <ol>
                                <?php foreach (getApiparams(PROJECT_PATH . '/api/' . $file, $func_name) as $index => $header): ?>
                                    <li><?php echo $header; ?></li>
                                <?php endforeach; ?>
                            </ol>
                                
                                <!--URL PARAMS end BLOCK;-->
                                </br/>
                            <b>Headers :</b>
                            <ol>
                                <?php foreach (getApiHeaders(PROJECT_PATH . '/api/' . $file, $func_name) as $index => $header): ?>
                                    <li><?php echo $header; ?></li>
                                <?php endforeach; ?>
                            </ol>

                            <br />
                            <b>Response :</b>
                            <ol>
                                <?php foreach (getApiResponse(PROJECT_PATH . '/api/' . $file, $func_name) as $index => $response): ?>
                                    <li><?php echo $response; ?></li>
                                <?php endforeach; ?>
                            </ol>
                        </details>
                    </li>
                <?php endforeach; ?>

            </ol>
        </details>
    <?php endif; ?>
<?php endforeach; ?>